<?php
require_once 'ControladorGeneral.php';
require_once '../../modelo/Profesor.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorProfesor
 *
 * @author Flaco
 */
class ControladorFactura extends ControladorGeneral{
    public function buscar() {
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_PROFESORES);

        $arrayPersonas = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayPersonas;
    }

    public function eliminar($id) {
        try {
            $idProfesorArray = ["id"=>$id];
            $resultadoUltimoProfesor = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_PROFESOR, $idProfesorArray);
            $profesor = $resultadoUltimoProfesor->fetch(PDO::FETCH_ASSOC);
            $idPro = $profesor['id'];
            $idProArray = array("id"=>$idPro);
            $idDomi = $profesor["FK_domicilio"];
            $idDomiArray = array("id"=>$idDomi);
            $resultadoBorrarPersona = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_PERSONA, $idProArray);
            $resultadoBorrarDomicilio = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_DOMICILIO, $idDomiArray);
            return $resultadoBorrarPersona->fetch(PDO::FETCH_ASSOC);     
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo "<br>Error: ".$excepcionGral->getTraceAsString().'<br>';
        }
    }

    public function buscarX ($datos){
        try {
            if ($datos['criterio']=="calle") { //si busca por Calle "todas las personas que vivan en la calle san juan"
                $resulDomi = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_PROFESOR_POR_CALLE, array($datos['valor']."%"));
                $arrayXdomis = $resulDomi->fetchAll(PDO::FETCH_ASSOC);
                return $arrayXdomis;
            }else{ //si busca por nombre, apellido o legajo
                $query = str_replace("calle LIKE ?", "persona.".$datos['criterio']." LIKE '".$datos['valor']."%'", DbSentencias::BUSCAR_PROFESOR_POR_CALLE);
                $resultado = $this->refControladorPersistencia->ejecutarSentencia($query);
                $arrayProfesor = $resultado->fetchAll(PDO::FETCH_ASSOC);
                return $arrayProfesor;
            }
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }
    
    public function guardar($datosCampos) {
        

//        if($nombre == "" || $apellido  == "" || $legajo == "" || $calle == "" || $numero == "") {
//            return new ApiError("Todos los datos deben estar completos!");
//        }
        //$parametros = array($nombre,$apellido, "-----",$legajo, "A",$calle, $numero);

        $resultado = null;
        if($datosCampos['id'] == 0) { // si id=0 entonces es agregar
//            $this->refControladorPersistencia->get_conexion->beginTransaction();
            $paramDomi = ["calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero']];
            $res = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_DOMICLIO, $paramDomi);
            $ultDomi = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_DOMICILIO);
            $idDom = $ultDomi->fetchColumn();
            $paramProf = ["nombre"=>$datosCampos['nombre'], "apellido"=>$datosCampos['apellido'], "titulo"=>$datosCampos['titulo'], "legajo"=>0, "tipo"=>"P", "FK_domicilio"=>$idDom];

            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_PERSONA, $paramProf);
            if (!$resul) {
                echo 'no hizo el insert de profesor';
            }
            $idStat = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_PROFESOR);
            $id = $idStat->fetchColumn();
            //echo $id."---------------------------------------<br>";
            
//            if ($ultDomi == false || $res == false || $resul == false) {
//                $this->refControladorPersistencia->get_conexion->rollBack();
//            }else{
//                $this->refControladorPersistencia->get_conexion->commit();
//            }
            
        } else { //si entra acá es para modificar
            $resProfesor = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_PROFESOR,array($datosCampos['id']));
            $fkDomi = $resProfesor->fetchColumn(6);
            $paramPro = ["nombre"=>$datosCampos['nombre'], "apellido"=>$datosCampos['apellido'],"titulo"=>$datosCampos['titulo'],"calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero'], "id"=>$datosCampos['id']];
            $resUpdate = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_PROFESOR_CON_DOMICILIO, $paramPro);
            $id = $datosCampos['id'];
        }
        $respuesta = $this->getPersona($id);
        $domici = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_DOMICILIO, array($respuesta['FK_domicilio']));
        $domArr = $domici->fetch(PDO::FETCH_ASSOC);
        $respuesta['calle']=$domArr['calle'];
        $respuesta['numero']=$domArr['numero'];
        return $respuesta;
    }
    
    public function getPersona($id) {
      $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_PROFESOR,array($id));
      $profesor = $statement->fetch();
      
      if (!$profesor) {
        echo 'ERROR AL BUSCAR EL PROFESOR';
      }
      return $profesor;
    }

    public function agregar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }
}

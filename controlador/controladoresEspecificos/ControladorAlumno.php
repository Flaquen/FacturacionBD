<?php
require_once 'ControladorGeneral.php';
require_once '../../modelo/Alumno.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorAlumno
 *
 * @author Flaco
 */
class ControladorAlumno extends ControladorGeneral{
    

    public function buscar() {
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_ALUMNOS);

        $arrayPersonas = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayPersonas;
    }

    public function eliminar($id) {
        try {
            $resultadoUltimoAlumno = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_ALUMNO, Array($id));
            $alumno = $resultadoUltimoAlumno->fetch(PDO::FETCH_ASSOC);
            $idAlu = $alumno['id'];
            $idAluArray = array("id"=>$idAlu);
            $idDomi = $alumno["FK_domicilio"];
            $idDomiArray = array("id"=>$idDomi);
            $resultadoBorrarPersona = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_PERSONA, $idAluArray);
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
                $resulDomi = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_ALUMNO_POR_CALLE, array($datos['valor']."%"));
                $arrayXdomis = $resulDomi->fetchAll(PDO::FETCH_ASSOC);
                return $arrayXdomis;
            }else{ //si busca por nombre, apellido o legajo
                $query = str_replace("calle LIKE ?", "persona.".$datos['criterio']." LIKE '".$datos['valor']."%'", DbSentencias::BUSCAR_ALUMNO_POR_CALLE);
                $resultado = $this->refControladorPersistencia->ejecutarSentencia($query);
                $arrayAlumnos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                return $arrayAlumnos;
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
            $paramDomi = ["calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero']];
            $res = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_DOMICLIO, $paramDomi);
            $ultDomi = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_DOMICILIO);
            $idDom = $ultDomi->fetchColumn();
            $param = ["nombre"=>$datosCampos['nombre'], "apellido"=>$datosCampos['apellido'], "titulo"=>"-----", "legajo"=>$datosCampos['legajo'], "tipo"=>"A", "FK_domicilio"=>$idDom];
            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_PERSONA, $param);
            $id = $this->refControladorPersistencia->getUltimoId();

//            $this->refControladorPersistencia->get_conexion->beginTransaction();
            $paramDomi = ["calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero']];
            $res = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_DOMICLIO, $paramDomi);
            $ultDomi = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_DOMICILIO);
            $idDom = $ultDomi->fetchColumn();
            $param = ["nombre"=>$datosCampos['nombre'], "apellido"=>$datosCampos['apellido'], "titulo"=>"-----", "legajo"=>$datosCampos['legajo'], "tipo"=>"A", "FK_domicilio"=>$idDom];
            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_PERSONA, $param);
            $id = $this->refControladorPersistencia->getUltimoId();
            
        } else { //si entra acá es para modificar
            $resAlumno = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_ALUMNO,array($datosCampos['id']));
            $fkDomi = $resAlumno->fetchColumn(6);
            $paramAlu = ["nombre"=>$datosCampos['nombre'], "apellido"=>$datosCampos['apellido'],"legajo"=>$datosCampos['legajo'],"calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero'], "id"=>$datosCampos['id']];
            $resUpdate = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_ALUMNO_CON_DOMICILIO, $paramAlu);
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
      $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_ALUMNO,array($id));
      $alumno = $statement->fetch();
      
      if (!$alumno) {
        echo 'ERROR AL BUSCAR EL ALUMNO';
      }
      return $alumno;
    }

    public function agregar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }

}

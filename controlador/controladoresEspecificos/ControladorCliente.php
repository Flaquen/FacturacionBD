<?php
require_once 'ControladorGeneral.php';
require_once '../../modelo/Cliente.php';
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
class ControladorCliente extends ControladorGeneral{
    

    public function buscar() {
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_CLIENTES);

        $arrayPersonas = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayPersonas;
    }

    public function eliminar($id) {
        try {
            $resultadoCliente = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_CLIENTE, Array($id));
            $cliente = $resultadoCliente->fetch(PDO::FETCH_ASSOC);
            $idCli = $cliente['id'];
            $idCliArray = array("id"=>$idCli);
            $resultadoBorrarPersona = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_CLIENTE, $idCliArray);
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
            
            
            $hoy = getdate(); //saco la fecha para creacion y modificacion
            $fecha = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']; //armo con la fecha un timestamp
            $param = ["nombre_cliente"=>$datosCampos['nombre'], "apellido_cliente"=>$datosCampos['apellido'], 
                "cuil_cliente"=>$datosCampos['cuil'], "iva_cliente"=>$datosCampos['iva'],
                "id_usuario"=>2,"creacion_cliente"=>"2015-05-31 00:01:02","modificacion_cliente"=>"2015-05-31 00:01:02","estado_cliente"=>"A"];
            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_CLIENTE, $param);
            $id = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_CLIENTE);
            
        } /*else { //si entra acá es para modificar
            $resAlumno = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_ALUMNO,array($datosCampos['id']));
            $fkDomi = $resAlumno->fetchColumn(6);
            $paramAlu = ["nombre"=>$datosCampos['nombre'], "apellido"=>$datosCampos['apellido'],"legajo"=>$datosCampos['legajo'],"calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero'], "id"=>$datosCampos['id']];
            $resUpdate = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_ALUMNO_CON_DOMICILIO, $paramAlu);
            $id = $datosCampos['id'];
        }*/
        $respuesta = $this->getCliente($id);
//        $domici = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_DOMICILIO, array($respuesta['FK_domicilio']));
//        $domArr = $domici->fetch(PDO::FETCH_ASSOC);
//        $respuesta['calle']=$domArr['calle'];
//        $respuesta['numero']=$domArr['numero'];
        return $respuesta;
    }
    
    public function getCliente($id) {
      $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_CLIENTE,array($id));
      $cliente = $statement->fetch();
      
      if (!$cliente) {
        echo 'ERROR AL BUSCAR EL CLIENTE';
      }else{
          return $cliente;
      }
      
    }

    public function agregar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }

}

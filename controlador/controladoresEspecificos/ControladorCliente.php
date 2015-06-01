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
            $resultadoBorrarCliente = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_CLIENTE, array($id));
            return $resultadoBorrarCliente->fetch(PDO::FETCH_ASSOC);     
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo "<br>Error: ".$excepcionGral->getTraceAsString().'<br>';
        }
    }

    public function buscarX ($datos){
        try {
            //si busca por nombre, apellido o CUIL
            $query = str_replace("id_cliente = ?", $datos['criterio']." LIKE '".$datos['valor']."%'", DbSentencias::BUSCAR_UN_CLIENTE);
            $resultado = $this->refControladorPersistencia->ejecutarSentencia($query);
            $arrayClientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
            return $arrayClientes;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function guardar($datosCampos) {
        
        $hoy = getdate(); //saco la fecha para creacion y modificacion
        $fecha = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']; //armo con la fecha un timestamp
        if($datosCampos['id'] == 0) { // si id=0 entonces es agregar
            $param = ["nombre_cliente"=>$datosCampos['nombre'], "apellido_cliente"=>$datosCampos['apellido'], 
                "cuil_cliente"=>$datosCampos['cuil'], "iva_cliente"=>$datosCampos['IVA'],
                "id_usuario"=>2,"creacion_cliente"=>$fecha,"modificacion_cliente"=>$fecha,"estado_cliente"=>"A"];
            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_CLIENTE, $param);
            $ultimoCliente = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_CLIENTE);
            $ultimoId = $ultimoCliente->fetchColumn();
            $respuesta = $this->getCliente($ultimoId);
        }else { //si entra acá es para modificar
            $param = ["nombre_cliente"=>$datosCampos['nombre'], "apellido_cliente"=>$datosCampos['apellido'], 
                "cuil_cliente"=>$datosCampos['cuil'], "iva_cliente"=>$datosCampos['IVA'],
                "id_usuario"=>2, "modificacion_cliente"=>$fecha,"id_cliente"=>$datosCampos['id']];
            $resUpdate = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_CLIENTE, $param);
            $respuesta = $this->getCliente($datosCampos['id']);
        }
        
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

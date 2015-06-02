<?php
require_once 'ControladorGeneral.php';
require_once '../../modelo/Producto.php';
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
class ControladorProducto extends ControladorGeneral{
    

    public function buscar() {
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_PRODUCTOS);

        $arrayProductos = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayProductos;
    }

    public function eliminar($id) { //ojo que tiene foreign keys ---CAMBIAR
        try {
            $resultadoBorrarCliente = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_PRODUCTO, array($id));
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
            $query = str_replace("id_producto = ?", $datos['criterio']." LIKE '".$datos['valor']."%'", DbSentencias::BUSCAR_UN_PRODUCTO);
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
            $param = ["descripcion_producto"=>$datosCampos['descripcion'], "id_usuario"=>2, 
                "creacion_producto"=>$fecha,"modificacion_producto"=>$fecha,"estado_producto"=>"A"];
            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_PRODUCTO, $param);
            $ultimoProducto = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_PRODUCTO);
            $ultimoId = $ultimoProducto->fetchColumn();
            $respuesta = $this->getProducto($ultimoId);
        }else { //si entra acá es para modificar
            $param = ["descripcion_producto"=>$datosCampos['descripcion'], "id_usuario"=>2, 
                "modificacion_producto"=>$fecha,"id_producto"=>$datosCampos['id']];
            $resUpdate = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_PRODUCTO, $param);
            $respuesta = $this->getProducto($datosCampos['id']);
        }
        
//        $domici = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_DOMICILIO, array($respuesta['FK_domicilio']));
//        $domArr = $domici->fetch(PDO::FETCH_ASSOC);
//        $respuesta['calle']=$domArr['calle'];
//        $respuesta['numero']=$domArr['numero'];
        return $respuesta;
    }
    
    public function getProducto($id) {
      $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_PRODUCTO,array($id));
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

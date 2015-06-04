<?php
require_once 'ControladorGeneral.php';
require_once '../../modelo/Factura.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Flaco
 */
class ControladorFactura extends ControladorGeneral{
    public function buscar() {
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_FACTURAS);

        $arrayFactura = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayFactura;
    }

    public function eliminar($id) {
        try {
            $resultadoBorrarFactura = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_FACTURA, array($id));
            return $resultadoBorrarFactura->fetch(PDO::FETCH_ASSOC);     
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo "<br>Error: ".$excepcionGral->getTraceAsString().'<br>';
        }
    }

    public function buscarX ($datos){
        try {
            if ($datos['criterio']=="numero") { 
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
        $hoy = getdate(); 
        $fecha = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']; 
        
        if($datosCampos['id'] == 0) { // si id=0 agregar
            $param = ["numero_factura"=>$datosCampos['numero'], "creacion_factura"=>$fecha, 
                "tipo_factura"=>$datosCampos['tipo'], "id_cliente"=>2,
                "id_usuario"=>2,"modificacion_factura"=>$fecha,"estado_factura"=>"A"];
            $resul = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_FACTURA, $param);
            $ultimaFactura = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMA_FACTURA);
            $ultimoId = $ultimaFactura->fetchColumn();
            $respuesta = $this->getFactura($ultimoId);
        }else { //si entra acá es para modificar
             $param = ["numero_factura"=>$datosCampos['numero'], "creacion_factura"=>$fecha, 
                "tipo_factura"=>$datosCampos['tipo'], "id_cliente"=>$datosCampos['id'],
                "id_usuario"=>2,"modificacion_factura"=>$fecha,"estado_factura"=>"A"];
            $resUpdate = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_FACTURA, $param);
            $respuesta = $this->getFactura($datosCampos['id']);
        }
        return $respuesta;
    }
    
    public function getFactura($id) {
      $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UNA_FACTURA,array($id));
      $factura = $statement->fetch();
      
      if (!$factura) {
        echo 'ERROR AL BUSCAR EL Factura';
      }
      return $factura;
    }

    public function agregar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }
}

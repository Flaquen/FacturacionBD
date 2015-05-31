<?php
require_once 'ControladorGeneral.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorLocalidad
 *
 * @author DIEGO
 */
class ControladorLocalidad extends ControladorGeneral {
    public function agregar($datosCampos) {
        
    }

    public function buscar() {
        $buscarLocalidad = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::SELECCION_LOCALIDAD);

        $arrayLocalidad = $buscarLocalidad->fetchAll(PDO::FETCH_ASSOC);
        echo '<select>';
        foreach ($arrayLocalidad as $clave ) {
            foreach ($clave as $valor) {
                echo '<option>'.$valor.'</option>';
            }
            
        }
        echo '</select>';
        $buscarLocalidad=null;
        
    }

    public function eliminar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }

//put your code here
}

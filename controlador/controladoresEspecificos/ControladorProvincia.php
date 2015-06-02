<?php
require_once 'ControladorGeneral.php';


class ControladorProvincia extends ControladorGeneral {
    public function agregar($datosCampos) {
        
    }

    public function buscar() {
        $buscarProvincias = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::SELECCION_PROVINCIAS);

        $arrayProvincias = $buscarProvincias->fetchAll(PDO::FETCH_ASSOC);
        /*echo '<select>';
        foreach ($arrayProvincias as $clave ) {
            foreach ($clave as $valor) {
                echo '<option>'.$valor.'</option>';
            }
            
        }
        echo '</select>';*/
        
        return $arrayProvincias;
        
    }

    public function eliminar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }

//put your code here
}

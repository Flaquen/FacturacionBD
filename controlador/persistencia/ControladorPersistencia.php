<?php
require_once 'Conexion.php';
require_once 'DBSentencias.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorPersistencia
 *
 * @author Flaco
 */
class ControladorPersistencia implements DBSentencias {
    private $_conexion = null;
    function get_conexion() {
        return $this->_conexion;
    }

    public function __construct() {
        $db = new Conexion();
        $this->_conexion = $db->getConexion();
    }
   
    /**
     *
     * @param string $query
     * @param array $parametros
     */
    public function ejecutarSentencia($query, $parametros = null) {
        //echo $query.'<br>';
        $statement = $this->_conexion->prepare($query);
        if($parametros) {
            $index = 1;
            foreach ($parametros as $key => $parametro) {
                //echo $key.'-'.$parametro.'<br>';
                $statement->bindValue($index, $parametro);
                $index ++;
                //echo 'estas en la vuelta'.$index.'<br>';
            }
        }
        $statement->execute();
        return $statement;
    }
    public function getUltimoId(){
        return $this->_conexion->lastInsertId();
    }
}

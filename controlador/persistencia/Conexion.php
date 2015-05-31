<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author Flaco
 */
class Conexion {
    private $_conexion = null;
    private $_usuario = 'root';
    private $_clave = 'root';
    public function __construct() {
        $this->_conexion = new PDO("mysql:dbname=facturacion;host=localhost", $this->_usuario, $this->_clave);
        //$this->_conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //ANTE ERROR, LANZA UNA EXCEPCION
    }
    
    /**
     * 
     * @return PDO
     */
    public function getConexion() { 
        return $this->_conexion;
    }
    /*public function cerrar(){
        
        $this->_conexion=new PDO(clo)
        
        
    }*/
}

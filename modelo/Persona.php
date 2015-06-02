<?php
require_once 'Domicilio.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona
 *
 * @author Flaco
 */
abstract class Persona {
    private $nombre;
    private $apellido;
    private $refDomicilio;
    function __construct($nombre, $apellido, $calle, $numero) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->refDomicilio = new Domicilio($calle, $numero);
        
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    function getRefDomicilio() {
        return $this->refDomicilio;
    }

    function setRefDomicilio($refDomicilio) {
        $this->refDomicilio = $refDomicilio;
    }
}

<?php
require_once 'Persona.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author Flaco
 */
class Alumno extends Persona{
    private $legajo;
    function __construct($nombre, $apellido, $calle, $numero, $legajo) {
        parent::__construct($nombre, $apellido, $calle, $numero);
        $this->legajo = $legajo;
    }
    function getLegajo() {
        return $this->legajo;
    }

    function setLegajo($legajo) {
        $this->legajo = $legajo;
    }


}

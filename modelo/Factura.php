<?php
require_once 'Persona.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profesor
 *
 * @author Flaco
 */
class Profesor extends Persona{
    private $titulo;
    function __construct($nombre, $apellido, $calle, $numero, $titulo) {
        parent::__construct($nombre, $apellido, $calle, $numero);
        $this->titulo = $titulo;
    }
    function getTitulo() {
        return $this->titulo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }


}

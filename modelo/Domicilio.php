<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Domicilio
 *
 * @author Flaco
 */
class Domicilio {
    private $calle;
    private $numero;
    function __construct($calle, $numero) {
        $this->calle = $calle;
        $this->numero = $numero;
    }
    function getCalle() {
        return $this->calle;
    }

    function getNumero() {
        return $this->numero;
    }

    function setCalle($calle) {
        $this->calle = $calle;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }


}

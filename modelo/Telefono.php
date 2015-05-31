<?php

class Telefono {
    private $nuemero;
    private $tipo;
    private $refIdCliente;
    function __construct($nuemero, $tipo, $refIdCliente) {
        $this->nuemero = $nuemero;
        $this->tipo = $tipo;
        $this->refIdCliente = $refIdCliente;
    }
    function getNuemero() {
        return $this->nuemero;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getRefIdCliente() {
        return $this->refIdCliente;
    }

    function setNuemero($nuemero) {
        $this->nuemero = $nuemero;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setRefIdCliente($refIdCliente) {
        $this->refIdCliente = $refIdCliente;
    }



}

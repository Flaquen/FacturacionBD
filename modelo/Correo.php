<?php

class Correo {
    private $correo;
    private $refIdCliente;
    function __construct($correo, $refIdCliente) {
        $this->correo = $correo;
        $this->refIdCliente = $refIdCliente;
    }
    function getCorreo() {
        return $this->correo;
    }

    function getRefIdCliente() {
        return $this->refIdCliente;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setRefIdCliente($refIdCliente) {
        $this->refIdCliente = $refIdCliente;
    }


}

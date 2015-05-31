<?php

class Factura  {
    
    private $numero;
    private $creacion;
    private $tipo;
    private $refIdCliente;
    private $refIdUsuario;
    private $modificacion;
    function __construct($numero, $creacion, $tipo, $refIdCliente, $refIdUsuario, $modificacion) {
        $this->numero = $numero;
        $this->creacion = $creacion;
        $this->tipo = $tipo;
        $this->refIdCliente = $refIdCliente;
        $this->refIdUsuario = $refIdUsuario;
        $this->modificacion = $modificacion;
    }
    function getNumero() {
        return $this->numero;
    }

    function getCreacion() {
        return $this->creacion;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getRefIdCliente() {
        return $this->refIdCliente;
    }

    function getRefIdUsuario() {
        return $this->refIdUsuario;
    }

    function getModificacion() {
        return $this->modificacion;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setCreacion($creacion) {
        $this->creacion = $creacion;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setRefIdCliente($refIdCliente) {
        $this->refIdCliente = $refIdCliente;
    }

    function setRefIdUsuario($refIdUsuario) {
        $this->refIdUsuario = $refIdUsuario;
    }

    function setModificacion($modificacion) {
        $this->modificacion = $modificacion;
    }



}

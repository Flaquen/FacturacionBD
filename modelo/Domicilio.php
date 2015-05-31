<?php


class Domicilio {
    
    private $calle;
    private $numero;
    private $refIdCliente;
    private $reflocalidad;
    private $refIdProvincia;
    private $piso;
    private $departamento;
    private $refIdUsuario;
    private $creacion;
    private $modificacion;
    function __construct($calle, $numero, $refIdCliente, $reflocalidad, $refIdProvincia, $piso, $departamento, $refIdUsuario, $creacion, $modificacion) {
        $this->calle = $calle;
        $this->numero = $numero;
        $this->refIdCliente = $refIdCliente;
        $this->reflocalidad = $reflocalidad;
        $this->refIdProvincia = $refIdProvincia;
        $this->piso = $piso;
        $this->departamento = $departamento;
        $this->refIdUsuario = $refIdUsuario;
        $this->creacion = $creacion;
        $this->modificacion = $modificacion;
    }
    function getCalle() {
        return $this->calle;
    }

    function getNumero() {
        return $this->numero;
    }

    function getRefIdCliente() {
        return $this->refIdCliente;
    }

    function getReflocalidad() {
        return $this->reflocalidad;
    }

    function getRefIdProvincia() {
        return $this->refIdProvincia;
    }

    function getPiso() {
        return $this->piso;
    }

    function getDepartamento() {
        return $this->departamento;
    }

    function getRefIdUsuario() {
        return $this->refIdUsuario;
    }

    function getCreacion() {
        return $this->creacion;
    }

    function getModificacion() {
        return $this->modificacion;
    }

    function setCalle($calle) {
        $this->calle = $calle;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setRefIdCliente($refIdCliente) {
        $this->refIdCliente = $refIdCliente;
    }

    function setReflocalidad($reflocalidad) {
        $this->reflocalidad = $reflocalidad;
    }

    function setRefIdProvincia($refIdProvincia) {
        $this->refIdProvincia = $refIdProvincia;
    }

    function setPiso($piso) {
        $this->piso = $piso;
    }

    function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    function setRefIdUsuario($refIdUsuario) {
        $this->refIdUsuario = $refIdUsuario;
    }

    function setCreacion($creacion) {
        $this->creacion = $creacion;
    }

    function setModificacion($modificacion) {
        $this->modificacion = $modificacion;
    }



}

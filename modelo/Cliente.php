<?php

class Cliente{
    private $nombre;
    private $apellido;
    private $cuil;
    private $iva;
    private $refIdUsuario;
    private $creacion;
    private $modificacion;
    private $estado;
    function __construct($nombre, $apellido, $cuil, $iva, $refIdUsuario, $creacion, $modificacion, $estado) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cuil = $cuil;
        $this->iva = $iva;
        $this->refIdUsuario = $refIdUsuario;
        $this->creacion = $creacion;
        $this->modificacion = $modificacion;
        $this->estado = $estado;
    }
    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getCuil() {
        return $this->cuil;
    }

    function getIva() {
        return $this->iva;
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

    function getEstado() {
        return $this->estado;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setCuil($cuil) {
        $this->cuil = $cuil;
    }

    function setIva($iva) {
        $this->iva = $iva;
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

    function setEstado($estado) {
        $this->estado = $estado;
    }



    
    
   
}

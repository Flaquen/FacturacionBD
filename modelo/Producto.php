<?php

class Producto {
    
    private $descripcion;
    private $refIdUsuario;
    private $creacion;
    private $modificacion;
    function __construct($descripcion, $refIdUsuario, $creacion, $modificacion) {
        $this->descripcion = $descripcion;
        $this->refIdUsuario = $refIdUsuario;
        $this->creacion = $creacion;
        $this->modificacion = $modificacion;
    }
    function getDescripcion() {
        return $this->descripcion;
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

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
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

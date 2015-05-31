<?php

class Usuario {
    private $nombre;
    private $pass;
    private $acceso;
    private $creacion;
    private $modificacion;
    function __construct($nombre, $pass, $acceso, $creacion, $modificacion) {
        $this->nombre = $nombre;
        $this->pass = $pass;
        $this->acceso = $acceso;
        $this->creacion = $creacion;
        $this->modificacion = $modificacion;
    }
    function getNombre() {
        return $this->nombre;
    }

    function getPass() {
        return $this->pass;
    }

    function getAcceso() {
        return $this->acceso;
    }

    function getCreacion() {
        return $this->creacion;
    }

    function getModificacion() {
        return $this->modificacion;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setAcceso($acceso) {
        $this->acceso = $acceso;
    }

    function setCreacion($creacion) {
        $this->creacion = $creacion;
    }

    function setModificacion($modificacion) {
        $this->modificacion = $modificacion;
    }

}

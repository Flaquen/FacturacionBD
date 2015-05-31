<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrecioHistorico
 *
 * @author DIEGO
 */
class PrecioHistorico {
    private $precioHistorio;
    private $creacion;
    private $modificacion;
    private $refIdProducto;
    private $refIdUsusario;
    function __construct($precioHistorio, $creacion, $modificacion, $refIdProducto, $refIdUsusario) {
        $this->precioHistorio = $precioHistorio;
        $this->creacion = $creacion;
        $this->modificacion = $modificacion;
        $this->refIdProducto = $refIdProducto;
        $this->refIdUsusario = $refIdUsusario;
    }
    function getPrecioHistorio() {
        return $this->precioHistorio;
    }

    function getCreacion() {
        return $this->creacion;
    }

    function getModificacion() {
        return $this->modificacion;
    }

    function getRefIdProducto() {
        return $this->refIdProducto;
    }

    function getRefIdUsusario() {
        return $this->refIdUsusario;
    }

    function setPrecioHistorio($precioHistorio) {
        $this->precioHistorio = $precioHistorio;
    }

    function setCreacion($creacion) {
        $this->creacion = $creacion;
    }

    function setModificacion($modificacion) {
        $this->modificacion = $modificacion;
    }

    function setRefIdProducto($refIdProducto) {
        $this->refIdProducto = $refIdProducto;
    }

    function setRefIdUsusario($refIdUsusario) {
        $this->refIdUsusario = $refIdUsusario;
    }


}

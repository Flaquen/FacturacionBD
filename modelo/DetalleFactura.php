<?php

class DetalleFactura {
    
    private $cantidad;
    private $refIdProducto;
    private $refIdFactura;
    function __construct($cantidad, $refIdProducto, $refIdFactura) {
        $this->cantidad = $cantidad;
        $this->refIdProducto = $refIdProducto;
        $this->refIdFactura = $refIdFactura;
    }
    function getCantidad() {
        return $this->cantidad;
    }

    function getRefIdProducto() {
        return $this->refIdProducto;
    }

    function getRefIdFactura() {
        return $this->refIdFactura;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setRefIdProducto($refIdProducto) {
        $this->refIdProducto = $refIdProducto;
    }

    function setRefIdFactura($refIdFactura) {
        $this->refIdFactura = $refIdFactura;
    }



}

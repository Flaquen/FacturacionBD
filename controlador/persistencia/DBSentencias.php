<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Flaco
 */
interface DBSentencias {

    

   
    
    //SENTENCIAS CLIENTE
    const ELIMINAR_CLIENTE = "UPDATE cliente SET estado_cliente = 'N' WHERE id_cliente = ?";
    const BUSCAR_UN_CLIENTE = "SELECT * FROM cliente WHERE estado_cliente = 'A' AND id_cliente = ?";
    const BUSCAR_CLIENTES = "SELECT nombre_cliente, apellido_cliente, cuil_cliente, iva_cliente, id_cliente FROM cliente WHERE estado_cliente = 'A'";
    const INSERTAR_CLIENTE = "INSERT INTO cliente(nombre_cliente, apellido_cliente, cuil_cliente, iva_cliente, id_usuario, creacion_cliente, modificacion_cliente, estado_cliente) VALUES(?,?,?,?,?,?,?,?)";
    const ULTIMO_CLIENTE = "SELECT MAX(id_cliente) FROM cliente";
    const ACTUALIZAR_CLIENTE = "UPDATE cliente SET nombre_cliente = ?, apellido_cliente = ?, cuil_cliente = ?, iva_cliente = ?, id_usuario = ?, modificacion_cliente = ? WHERE id_cliente = ?";
    //SENTENCIAS PROVINCIA
    const SELECCION_PROVINCIAS= "SELECT nombre_provincia FROM provincia ORDER BY nombre_provincia";
    const SELECCION_UNA_PROVINCIA="SELECT id_provincis FROM provincia WHERE nombre_provincia= ?";
    const INSERTAR_PROVINCIAS="INSERT INTO provincia (nombre_provincia,estado_provincia)VALUES (?,?)";
    const ELIMINAR_PROVINCIA="UPDATE provincia SET estado_provincia = 'N' WHERE id_provincia = ?";
    const ACTUALIZAR_PROVINCIA="UPDATE provincia SET nombre_provincia = ? WHERE id_provincia = ?";
    //SENTENCIAS LOCALIDAD
    const SELECCION_LOCALIDAD ="SELECT nombre_localidad FROM localidad ORDER BY nombre_localidad";
    const INSERTAR_LOCALIDAD="INSERT INTO localidad (nombre_localidad,estado_localidad)VALUES (?,?)";
    const ELIMINAR_LOCALIDAD="UPDATE localidad SET estado_localidad = 'N' WHERE id_localidad = ?";
    const ACTUALIZAR_LOCALIDAD="UPDATE localidad SET nombre_localidad = ? WHERE id_localidad = ?";
    //SENTENCIAS USUARIO
    const CHECK_USER = "SELECT * FROM usuario WHERE nombre_usuario = ? AND pass_usuario = ? AND estado_usuario = 'A'";
    const INSERTAR_USUARIO = "INSERT INTO usuario(nombre_usuario, pass_usuario, acceso_usuario, creacion_usuario, modificacion_usuario, estado_usuario) VALUES(?,?,?,?,?,?)";
    //SENTENCIAS PRODUCTO
    const INSERTAR_PRODUCTO = "INSERT INTO producto(descripcion_producto, id_usuario, creacion_producto, modificacion_producto, estado_producto) VALUES(?,?,?,?,?)";
    const BUSCAR_PRODUCTOS = "SELECT * FROM producto WHERE estado_producto = 'A'"; 
    const BUSCAR_UN_PRODUCTO = "SELECT * FROM producto WHERE estado_producto = 'A' AND id_producto = ?";
    const ELIMINAR_PRODUCTO = "UPDATE producto SET estado_producto = 'N' WHERE id_producto = ?";
    const ACTUALIZAR_PRODUCTO = "UPDATE producto SET descripcion_producto = ?, id_usuario = ?, modificacion_producto = ? WHERE id_producto = ?";
    const ULTIMO_PRODUCTO = "SELECT MAX(id_producto) FROM producto";
    
}

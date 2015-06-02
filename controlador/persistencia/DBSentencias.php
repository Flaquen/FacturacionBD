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
    //SENTENCIAS USUARIO
    const CHECK_USER = "SELECT * FROM usuario WHERE nombre_usuario = ? AND pass_usuario = ?";
    const INSERTAR_USUARIO = "INSERT INTO usuario(nombre_usuario, pass_usuario, acceso_usuario, creacion_usuario, modificacion_usuario,estado_usuario) VALUES(?,?,?,?,?,?)";
    //SENTENCIAS CLIENTE
    const ELIMINAR_CLIENTE = "UPDATE cliente SET estado_cliente = 'N' WHERE id_cliente = ?";
    const BUSCAR_UN_CLIENTE = "SELECT * FROM cliente WHERE estado_cliente = 'A' AND id_cliente = ?";
    const BUSCAR_CLIENTES = "SELECT nombre_cliente, apellido_cliente, cuil_cliente, iva_cliente, id_cliente FROM cliente WHERE estado_cliente = 'A'";
    const INSERTAR_CLIENTE = "INSERT INTO cliente(nombre_cliente, apellido_cliente, cuil_cliente, iva_cliente, id_usuario, creacion_cliente, modificacion_cliente, estado_cliente) VALUES(?,?,?,?,?,?,?,?)";
    const ULTIMO_CLIENTE = "SELECT MAX(id_cliente) FROM cliente";
    const ACTUALIZAR_CLIENTE = "UPDATE cliente SET nombre_cliente = ?, apellido_cliente = ?, cuil_cliente = ?, iva_cliente = ?, id_usuario = ?, modificacion_cliente = ? WHERE id_cliente = ?";
    //SENTENCIAS PROVINCIA
    const SELECCION_PROVINCIAS= "SELECT nombre_provincia FROM provincia ORDER BY nombre_provincia";
    const INSERTAR_PROVINCIAS="INSERT INTO provincia (nombre_provincia,estado_provincia)VALUES (?,?)";
    const ELIMINAR_PROVINCIA="UPDATE provincia SET estado_provincia = 'N' WHERE id_provincia = ?";
    const ACTUALIZAR_PROVINCIA="UPDATE provincia SET nombre_provincia = ? WHERE id_provincia = ?";
    //SENTENCIAS LOCALIDAD
    const SELECCION_LOCALIDAD ="SELECT nombre_localidad FROM localidad ORDER BY nombre_localidad";
    const INSERTAR_LOCALIDAD="INSERT INTO localidad (nombre_localidad,estado_localidad)VALUES (?,?)";
    const ELIMINAR_LOCALIDAD="UPDATE localidad SET estado_localidad = 'N' WHERE id_localidad = ?";
    const ACTUALIZAR_LOCALIDAD="UPDATE localidad SET nombre_localidad = ? WHERE id_localidad = ?";
    
    
    
    /*const INSERTAR_PERSONA = "INSERT INTO persona(nombre, apellido, titulo, legajo, tipo, FK_domicilio) VALUES(?,?,?,?,?,?)";    
    const ELIMINAR_PERSONA = "DELETE FROM persona WHERE id = ?";    
    //con inner join
    //const ELIMINAR_PERSONA_Y_DOMICILIO = "DELETE persona , domicilio  FROM persona  INNER JOIN domicilio WHERE persona.FK_domicilio= domicilio.id and persona.id = ?";
    //probar    
    const ACTUALIZAR_PERSONA = "UPDATE persona SET nombre = ?, apellido = ?, titulo = ?, legajo = ?, tipo = ? WHERE id = ?";
    const BUSCAR_ALUMNOS = "SELECT nombre, apellido, legajo, calle, numero, persona.id FROM persona INNER JOIN domicilio ON persona.FK_domicilio = domicilio.id WHERE persona.tipo = 'A'";
    const BUSCAR_ALUMNO_POR_CALLE = "SELECT nombre, apellido, legajo, calle, numero, persona.id FROM persona INNER JOIN domicilio ON persona.FK_domicilio = domicilio.id WHERE tipo = 'A' AND calle LIKE ?";
    const BUSCAR_PROFESOR_POR_CALLE ="SELECT nombre, apellido, titulo, calle, numero, persona.id FROM persona INNER JOIN domicilio ON persona.FK_domicilio = domicilio.id WHERE tipo = 'P' AND calle LIKE ?";
    const BUSCAR_PROFESORES = "SELECT nombre, apellido, titulo, calle, numero, persona.id FROM persona INNER JOIN domicilio ON persona.FK_domicilio = domicilio.id WHERE persona.tipo = 'P'";
    const BUSCAR_UN_ALUMNO = "SELECT * FROM persona WHERE tipo = 'A' AND id = ?";
    const BUSCAR_UN_PROFESOR = "SELECT * FROM persona WHERE tipo = 'P' AND id = ?";
    const ULTIMO_ALUMNO = "SELECT MAX(id) FROM persona WHERE tipo = 'A'";
    const ULTIMO_PROFESOR = "SELECT MAX(id) FROM persona WHERE tipo = 'P'";     
    const ACTUALIZAR_ALUMNO_CON_DOMICILIO = "UPDATE persona INNER JOIN domicilio on persona.FK_domicilio = domicilio.id 
        SET nombre = ?, apellido = ?, legajo = ?, calle = ?, numero = ? WHERE persona.id = ?;";
    const ACTUALIZAR_PROFESOR_CON_DOMICILIO = "UPDATE persona INNER JOIN domicilio on persona.FK_domicilio = domicilio.id 
        SET nombre = ?, apellido = ?, titulo = ?, calle = ?, numero = ? WHERE persona.id = ?;";
    const INSERTAR_DOMICLIO = "INSERT INTO domicilio(calle, numero) VALUES(?,?)";
    const ELIMINAR_DOMICILIO = "DELETE FROM domicilio WHERE id = ?";
    const ACTUALIZAR_DOMICILIO = "UPDATE domicilio SET calle = ?, numero = ? WHERE id = ?";
    const BUSCAR_DOMICILIO = "SELECT calle, numero FROM domicilio";
    const BUSCAR_UN_DOMICILIO = "SELECT * FROM domicilio WHERE id = ?";
    const ULTIMO_DOMICILIO = "SELECT MAX(id) FROM domicilio";    
    const BUSCAR_USUARIOS = "SELECT * FROM usuario";
    const INSERTAR_USUARIO = "INSERT INTO usuario(user, pass) VALUES(?,?)";
    const ELIMINAR_USUARIO = "DELETE FROM usuario WHERE id = ?";
    const ACTUALIZAR_USUARIO = "UPDATE usuario SET user = ?, pass = ? WHERE id = ?";
    const BUSCAR_UN_USUARIO = "SELECT * FROM usuario WHERE id = ?";*/
}

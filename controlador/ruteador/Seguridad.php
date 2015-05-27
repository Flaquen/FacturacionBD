<?php
$usuario  = $_POST['user'];
$contrase = $_POST['pass'];
require_once '../controladoresEspecificos/ControladorUsuario.php';
$cU = new ControladorUsuario();
$res =$cU->validarUsuarioClave($usuario, sha1($contrase)); 
echo json_encode($res);

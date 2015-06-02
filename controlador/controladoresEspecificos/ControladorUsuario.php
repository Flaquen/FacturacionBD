<?php
require_once 'ControladorGeneral.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorUsuario
 *
 * @author Flaco
 */
class ControladorUsuario extends ControladorGeneral {
    
    public function agregar($datosCampos) {
        
    }

    public function buscar() {
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_USUARIOS);

        $arrayUsuarios = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayUsuarios;
    }

    public function eliminar($datosCampos) {
        
    }

    public function modificar($datosCampos) {
        
    }
    public function validarUsuarioClave($user, $pass) {
        $param = ["user"=>$user, "pass"=>$pass];
        $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::CHECK_USER, $param);
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!$resultado) {
            session_start();
            session_destroy();
            return $resultado;
        }else{
            session_start();
            $_SESSION["user"]=$user;
            $_SESSION["pass"]=$pass;
            return $resultado=["user"=>$user, "pass"=>$pass];
        }
    }
    public function guardar($datosCampos){

        $user = $datosCampos['user'];
        $pass = $datosCampos['pass'];
        $hoy = getdate(); //saco la fecha para creacion y modificacion
        $fecha = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'].' '.$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']; //armo con la fecha un timestamp
        if($user == "" || $pass  == "") {
            echo'Todos los datos deben estar completos!';
        }else{

            $parametros = array($user,  sha1($pass), "A", $fecha, $fecha, "A"); //user, pass, acceso, creac, modif
            $resultado = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_USUARIO, $parametros);
            if(!$resultado){
              echo 'Error al crear Usuario';
            }
            return $res = ["operacion"=>"exitosa"];
        }
        
    }
    public function getUsuario($id) {
      $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_USUARIO,array($id));
      $usuario = $statement->fetch();
      if (!$usuario) {
        echo'No se encontr&oacute el usuario';
      }
      return $usuario;
    }
}

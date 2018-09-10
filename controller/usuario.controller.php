<?php

class Usuario_Controller{
    function nuevoUsuario($name,$password,$rol){
       $var_usuario = new Usuario_Model();
       $respuesta = $var_usuario->nuevoUsuario($name, $password, $rol);
       return $respuesta;
    }
    
    function modificarUsuario($id_user,$name,$password,$rol){
       $var_usuario = new Usuario_Model();
       $respuesta = $var_usuario->modificarUsuario($id_user,$name, $password, $rol);
       return $respuesta;
    }
    
    function eliminarUsuario($id_user){
        $var_usuario = new Usuario_Model();
        $respuesta = $var_usuario->eliminarUsuario($id_user);
        return $respuesta;
    }
    
    function verUsuario(){
       $var_usuario = new Usuario_Model();
       $respuesta = $var_usuario->verUsuario();
       return $respuesta;
    }
    
    function verUsuarioRol($rol){
       $var_usuario = new Usuario_Model();
       $respuesta = $var_usuario->verUsuarioRol($rol);
       return $respuesta;
    }
}

?>
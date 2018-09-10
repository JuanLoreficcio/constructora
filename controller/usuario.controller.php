<?php

class Usuario_Controller{
    function nuevoUsuario($name,$password,$rol){
       $var_usuario = new Usuario_Model();
       $var_usuario->nuevoUsuario($name, $password, $rol);
    }
    
    function modificarUsuario($id_user,$name,$password,$rol){
       $var_usuario = new Usuario_Model();
       $var_usuario->modificarUsuario($id_user,$name, $password, $rol);        
    }
    
    function eliminarUsuario($id_user){
        $var_usuario = new Usuario_Model();
        $var_usuario->eliminarUsuario($id_user);       
    }
    
    function verUsuario(){
       $var_usuario = new Usuario_Model();
       return $var_usuario->verUsuario();       
    }
    
    function verUsuarioRol($rol){
       $var_usuario = new Usuario_Model();
       return $var_usuario->verUsuarioRol($rol); 
    }
}

?>
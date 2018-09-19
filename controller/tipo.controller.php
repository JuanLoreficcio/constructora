<?php
class Tipo_Controller{
    function nuevoTipo($name){
        $var_tipo = new Tipo_Model();
        $respuesta = $var_tipo->nuevoTipo($name);
        return $respuesta;
    }
    
    function modificarTipo($id_tipo,$name){
        $var_tipo = new Tipo_Model();
        $respuesta = $var_tipo->modificarTipo($id_tipo,$name);
        return $respuesta;
    }
    
    function eliminarTipo($id_tipo){
        $var_tipo = new Tipo_Model();
        $respuesta = $var_tipo->eliminarTipo($id_tipo);
        return $respuesta;
    }
    
    function verTipo(){
        $var_tipo = new Tipo_Model();
        $respuesta = $var_tipo->verTipo();
        return $respuesta;
    }
}
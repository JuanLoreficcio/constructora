<?php
class Estado_Controller{
    function nuevoEstado($name){
        $estado = new Estado_Model();
        $respuesta = $estado->nuevoEstado($name);
        return $respuesta;
    }
    
    function modificarEstado($id_estado,$name){
        $estado = new Estado_Model();
        $respuesta = $estado->modificarEstado($id_estado, $name);
        return $respuesta;
    }
    
    function eliminarEstado($id_estado){
        $estado = new Estado_Model();
        $respuesta = $estado->eliminarEstado($id_estado);
        return $respuesta;
    }
    
    function verEstado(){
        $estado = new Estado_Model();
        $respuesta = $estado->verEstado();
        return $respuesta;
    }
}


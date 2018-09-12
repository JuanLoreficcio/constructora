<?php
class Tipo_Controller{
    function nuevoTipo($name){
        $tipo = new Tipo_Model();
        $result = $tipo->nuevoTipo($name);
        return $result;
    }
    function modificarTipo($id_tipo, $name){
        $tipo = new Tipo_Model();
        $result = $tipo->modificarTipo($id_tipo, $name);
        return $result;
    }
    function eliminarTipo($id_tipo){
        $tipo = new Tipo_Model();
        $result = $tipo->eliminarTipo($id_tipo);
        return $result;
    }
    function verTipo(){
        $tipo = new Tipo_Model();
        $result = $tipo->verTipo();
        return $result;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


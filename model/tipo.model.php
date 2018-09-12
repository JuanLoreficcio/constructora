<?php
class Tipo_Model{
    function nuevoTipo($name){
        global $db;
        $sql = "INSERT INTO `tipo` (`id_tipo`, `name`) VALUES (NULL, '$name');";
        $result = $db->insert($sql);
        return $result;
    }
    function modificarTipo($id_tipo,$name){
        global $db;
        $sql = "UPDATE `tipo` SET `name` = '$name' WHERE `tipo`.`id_tipo` = $id_tipo;";
        $result = $db->update($sql);
        return $result;
    }
    function eliminarTipo($id_tipo){
        global $db;
        $sql = "DELETE FROM `estado` WHERE `estado`.`id_estado` = $id_tipo;";
        $result = $db->delete($sql);
        return $result;
    }
    function verTipo(){
        global $db;
        $sql = "SELECT * FROM `tipo` ORDER BY name";
        $result = $db->query($sql);
        return $result;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


<?php
class Tipo_Model{
    function nuevoTipo($name){
        global $db;
        $sql="INSERT INTO `tipo` (`id_tipo`, `name`) VALUES (NULL, '$name');";
        $respuesta = $db->insert($sql);
        return $respuesta;
    }
    
    function modificarTipo($id_tipo,$name){
        global $db;
        $sql="UPDATE `tipo` SET `name` = '$name' WHERE `tipo`.`id_tipo` = $id_tipo;";
        $respuesta = $db->update($sql);
        return $respuesta;
    }
    
    function eliminarTipo($id_tipo){
        global $db;
        $sql="DELETE FROM `tipo` WHERE `tipo`.`id_tipo` = $id_tipo";
        $respuesta = $db->delete($sql);
        return $respuesta;
    }
    
    function verTipo(){
        global $db;
        $sql="SELECT * FROM `tipo` ORDER BY name";
        $respuesta = $db->query($sql);
        return $respuesta;
    }
}


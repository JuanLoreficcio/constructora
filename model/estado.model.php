<?php
class Estado_Model{
    function nuevoEstado($name){
        global $db;
        $sql="INSERT INTO `estado` (`id_estado`, `name`) VALUES (NULL, '$name');";
        $respuesta = $db->insert($sql);
        return $respuesta;
    }
    
    function modificarEstado($id_estado,$name){
        global $db;
        $sql="UPDATE `estado` SET `name` = '$name' WHERE `estado`.`id_estado` = $id_estado;";
        $respuesta = $db->update($sql);
        return $respuesta;
    }
    
    function eliminarEstado($id_estado){
        global $db;
        $sql="DELETE FROM `estado` WHERE `estado`.`id_estado` = $id_estado";
        $respuesta = $db->delete($sql);
        return $respuesta;
    }
    
    function verEstado(){
        global $db;
        $sql="SELECT * FROM `estado` ORDER BY name";
        $respuesta = $db->query($sql);
        return $respuesta;
    }
}

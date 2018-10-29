<?php
class Cobros_Model{
    function nuevoCobro($fecha,$monto,$factura,$id_persona){
        global $db;
        $sql = "INSERT INTO `cobros` (`id_cobro`, `fecha`, `monto`, `detalle`, `id_persona`)"
                . " VALUES (NULL, STR_TO_DATE('$fecha', '%d-%m-%Y' ), '$monto', '$factura', '$id_persona');";
        $result = $db->insert($sql);
        return $result;
    }
    function  modificarCobro($id_cobro,$fecha,$detalle,$monto,$id_persona){
        global $db;
        $sql = "UPDATE `cobros` SET `fecha` = '$fecha', `monto` = '$monto',"
                . "`id_persona` = '$id_persona', `detalle` = '$detalle'"
                . "WHERE `cobros`.`id_cobro` = '$id_cobro';";
        $result = $db->update($sql);
        return $result;
    }
    function eliminarCobro($id_cobro){
        global $db;
        $sql = "DELETE FROM `cobros` WHERE `cobros`.`id_cobro`=$id_cobro;";
        $result = $db->delete($sql);
        return $result;
    }
    function verCobro($id_cobro){
        global $db;
        $sql = "SELECT * FROM `cobros` WHERE id_cobro='$id_cobro';";
        $result = $db->query($sql);
        if($result){
            return $result;}
        else{
            return false;}
    }
    function verCobro_date($date){
        global $db;
        $sql = "SELECT * FROM `cobros` WHERE `fecha` = '$date';";
        $result = $db->query($sql);
        if($result){
            return $result;}
        else{
            return false;}
    }
    function verCobro_idPersona($id_persona){
         global $db;
        $sql = "SELECT * FROM `cobros` WHERE `id_persona` = '$id_persona';";
        $result = $db->query($sql);
        if($result){
            return $result;}
        else{
            return false;}
    }
    function verCobro_idCobro($id_cobro){
         global $db;
        $sql = "SELECT * FROM `cobros` WHERE `id_cobro` = '$id_cobro';";
        $result = $db->query($sql);
        if($result){
            return $result;}
        else{
            return false;}
    }

}

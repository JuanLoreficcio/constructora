<?php
class Cobros_Model{
    function nuevoCobro($fecha,$monto,$factura,$id_persona){
        global $db;
        $sql = "INSERT INTO `cobros` (`id_cobro`, `fecha`, `monto`, `factura`, `id_persona`)"
                . " VALUES (NULL, '$fecha', '$monto', '$factura', '$id_persona');";
        $result = $db->insert($sql);
        return $result;
    }
    function  modificarCobro($id_cobro,$fecha,$monto,$factura, $id_persona){
        global $db;
        $sql = "UPDATE `cobros` SET `fecha` = '$fecha', `monto` = '$monto',"
                . " `factura` = '$factura', `id_persona` = '$id_persona' WHERE `cobros`.`id_cobro` = $id_cobro;";
        $result = $db->update($sql);
        return $result;
    }
    function eliminarCobro($id_cobro){
        global $db;
        $sql = "DELETE FROM `cobros` WHERE `cobros`.`id_cobro`=$id_cobro;";
        $result = $db->delete($sql);
        return $result;
    }
    function verCobro(){
        global $db;
        $sql = "SELECT * FROM `cobros` ORDER BY `id_persona`;";
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
    function verCobro_id($id_persona){
         global $db;
        $sql = "SELECT * FROM `cobros` WHERE `id_persona` = '$id_persona';";
        $result = $db->query($sql);
        if($result){
            return $result;}
        else{
            return false;}
    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


<?php
class Pedido_Model{
    function crearPedido($id_producto,$id_factura,$precioProducto,$cantidad,$total){
        global $db;        
        $sql = "INSERT INTO `pedido` (`id_pedido`, `id_producto`, `id_factura`, `cantidad`, `precio`, `total`) "
                . "VALUES (NULL, '$id_producto', '$id_factura', '$cantidad', '$precioProducto', '$total');";
        $result = $db->query($sql);
        if($result){
            return $result;
        } else {
            return false;
        }
    }
    function modificarPedido($id_pedido,$id_producto,$id_factura,$precioProducto,$cantidad,$total){
        global $db;
        $sql="UPDATE `pedido` SET `id_producto` = '$id_producto', `id_factura` = '$id_factura', `cantidad` = '$cantidad', `precio` = '$precioProducto', `total` = '$total' "
                . "WHERE `pedido`.`id_pedido` = '$id_pedido';";
        $result = $db->query($sql);
        if($result){
            return $result;
        } else {
            return false;
        }
    }
    function descartarPedido($id_pedido){
        global $db;
        $sql = "DELETE FROM `pedido` WHERE `pedido`.`id_pedido` = '$id_pedido';";
        $db->delete($sql);
    }
}

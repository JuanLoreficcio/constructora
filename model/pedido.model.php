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
}

<?php
class Factura_Model{
    function nuevoFactura($id_persona,$id_tipo, $id_estado,$total,$fecha,$fecha_entrega,$descuento,$codigoCompra){
       global $db;
       $sql = "INSERT INTO `factura` (`id_factura`, `id_persona`, `id_tipo`, `id_estado`, `total`, `fecha`, `fecha_entrega`, `descuento`, `codiogoCompra`) "
               . "VALUES (NULL, '$id_persona', '$id_tipo', '$id_estado', '$total',STR_TO_DATE('$fecha', '%d-%m-%Y' ),STR_TO_DATE('$fecha_entrega', '%d-%m-%Y' ), '$descuento','$codigoCompra');";
       $respuesta = $db->insert($sql);
       return $respuesta;
    }
    
    function modificarFactura($id_factura,$fecha,$fecha_entrega,$id_persona,$id_tipo,$id_estado,$total){
       global $db; 
       $sql = "UPDATE `factura` SET `id_persona` = '$id_persona', `id_tipo` = '$id_tipo',"
               . "`id_estado` = '$id_estado', `total` = '$total', `fecha` = '$fecha', `fecha_entrega` = '$fecha_entrega',  `descuento` = '0' "
               . "WHERE `factura`.`id_factura` = $id_factura;";
       $respuesta = $db->update($sql);
       return $respuesta;
    }
    
    function eliminarFactura($id_factura){
       global $db; 
       $sql = "DELETE FROM `factura` WHERE `factura`.`id_factura` = $id_factura";
       $respuesta = $db->delete($sql);
       return $respuesta;
    }
    
    function verTodasFactura(){
       global $db;       
       $sql = "SELECT p.name as persona_name,p.mail,p.address, e.name as estado_name,e.id_estado as estado_id,id_factura,fecha,total,t.name as tipo_name "
               . "FROM factura f, persona p, estado e, tipo t "
               . "WHERE f.id_persona = p.id_persona "
               . "AND f.id_estado = e.id_estado "
               . "AND f.id_tipo = t.id_tipo ORDER BY id_factura;";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verFacturaPersona($id_persona){
       global $db; 
       $sql = "SELECT * FROM `factura` WHERE `id_persona`='$id_persona' ORDER BY `id_factura`;";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verFacturaFecha($fecha){
       global $db; 
       $sql = "SELECT * FROM `factura`WHERE `fecha` = '$fecha' ORDER BY fecha;";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verFactura($id_factura){
       global $db;       
       $sql = "SELECT p.id_persona as persona_id,p.name as persona_name,p.mail,p.address, "
               . "e.name as estado_name,e.id_estado as estado_id,id_factura,fecha,fecha_entrega,total,t.name as tipo_name, t.id_tipo as tipo_id,codiogoCompra "
               . "FROM factura f, persona p, estado e, tipo t "
               . "WHERE f.id_factura = '$id_factura'"
               . "AND f.id_persona = p.id_persona "
               . "AND f.id_estado = e.id_estado "
               . "AND f.id_tipo = t.id_tipo;";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verPedidoFactura($id_factura){
       global $db;
       /*$sql = "SELECT f.fecha,id_cobro,monto,f.total as factura_total, p.name, cantidad, precio, ped.total "
               . "FROM pedido ped, producto p ,factura f,cobros "
               . "WHERE ped.id_factura = '$id_factura'"
               . "AND ped.id_factura = f.id_factura "
               . "AND ped.id_producto = p.id_producto;";*/
       $sql = "SELECT f.fecha,f.total as factura_total, p.name,p.id_producto as producto_id, cantidad, precio, ped.total as pedido_total, ped.id_pedido as pedido_id "
               . "FROM pedido ped, producto p ,factura f "
               . "WHERE ped.id_factura = '$id_factura' "
               . "AND ped.id_factura = f.id_factura "
               . "AND ped.id_producto = p.id_producto;";
        $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verFacturasPersona($id_persona ){
       global $db; 
       $sql = "SELECT id_factura FROM `factura` WHERE id_persona='$id_persona'";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function ultimoPedido(){
        global $db; 
        $sql = "SELECT MAX(id_factura) AS id FROM factura;";
        return $db->query($sql);
    }
}
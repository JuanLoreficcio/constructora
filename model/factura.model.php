<?php
class Factura_Model{
    function nuevoFactura($id_persona,$id_tipo,$id_estado,$total,$descuento){
       global $db; 
       $sql = "INSERT INTO `factura` (`id_factura`, `id_persona`, `id_tipo`, `id_estado`, `total`, `fecha`, `descuento`) "
               . "VALUES (NULL, '$id_persona', '$id_tipo', '$id_estado', '$total', CURRENT_DATE(), '$descuento');";
       $respuesta = $db->insert($sql);
       return $respuesta;
    }
    
    function modificarFactura($id_factura,$fecha,$id_persona,$id_tipo,$id_estado,$total,$descuento){
       global $db; 
       $sql = "UPDATE `factura` SET `id_persona` = '$id_persona', `id_tipo` = '$id_tipo',"
               . "`id_estado` = '$id_estado', `total` = '$total', `fecha` = '$fecha', `descuento` = '$descuento' "
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
       $sql = "SELECT p.name as persona_name,p.mail,p.address, e.name as estado_name,id_factura,fecha,total,t.name as tipo_name "
               . "FROM factura f, persona p, estado e, tipo t "
               . "WHERE f.id_persona = p.id_persona "
               . "AND f.id_estado = e.id_estado "
               . "AND f.id_tipo = t.id_tipo;";
      
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
       $sql = "SELECT p.name as persona_name,p.mail,p.address, e.name as estado_name,id_factura,fecha,total,t.name as tipo_name "
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
       $sql = "SELECT p.name, cantidad, precio, ped.total "
               . "FROM pedido ped, producto p ,factura f "
               . "WHERE ped.id_factura = '$id_factura' "
               . "AND ped.id_factura = f.id_factura "
               . "AND ped.id_producto = p.id_producto;";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
}
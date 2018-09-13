<?php
class Factura_Model{
    function crearFactura($id_persona,$id_tipo,$id_estado,$total,$descuento){
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
    
    function verFactura(){
       global $db; 
       $sql = "SELECT id_factura, name,name,
		FROM pelicula p, genero g 
		WHERE p.id_genero = g.id_genero
		ORDER BY ge_nombre";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verFacturaPersona(){
       global $db; 
       $sql = "SELECT id_factura, pe_nombre 
		FROM pelicula p, genero g 
		WHERE p.id_genero = g.id_genero
		ORDER BY ge_nombre";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
    
    function verFacturaFecha(){
       global $db; 
       $sql = "SELECT * FROM `factura` ORDER BY fecha";
       $respuesta = $db->query($sql);
       return $respuesta;
    }
}


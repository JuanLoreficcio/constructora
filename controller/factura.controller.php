<?php
 class Factura_Controller{
 function crearFactura($id_persona,$id_tipo,$id_estado,$total,$descuento){
         $factura = new Factura_Model();
        $result = $factura->crearFactura($id_persona, $id_tipo, $id_estado, $total, $descuento);
        return $result;
    }
    function modificarFactura($id_factura,$fecha,$id_persona,$id_tipo,$id_estado,$total,$descuento){
        $factura = new Factura_Model();
        $result = $factura->modificarFactura($id_factura, $fecha, $id_persona, $id_tipo, $id_estado, $total, $descuento);
        return $result;
    }
    function eliminarFactura($id_factura){
        $factura = new Factura_Model();
        $result = $factura->eliminarFactura($id_factura);
        return $result;
    }
    function verFactura(){
        $factura = new Factura_Model();
        $result = $factura->verFactura();
        return $result;
    }
    function verFacturaPersona($id_persona){
        $factura = new Factura_Model();
        $result = $factura->verFacturaPersona($id_persona);
        return $result;
    }
    function verFacturaFecha($fecha){
        $factura = new Factura_Model();
        $result = $factura->verFacturaFecha($fecha);
        return $result;
    }
 }

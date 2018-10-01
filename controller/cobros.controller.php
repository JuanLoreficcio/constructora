<?php
class Cobros_Controller {
    function nuevoCobro($fecha,$monto,$factura,$id_persona){
        $cobro = new Cobros_Model();
        $result = $cobro->nuevoCobro($fecha, $monto, $factura, $id_persona);
        return $result;
    }
    function  modificarCobro($id_cobro,$fecha,$monto,$factura, $id_persona){
        $cobro = new Cobros_Model();
        $result = $cobro->modificarCobro($id_cobro, $fecha, $monto, $factura, $id_persona);
        return $result;
    }
    function eliminarCobro($id_cobro){
        $cobro = new Cobros_Model();
        $result = $cobro->eliminarCobro($id_cobro);
        return $result;
    }
    function verCobro(){
        $cobro = new Cobros_Model();
        $result =  $cobro->verCobro();
        return $result;
    }
    function verCobro_date($date){
        $cobro = new Cobros_Model();
        $result =  $cobro->verCobro_date($date);
        return $result;
    }
    function verCobro_id($id_persona){
          $cobro = new Cobros_Model();
        $result =  $cobro->verCobro_id($id_persona);
        return $result;
    }
}

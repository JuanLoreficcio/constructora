<?php
class Producto_Controller{
     function nuevoProducto($name, $price){
       $var_producto = new Producto_model();
       $var_producto->nuevoProducto($name, $price);
    }
    
    function modificarProducto ($id_producto,$name, $price){
        $var_producto = new Producto_model();
        $var_producto->modificarProducto($id_producto, $name, $price);
  }
  
    function eliminarProducto($id_producto){
        $var_producto = new Producto_model();
        $var_producto->eliminarProducto($id_producto);
}

function  verProductos(){
    $var_producto = new Producto_model();
    $result =  $var_producto->verProductos();
    return $result;
}

function verProductos_name($name){
    $var_producto = new Producto_model();
    return $var_producto->verProductos_name($name);
}

function  verProductos_price($price){
    $var_producto = new Producto_model();
    return $var_producto->verProductos_name($price);
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
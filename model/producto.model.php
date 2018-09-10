<?php

class Producto_model{
    function nuevoProducto($name, $price){
        global $db;
        $sql = "INSERT INTO `producto`(`id_producto`, `name`, `price`) VALUES (NULL,'$name','$price');";
        $db->insert($sql);
    }
    
    function modificarProducto ($id_producto,$name, $price){
      global $db;
      $sql = "UPDATE `producto` SET `name` = '$name', `price` = '$price' WHERE `producto`.`id_producto` = $id_producto;";
      $db->update($sql);
  }
  
    function eliminarProducto($id_producto){
     global $db;
     $sql = "DELETE FROM `producto` WHERE `producto`.`id_producto` = $id_producto;";
     $db->delete($sql);
}

function  verProductos(){
    global $db;
    $sql = "SELECT `id_producto`,`name`,`price` FROM `producto` ORDER BY `name`;";
    $result = $db->query($sql);
    if($result){
    return $result;}
     else{
     return false;}
}

function verProductos_name($name){
    global $db;
    $sql = "SELECT `id_producto`,`name`,`price` FROM `producto` WHERE name = '$name' ORDER BY price;";
    $result = $db->query($sql);
    if($result){
        return $result;
    } else {
        return false;
    }
}

function  verProductos_price($price){
    global $db;
    $sql = "SELECT * FROM `producto` WHERE price = '$price' ORDER BY name;";
    $result = $db->query($sql);
    if($result){
        return $result;
    } else {
        return false;
        }
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
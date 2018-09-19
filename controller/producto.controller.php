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
    $tpl = new TemplatePower("templates/listadoProducto.html");
    $tpl->prepare();
    $tpl->gotoBlock("_ROOT");
    
    $var_producto = new Producto_model();
    $result =  $var_producto->verProductos();
    
    if($result){
        $tpl->gotoBlock("_ROOT");
        foreach ($result as $r){
            $tpl->newBlock("block_listado_productos");
            $tpl->assign("var_list_cod",$r["id_producto"]);
            $tpl->assign("var_list_nombre",$r["name"]);
            $tpl->assign("var_list_precio",$r["price"]);
        }
    }else{
        $tpl->newBlock("block_no_listado_productos");
    }
    
    return $tpl->getOutputContent();
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

?>
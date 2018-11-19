<?php
class Producto_Controller{
    function nuevoProducto(){
        $nameProducto = strip_tags($_REQUEST ["nameProducto"]);
        $priceProducto = strip_tags($_REQUEST ["priceProducto"]);
        $var_producto = new Producto_model();
        if(is_string($nameProducto) && filter_var($priceProducto, FILTER_VALIDATE_FLOAT)){
            $var_producto->nuevoProducto($nameProducto, $priceProducto);    
        } else {
            echo "<script>
                alert('Ocurrio un error, no se pudieron cargar los datos deseados\nVuelva a intentarlo por favor');
                  </script>";
            return false;
        }
        return $this->verProductos();
    }
    
    function modificarProducto (){
        $id = strip_tags($_REQUEST ["id"]);
        $nameProducto = strip_tags($_REQUEST["nombre"]);
        $priceProducto = strip_tags($_REQUEST["price"]);
        if(is_string($nameProducto) && filter_var($priceProducto, FILTER_VALIDATE_FLOAT)){
            $var_producto = new Producto_model();
            $var_producto->modificarProducto($id, $nameProducto, $priceProducto);
        }else{
            echo "<script>
                alert('Ocurrio un error, no se pudieron cargar los datos deseados\nVuelva a intentarlo por favor');
                  </script>";
            return false;
        }
        
        return $this->verProductos();
    }
  
    function eliminarProducto(){
        $idProducto = strip_tags($_REQUEST ["id"]);
        $var_producto = new Producto_model();
        $respuesta = $var_producto->eliminarProducto($idProducto);
        if($respuesta==FALSE){
            echo "<script>
                alert('El producto deseado no puede eliminarse, posee documentos relacionados');
                </script>";
            exit();
        } 
        return $this->verProductos();
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

/*function verProducto(){
    $idProducto = strip_tags($_GET ["ProductoModifyId"]);
    $tpl = new TemplatePower("templates/modificarProducto.html");
    $tpl->prepare();
       
    $var_producto = new Producto_model();
    $res = $var_producto->verProducto($idProducto);
    
    $tpl->gotoBlock("_ROOT");
    foreach ($res as $r){
        $tpl->assign("var_id",$r["id_producto"]);    
        $tpl->assign("var_nameProducto",$r["name"]);
        $tpl->assign("var_priceProducto",$r["price"]);
    }

    
    echo $tpl->getOutputContent();
    }*/
    function altaProducto(){
        $tpl = new TemplatePower("templates/nuevoProducto.html");
        $tpl->prepare();
        return $tpl->getOutputContent();
    }
    function altaModificarProducto(){
        $idProducto = strip_tags($_REQUEST ["id"]);
        $producto = new Producto_model();
        $respuesta = $producto->verProducto($idProducto);
        $tpl = new TemplatePower("templates/modificarProducto.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        foreach ($respuesta as $res){
            $tpl->newBlock("block_modificar_productos");
            $tpl->assign("var_id",$res["id_producto"]);
            $tpl->assign("var_nameProducto",$res["name"]);
            $tpl->assign("var_priceProducto",$res["price"]);
        }
        
        return $tpl->getOutputContent();
    }
 }

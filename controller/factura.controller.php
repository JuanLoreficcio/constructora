<?php

class Factura_Controller {

    function nuevoFactura() {
        //jason decode
        $stringPedidos = strip_tags($_REQUEST['todos']);
        //$pedidos= explode(',',$stringPedidos); 
        $pedidos = json_decode($stringPedidos, TRUE);
       
        $stringPersona = strip_tags($_REQUEST['dataPersona']);
        //$pedidos= explode(',',$stringPedidos); 
        $persona = json_decode($stringPersona, TRUE);
        
        $pedido = new Pedido_Model();
        $factura = new Factura_Model();

        $id_tipo = strip_tags($_REQUEST['tipo']);
        $id_estado = strip_tags($_REQUEST['estado']);
        $id_estado++;
        
        $total = 0;
        $tamArreglo = count($pedidos);
        $fechaActual = strip_tags($_REQUEST['fechaActual']);
        $fechaEntrega = strip_tags($_REQUEST['fechaEntrega']);


        for ($i = 0; $i < $tamArreglo; $i++) {
            if ($pedidos[$i][5]) {
                $total += $pedidos[$i][3];
            }
        }
        
        $id_persona = 0;
        if (empty($persona)) {
            $id_persona = strip_tags($_REQUEST['cliente']);
            $id_factura = $factura->nuevoFactura($id_persona, $id_tipo, $id_estado, $total, $fechaActual, $fechaEntrega, 0);
            
            for ($i = 0; $i < $tamArreglo; $i++) {
                $precioU = $pedidos[$i][1];
                $cantidad = $pedidos[$i][2];
                $subtotal = $pedidos[$i][3];
                $id_producto = $pedidos[$i][4];
                if ($pedidos[$i][5]) {
                    $pedido->crearPedido($id_producto, $id_factura, $precioU, $cantidad, $subtotal);
                }
            }
        }else{
            $var_persona = new Persona_Model();
            $id_persona = $var_persona->nuevaPersona($persona[0], $persona[1], $persona[2], $persona[3], $persona[4]);

            $id_factura = $factura->nuevoFactura($id_persona, $id_tipo, $id_estado, $total, $fechaActual, $fechaEntrega, 0);
            
            for ($i = 0; $i < $tamArreglo; $i++) {
                $precioU = $pedidos[$i][1];
                $cantidad = $pedidos[$i][2];
                $subtotal = $pedidos[$i][3];
                $id_producto = $pedidos[$i][4];
                if ($pedidos[$i][5]) {
                    $pedido->crearPedido($id_producto, $id_factura, $precioU, $cantidad, $subtotal);
                }
            }
        }
        $cadena = "Location: index.php?action=Factura::verFactura&id=".$id_factura;
        return header($cadena);
    }

    function modificarFactura($id_factura, $fecha, $id_persona, $id_tipo, $id_estado, $total, $descuento) {
        $factura = new Factura_Model();
        $result = $factura->modificarFactura($id_factura, $fecha, $id_persona, $id_tipo, $id_estado, $total, $fechaActual, $fechaEntrega, $descuento);
        return $result;
    }

    function eliminarFactura($id_factura) {
        $factura = new Factura_Model();
        $result = $factura->eliminarFactura($id_factura);
        return $result;
    }

    function verTodasFactura() {
        $type = $_GET["type"];
        $tpl = new TemplatePower("templates/listadoFacturas.html");
        $tpl->prepare();
        $factura = new Factura_Model();
        $result = $factura->verTodasFactura();
        if ($type == "compra") {
            $tpl->assign("var_nueva", "Nueva compra");
            $tpl->assign("var_accion", "1");
            if ($result) {
                $tpl->gotoBlock("_ROOT");
                foreach ($result as $r) {
                    if ($r["tipo_name"] == "compra") {
                        $tpl->newBlock("block_listado_facturas");
                        $tpl->assign("var_list_cod", $r["id_factura"]);
                        $tpl->assign("var_list_fecha", $r["fecha"]);
                        $tpl->assign("var_list_titular", $r["persona_name"]);
                        $tpl->assign("var_list_estado", $r["estado_name"]);
                        $tpl->assign("var_list_total", $r["total"]);
                    }
                }
            } else {
                $tpl->gotoBlock("_ROOT");
                $tpl->newBlock("block_no_listado_facturas");
            }
        } else {
            $tpl->assign("var_nueva", "Nueva venta");
            $tpl->assign("var_accion", "2");
            if ($result) {
                $tpl->gotoBlock("_ROOT");
                foreach ($result as $r) {
                    if ($r["tipo_name"] == "venta") {
                        $tpl->newBlock("block_listado_facturas");
                        $tpl->assign("var_list_cod", $r["id_factura"]);
                        $tpl->assign("var_list_fecha", $r["fecha"]);
                        $tpl->assign("var_list_titular", $r["persona_name"]);
                        $tpl->assign("var_list_estado", $r["estado_name"]);
                        $tpl->assign("var_list_total", $r["total"]);
                    }
                }
            } else {
                $tpl->gotoBlock("_ROOT");
                $tpl->newBlock("block_no_listado_facturas");
            }
        }
        return $tpl->getOutputContent();
    }

    function verFacturaPersona($id_persona) {
        $factura = new Factura_Model();
        $result = $factura->verFacturaPersona($id_persona);
        return $result;
    }

    function verFacturaFecha($fecha) {
        $factura = new Factura_Model();
        $result = $factura->verFacturaFecha($fecha);
        return $result;
    }

    function verFactura() {
        $id_factura = strip_tags($_REQUEST["id"]);
        $tpl = new TemplatePower("templates/verFactura.html");
        $tpl->prepare();
        $factura = new Factura_Model();
        $resulta = $factura->verFactura($id_factura);
        $tpl->gotoBlock("_ROOT");
        foreach ($resulta as $result) {
            $tpl->assign("var_factura_code", $result["id_factura"]);
            $tpl->assign("var_factura_fecha", $result["fecha"]);
            $tpl->assign("var_persona_name", $result["persona_name"]);
            $tpl->assign("var_persona_address", $result["address"]);
            $tpl->assign("var_persona_mail", $result["mail"]);
            $tpl->assign("var_factura_tipo", $result["tipo_name"]);
            $tpl->assign("var_factura_estado", $result["estado_name"]);
        }

        
        $pedido = $factura->verPedidoFactura($id_factura);
        
        $tpl->gotoBlock("_ROOT");
        foreach ($pedido as $r) {
            $tpl->newBlock("block_factura");
            $tpl->assign("var_pedido_name", $r["name"]);
            $tpl->assign("var_pedido_price", $r["precio"]);
            $tpl->assign("var_pedido_cantidad", $r["cantidad"]);
            $tpl->assign("var_pedido_total", $r["total"]);
        }
        $tpl->gotoBlock("_ROOT");
        $tpl->assign("var_factura_total", $result["total"]);
        return $tpl->getOutputContent();
    }

    function altaFactura() {
        $accion = strip_tags($_REQUEST["act"]);
        $fecha = getdate();
        $d = $fecha["mday"];
        $m = $fecha["mon"];
        $a = $fecha["year"];
        $conFecha = $d . "-" . $m . "-" . $a;

        $tpl = new TemplatePower("templates/nuevaFactura.html");
        $tpl->prepare();

        $personas = new Persona_Model();
        $producto = new Producto_Model();
        $factura = new Factura_Model();
        
        $ultima_factura = $factura->ultimoPedido();
        
        $tpl->gotoBlock("_ROOT");
        foreach ($ultima_factura as $u){
            $nro_factura=$u["id"]+1;
            $tpl->assign("nro_pedido",$nro_factura);
        }

        
        if ($accion == "1") {
            $tpl->gotoBlock("_ROOT");
            $tpl->assign("var_fecha", $conFecha);
            $tpl->gotoBlock("_ROOT");
            $personitas = $personas->verPersonas();
            $productos = $producto->verProductos();
            foreach ($personitas as $r) {
                if ($r["rol"] == 0) {
                    $tpl->newBlock("block_cliente");
                    $tpl->assign("idCliente", $r["id_persona"]);
                    $tpl->assign("var_cliente", $r["name"]);
                }
            }

            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_tipo_pedido");
            $tpl->assign("idTipo", 1);
            $tpl->assign("var_tipo", "Compra");
            $tpl->assign("fijo", "selected");
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_tipo_pedido");
            $tpl->assign("idTipo", 2);
            $tpl->assign("var_tipo", "Venta");
            $tpl->assign("fijo", "");

            $tpl->gotoBlock("_ROOT");
            $tpl->assign("idTipoPosta", 1);
            $tpl->gotoBlock("_ROOT");
            foreach ($productos as $p) {
                $tpl->newBlock("producto_factura");
                $tpl->assign("idProducto", $p["id_producto"]);
                $tpl->assign("precioProducto", $p["price"]);
                $tpl->assign("var_producto", $p["name"]);
            }
            $tpl->gotoBlock("_ROOT");
            $tpl->assign("var_nueva_rol", 0);
        } else {
            $tpl->gotoBlock("_ROOT");
            $tpl->assign("var_fecha", $conFecha);
            $tpl->gotoBlock("_ROOT");
            $personitas = $personas->verPersonas();
            $productos = $producto->verProductos();
            foreach ($personitas as $r) {
                if ($r["rol"] == 1) {
                    $tpl->newBlock("block_cliente");
                    $tpl->assign("idCliente", $r["id_persona"]);
                    $tpl->assign("var_cliente", $r["name"]);
                }
            }

            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_tipo_pedido");
            $tpl->assign("idTipo", 1);
            $tpl->assign("var_tipo", "Compra");
            $tpl->assign("fijo", "");
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_tipo_pedido");
            $tpl->assign("idTipo", 2);
            $tpl->assign("var_tipo", "Venta");
            $tpl->assign("fijo", "selected");

            $tpl->gotoBlock("_ROOT");
            $tpl->assign("idTipoPosta", 2);

            $tpl->gotoBlock("_ROOT");
            foreach ($productos as $p) {
                $tpl->newBlock("producto_factura");
                $tpl->assign("idProducto", $p["id_producto"]);
                $tpl->assign("precioProducto", $p["price"]);
                $tpl->assign("var_producto", $p["name"]);
            }
            $tpl->gotoBlock("_ROOT");
            $tpl->assign("var_nueva_rol", 1);
        }



        return $tpl->getOutputContent();
    }

    function verFacturasPersona($id_persona) {
        $var_factura_persona = new Factura_Model();
        $row = $var_factura_persona->verFacturaPersona($id_persona);
        $respuesta = [];
        $listado;
        foreach ($row as $r) {
            $pedidos = $var_factura_persona->verPedidoFactura($r);
            foreach ($pedidos as $p) {
                $listado += $p . " ";
            }
            $aux = [$detalle => $listado, $numero => $r];
            array_push($respuesta, $aux);
            $aux = [];
        }
        //BUSCAR UN VECTOR AUXILIAR QUE ME GUARDE LA DUPLA DE COD_FACTURA Y CADENA
        //PARA DEVOLVER VECTOR RESPUESTAS
        return $respuesta;
    }

}

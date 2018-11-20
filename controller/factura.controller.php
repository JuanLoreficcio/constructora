<?php

class Factura_Controller {

    function nuevoFactura() {
        if ($_SESSION["conect"] == TRUE) {
            $stringPersona = strip_tags($_REQUEST['dataPersona']);
            //$pedidos= explode(',',$stringPedidos); 
            $persona = json_decode($stringPersona, TRUE);

            $pedido = new Pedido_Model();
            $factura = new Factura_Model();
            $var_producto = new Producto_Model();

            $producto = $var_producto->verProductos();
            $todo = [];
            $totales = 0;
            $cont = 0;
            $ERROR = 0;
            foreach ($producto as $p) {
                $data = [];
                $text = $p["id_producto"];
                if (isset($_REQUEST[$text])) {
                    $cantidadId = "cantidadId-" . $p["id_producto"];
                    $precioId = "precioId-" . $p["id_producto"];
                    $totalId = "totalIds-" . $p["id_producto"];

                    $cantidad = $_REQUEST[$cantidadId];
                    $precio = $_REQUEST[$precioId];

                    if (isset($_REQUEST[$totalId])) {
                        $total = $_REQUEST[$totalId];
                    } else {
                        $total = NULL;
                    }

                    if (!filter_var($cantidad, FILTER_VALIDATE_FLOAT) || !filter_var($precio, FILTER_VALIDATE_FLOAT) || !filter_var($total, FILTER_VALIDATE_FLOAT) || $total == NULL) {
                        $ERROR = -1;
                    } else {
                        array_push($data, $cantidad);
                        array_push($data, $precio);
                        array_push($data, $total);
                        array_push($data, $p["id_producto"]);
                        $totales += $total;
                        array_push($todo, $data);
                        $cont++;
                    }
                }
            }

            $id_tipo = strip_tags($_REQUEST['tipo']);
            $id_estado = strip_tags($_REQUEST['estado']);
            $id_estado++;


            $fechaActual = strip_tags($_REQUEST['fechaActual']);
            $fechaEntrega = strip_tags($_REQUEST['fechaEntrega']);
            if (isset($_REQUEST['codigoParaCompra'])) {
                $codigoCompra = strip_tags($_REQUEST['codigoParaCompra']);
            } else {
                $codigoCompra = NULL;
            }


            if (filter_var($fechaActual, FILTER_VALIDATE_FLOAT) || filter_var($fechaEntrega, FILTER_VALIDATE_FLOAT)) {
                die("<script>
                alert('Ocurrio un error, no se pudieron cargar los datos deseados\nVuelva a intentarlo por favor');
                  </script>");
            } else {

                $id_persona = 0;
                if (empty($persona)) {
                    $id_persona = strip_tags($_REQUEST['cliente']);
                    $id_factura = $factura->nuevoFactura($id_persona, $id_tipo, $id_estado, $totales, $fechaActual, $fechaEntrega, 0, $codigoCompra);

                    for ($i = 0; $i < $cont; $i++) {
                        $precioU = $todo[$i][1];
                        $cantidad = $todo[$i][0];
                        $subtotal = $todo[$i][2];
                        $id_producto = $todo[$i][3];
                        $pedido->crearPedido($id_producto, $id_factura, $precioU, $cantidad, $subtotal);
                    }
                } else {
                    $var_persona = new Persona_Model();
                    $id_persona = $var_persona->nuevaPersona($persona[0], $persona[1], $persona[2], $persona[3], $persona[4]);

                    $id_factura = $factura->nuevoFactura($id_persona, $id_tipo, $id_estado, $totales, $fechaActual, $fechaEntrega, 0, $codigoCompra);

                    for ($i = 0; $i < $cont; $i++) {
                        $precioU = $todo[$i][1];
                        $cantidad = $todo[$i][0];
                        $subtotal = $todo[$i][2];
                        $id_producto = $todo[$i][3];
                        $pedido->crearPedido($id_producto, $id_factura, $precioU, $cantidad, $subtotal);
                    }
                }
            }
            $cadena = "Location: index.php?action=Factura::verFactura&id=" . $id_factura;
            if ($ERROR == -1) {
                return header("Location: templates/error.html");
            } else {
                return header($cadena);
            }
        } else {
            return header("Location: index.php");
        }
    }

    function modificarFactura() {
        if ($_SESSION["conect"] == TRUE) {
            $stringTabla = strip_tags($_REQUEST['tabla']);
            $tabla = json_decode($stringTabla, TRUE);
            $id_total_productos = $tabla[0][6];

            $factura = new Factura_Model();
            $var_producto = new Producto_Model();

            $id_factura = strip_tags($_REQUEST['codigo']);
            $producto = $var_producto->verProductos();
            $todo = [];
            $pedidosActuales = [];
            $totales = 0;
            $cont = 0;
            $listaPedidosString = strip_tags($_REQUEST['listaPedidos']);
            $listaPedidos = explode(',', $listaPedidosString);

            for ($i = 0; $i < $id_total_productos; $i++) {
                $data = [];
                if ($tabla[$i][0] == "yes") { //veo si esta chekeado
                    $cantidad = $tabla[$i][2]; //saco cantidad
                    array_push($data, $cantidad);

                    $precio = $tabla[$i][1];   //Saco precio
                    array_push($data, $precio);

                    $total = (float) $tabla[$i][3];   //saco total
                    array_push($data, $total);

                    array_push($data, $tabla[$i][4]); //saco id Producto

                    $pedido = $tabla[$i][5]; //saco numero pedido    

                    array_push($data, $pedido);
                    array_push($pedidosActuales, $pedido);

                    $totales += $total;
                    array_push($todo, $data);
                    $cont++;
                }
            }
            $id_tipo = strip_tags($_REQUEST['tipos']);
            $id_estado = strip_tags($_REQUEST['estado']);
            $id_estado++;


            $fechaActual = strip_tags($_REQUEST['fechaActual']);
            $fechaEntrega = strip_tags($_REQUEST['fechaEntrega']);

            $id_persona = strip_tags($_REQUEST['cliente']);

            $factura->modificarFactura($id_factura, $fechaActual, $fechaEntrega, $id_persona, $id_tipo, $id_estado, $totales);

            $tamPedidoActuales = count($listaPedidos);
            $pedidos_eliminar = [];

            for ($i = 0; $i < $tamPedidoActuales; $i++) {
                if (!in_array($listaPedidos[$i], $pedidosActuales)) {
                    array_push($pedidos_eliminar, $listaPedidos[$i]);
                }
            }


            $pedido = new Pedido_Model();
            for ($i = 0; $i < $cont; $i++) {
                $precioU = $todo[$i][1];
                $cantidad = $todo[$i][0];
                $subtotal = $todo[$i][2];
                $id_producto = (string) $todo[$i][3];
                $id_pedido = $todo[$i][4];
                $arreglo = [];




                if (in_array($id_pedido, $listaPedidos)) {
                    $pedido->modificarPedido($id_pedido, $id_producto, $id_factura, $precioU, $cantidad, $subtotal);
                    echo 'entro a uno existente';
                } elseif ($id_pedido == null) {
                    $pedido->crearPedido($id_producto, $id_factura, $precioU, $cantidad, $subtotal);
                    echo 'creo uno nuevo';
                }
            }

            $tamEliminar = count($pedidos_eliminar);
            for ($i = 0; $i < $tamPedidoActuales; $i++) {
                $pedido->descartarPedido($pedidos_eliminar[$i]);
            }

            if ($total == 0) {
                $factura->eliminarFactura($id_factura);
                if ($id_tipo) {
                    $cadena = "Location: index.php?action=Factura::verTodasFactura&type=venta";
                } else {
                    $cadena = "Location: index.php?action=Factura::verTodasFactura&type=compra";
                }
            } else {
                $cadena = "Location: index.php?action=Factura::verFactura&id=" . $id_factura;
            }

            return header($cadena);
        } else {
            return header("Location: index.php");
        }
    }

    function altaModificarFactura() {
        if ($_SESSION["conect"] == TRUE) {
            $id_factura = strip_tags($_REQUEST["id"]);

            $tpl = new TemplatePower("templates/modificarFactura.html");
            $tpl->prepare();

            $factura = new Factura_Model();
            $resulta = $factura->verFactura($id_factura);

            $tpl->gotoBlock("_ROOT");
            foreach ($resulta as $result) {
                $tpl->assign("nro_pedido", $result["id_factura"]);
                $tpl->assign("var_fecha", $result["fecha"]);
                $tpl->assign("var_fecha_entrega", $result["fecha_entrega"]);
                $tpl->assign("var_cliente", $result["persona_name"]);
                $tpl->assign("id_cliente", $result["persona_id"]);
                $tpl->assign("var_tipo", $result["tipo_name"]);
                $tpl->assign("idTipoPosta", $result["tipo_id"]);
                if ($result["estado_id"] == 1) {
                    $tpl->assign("var_estado0", "selected");
                } elseif ($result["estado_id"] == 2) {
                    $tpl->assign("var_estado1", "selected");
                } elseif ($result["estado_id"] == 3) {
                    $tpl->assign("var_estado2", "selected");
                } else {
                    $tpl->assign("var_estado3", "selected");
                }
            }


            $pedido = $factura->verPedidoFactura($id_factura);
            $var_producto = new Producto_Model();
            $producto = $var_producto->verProductos();
            $tpl->gotoBlock("_ROOT");
            $cantidad_producto = 0;
            $listaPedidos = [];
            foreach ($producto as $prod) {
                $cadena2 = "productoId-" . $cantidad_producto;
                $producto_id = $prod["id_producto"];
                foreach ($pedido as $r) {
                    $tpl->gotoBlock("_ROOT");
                    $tpl->newBlock("block_productos");
                    $tpl->assign("idProducto", $producto_id);
                    $tpl->assign("numeroProducto", $cantidad_producto);

                    $precioProducto = "precioId-" . $producto_id; //ejemplo de id: precioId-1
                    $tpl->assign("precioProducto", $precioProducto);

                    $cantidadProducto = "cantidadId-" . $producto_id;
                    $tpl->assign("cantidadProducto", $cantidadProducto);

                    $totalProducto = "totalId-" . $producto_id;
                    $tpl->assign("totalProducto", $totalProducto);



                    if ($producto_id == $r["producto_id"]) {
                        $tpl->assign("valueCheck", "yes");
                        $tpl->assign("chekeado", "checked");
                        $tpl->assign("var_producto", $r["name"]);
                        $tpl->assign("precioProductoValor", $r["precio"]);
                        $tpl->assign("cantidadProductoValor", $r["cantidad"]);
                        $tpl->assign("totalProductoValor", $r["pedido_total"]);
                        $tpl->assign("cod_pedido", $r["pedido_id"]);
                        array_push($listaPedidos, $r["pedido_id"]);
                    } else {
                        $tpl->assign("valueCheck", "no");
                        $tpl->assign("var_producto", $prod["name"]);
                        $tpl->assign("precioProductoValor", $prod["price"]);
                    }
                    $tpl->assign("idProductoId", $cadena2);
                }
                $cantidad_producto++;
            }

            $tpl->gotoBlock("_ROOT");
            $aux = implode(',', $listaPedidos);
            $tpl->assign("listaPedidos", $aux);
            $tpl->assign("cantidad_productos", $cantidad_producto);



            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function eliminarFactura() {
        if ($_SESSION["conect"] == TRUE) {
            $type = $_GET["type"];
            $id_factura = $_GET["id"];
            $factura = new Factura_Model();
            $pedido = new Pedido_Model();

            $pedidos = $factura->verPedidoFactura($id_factura);
            foreach ($pedidos as $ped) {
                $pedido->descartarPedido($ped["pedido_id"]);
            }
            $result = $factura->eliminarFactura($id_factura);

            $cadena = "Location: index.php?action=Factura::verTodasFactura&type=" . $type;
            return header($cadena);
        } else {
            return header("Location: index.php");
        }
    }

    function verTodasFactura() {
        if ($_SESSION["conect"] == TRUE) {
            $type = $_GET["type"];
            $tpl = new TemplatePower("templates/listadoFacturas.html");
            $tpl->prepare();
            $factura = new Factura_Model();
            $result = $factura->verTodasFactura();
            if ($type == "compra") {
                $tpl->assign("var_nueva", "Nueva compra");
                $tpl->assign("var_accion", "1");
                $tpl->assign("var_list_estado", "1");
                if ($result) {
                    $tpl->gotoBlock("_ROOT");
                    foreach ($result as $r) {
                        if ($r["tipo_name"] == "compra") {
                            $tpl->newBlock("block_listado_facturas");
                            $tpl->assign("var_list_cod", $r["id_factura"]);
                            $tpl->assign("var_list_esta", "compra");
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
                            $tpl->assign("var_list_esta", "venta");
                        }
                    }
                } else {
                    $tpl->gotoBlock("_ROOT");
                    $tpl->newBlock("block_no_listado_facturas");
                }
            }
            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
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
        if ($_SESSION["conect"] == TRUE) {
            $id_factura = strip_tags($_REQUEST["id"]);
            $tpl = new TemplatePower("templates/verFactura.html");
            $tpl->prepare();
            $factura = new Factura_Model();
            $resulta = $factura->verFactura($id_factura);
            $tpl->gotoBlock("_ROOT");
            $total = 0;
            foreach ($resulta as $result) {
                $tpl->assign("var_factura_code", $result["id_factura"]);
                $tpl->assign("var_factura_fecha", $result["fecha"]);
                $tpl->assign("var_factura_fecha_entrega", $result["fecha_entrega"]);
                $tpl->assign("var_persona_name", $result["persona_name"]);
                $tpl->assign("var_persona_address", $result["address"]);
                $tpl->assign("var_persona_mail", $result["mail"]);
                $tpl->assign("var_factura_tipo", $result["tipo_name"]);
                $tpl->assign("var_factura_estado", $result["estado_name"]);
                if ($result["tipo_name"] == "compra") {
                    $tpl->assign("pedido", "Nº PEDIDO");
                    $tpl->assign("codigoPedido", $result["codiogoCompra"]);
                }

                $total = $result["total"];
            }


            $pedido = $factura->verPedidoFactura($id_factura);

            $tpl->gotoBlock("_ROOT");
            foreach ($pedido as $r) {
                $tpl->newBlock("block_factura");
                $tpl->assign("var_pedido_name", $r["name"]);
                $tpl->assign("var_pedido_price", $r["precio"]);
                $tpl->assign("var_pedido_cantidad", $r["cantidad"]);
                $tpl->assign("var_pedido_total", $r["pedido_total"]);
            }
            $tpl->gotoBlock("_ROOT");
            $tpl->assign("var_factura_total", $total);
            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function altaFactura() {
        if ($_SESSION["conect"] == TRUE) {
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
            foreach ($ultima_factura as $u) {
                $nro_factura = $u["id"] + 1;
                $tpl->assign("nro_pedido", $nro_factura);
            }


            if ($accion == "1") {
                $tpl->gotoBlock("_ROOT");
                $tpl->assign("var_fecha", $conFecha);
                $tpl->assign("var_fecha_entrega", $conFecha);
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
                $tpl->assign("tituloParaTemplate", "<label for='codigo'>Código de pedido:</label>");
                $tpl->assign("codigoParaCompra", "<input id='codigoParaCompra' name='codigoParaCompra' class='form-control' type='text' value=''>");
                $tpl->assign("funcion_retorno", "Factura::verTodasFactura&type=compra");
                //Hasta acá era el encabezado del pedido
                $tpl->gotoBlock("_ROOT");
                foreach ($productos as $p) {
                    $tpl->newBlock("block_productos");
                    $tpl->assign("idProducto", $p["id_producto"]);

                    $precioProducto = "precioId-" . $p["id_producto"]; //ejemplo de id: precioId-1
                    $tpl->assign("precioProducto", $precioProducto);


                    $tpl->assign("var_producto", $p["name"]);
                    $tpl->assign("precioProductoValor", $p["price"]);


                    $cantidadProducto = "cantidadId-" . $p["id_producto"];
                    $tpl->assign("cantidadProducto", $cantidadProducto);

                    $tpl->assign("valueCheck", "no");

                    $totalProducto = "totalId-" . $p["id_producto"];
                    $tpl->assign("totalProducto", $totalProducto);
                }
                $tpl->gotoBlock("_ROOT");
                $tpl->assign("var_nueva_rol", 0);
            } else {
                $tpl->gotoBlock("_ROOT");
                $tpl->assign("var_fecha", $conFecha);
                $tpl->assign("var_fecha_entrega", $conFecha);
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
                $tpl->assign("funcion_retorno", "Factura::verTodasFactura&type=venta");
                //Hasta acá era el encabezado del pedido
                $tpl->gotoBlock("_ROOT");
                foreach ($productos as $p) {
                    $tpl->newBlock("block_productos");
                    $tpl->assign("idProducto", $p["id_producto"]);

                    $precioProducto = "precioId-" . $p["id_producto"]; //ejemplo de id: precioId-1
                    $tpl->assign("precioProducto", $precioProducto);


                    $tpl->assign("var_producto", $p["name"]);
                    $tpl->assign("precioProductoValor", $p["price"]);


                    $cantidadProducto = "cantidadId-" . $p["id_producto"];
                    $tpl->assign("cantidadProducto", $cantidadProducto);

                    $tpl->assign("valueCheck", "no");


                    $totalProducto = "totalId-" . $p["id_producto"];
                    $tpl->assign("totalProducto", $totalProducto);
                }


                $tpl->gotoBlock("_ROOT");
                $tpl->assign("var_nueva_rol", 1);
            }



            return $tpl->getOutputContent();
        } else {
            return header("Location: index.php");
        }
    }

    function verFacturasPersona($id_persona) {
        if ($_SESSION["conect"] == TRUE) {
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
        } else {
            return header("Location: index.php");
        }
    }

}

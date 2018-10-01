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
    function verTodasFactura(){
        $tpl = new TemplatePower("templates/listadoFacturas.html");
        $tpl->prepare();
        $factura = new Factura_Model();
        $result = $factura->verTodasFactura();
        
        if($result){
            $tpl->gotoBlock("_ROOT");
            foreach ($result as $r){
            $tpl->newBlock("block_listado_facturas");
            $tpl->assign("var_list_cod",$r["id_factura"]);
            $tpl->assign("var_list_fecha",$r["fecha"]);
            $tpl->assign("var_list_titular",$r["persona_name"]);
            $tpl->assign("var_list_estado",$r["estado_name"]);
            $tpl->assign("var_list_total",$r["total"]);
            }
        }else{
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_no_listado_facturas");
        }
        
        return $tpl->getOutputContent();
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
    
    function verFactura(){
        $id_factura=strip_tags($_REQUEST["id"]);
        $tpl = new TemplatePower("templates/verFactura.html");
        $tpl->prepare();
        $factura = new Factura_Model();
        $resulta = $factura->verFactura($id_factura);
        $tpl->gotoBlock("_ROOT");
        foreach ($resulta as $result){
            $tpl->assign("var_factura_code",$result["id_factura"]);
            $tpl->assign("var_factura_fecha",$result["fecha"]);
            $tpl->assign("var_persona_name",$result["persona_name"]);
            $tpl->assign("var_persona_address",$result["address"]);
            $tpl->assign("var_persona_mail",$result["mail"]);
            $tpl->assign("var_factura_tipo",$result["tipo_name"]);
            $tpl->assign("var_factura_estado",$result["estado_name"]);
        }
        
        
        $pedido = $factura->verPedidoFactura($id_factura);
        $tpl->gotoBlock("_ROOT");
        foreach ($pedido as $r){
            $tpl->newBlock("block_factura");
            $tpl->assign("var_pedido_name",$r["name"]);
            $tpl->assign("var_pedido_price",$r["precio"]);
            $tpl->assign("var_pedido_cantidad",$r["cantidad"]);
            $tpl->assign("var_pedido_total",$r["total"]);
        }
        $tpl->gotoBlock("_ROOT");
        $tpl->assign("var_factura_total",$result["total"]);
        return $tpl->getOutputContent();
    }
    
 }

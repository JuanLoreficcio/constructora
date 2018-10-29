<?php
class Persona_Controller{
    function nuevaPersona (){
        $name= strip_tags($_REQUEST["namePersona"]);
        $adress=strip_tags($_REQUEST["dirPersona"]);
        $mail=strip_tags($_REQUEST["mailPersona"]);
        $phone=strip_tags($_REQUEST["telPersona"]); 
        $rol=strip_tags($_REQUEST["rol"]);
        $var_persona = new Persona_Model;
        $respuesta = $var_persona->nuevaPersona($name, $adress, $mail, $phone, $rol);
        return $this->verPersonas();
  }
      
    function modificarPersona (){
        $id_persona= strip_tags($_REQUEST["id"]);
        $date=strip_tags($_REQUEST["fecha"]);
        $name=strip_tags($_REQUEST["nombre"]);
        $adress=strip_tags($_REQUEST["direccion"]);
        $mail=strip_tags($_REQUEST["mail"]);
        $phone=strip_tags($_REQUEST["phone"]);
        $rol=strip_tags($_REQUEST["rol"]);
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->modificarPersona($id_persona,$date, $name, $adress, $mail, $phone, $rol);
        return $this->verPersonas();
  }
      
    function eliminarPersona(){
        $id_persona = strip_tags($_REQUEST["id"]);
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->eliminarPersona($id_persona);
        return $this->verPersonas();
  }
      
    function verPersona(){
        $id_Persona= strip_tags($_REQUEST["id"]);
        $var_persona = new Persona_Model;
        $respuesta = $var_persona->verPersona($id_Persona);
        $tpl = new TemplatePower("templates/verPersona.html");
        $tpl->prepare();
            
        foreach ($respuesta as $respuest){
            
        $tpl->assign("var_lis_cod",$respuest["id_persona"]);
        $tpl->assign("apellidoNombre",$respuest["name"]);
        $tpl->assign("direccion",$respuest["address"]);
        $tpl->assign("phone",$respuest["phone"]);
        $tpl->assign("mail",$respuest["mail"]);
        $type;
        if($respuest["rol"] == cliente){
                $tpl->assign("rol","Cliente");
                $type="cliente";
                }else{
                $tpl->assign("rol","Proveedor");
                $type="proveedor";
                }
        }
        $tpl->assign("var_type",$type);
        return $tpl->getOutputContent();
    }
        
    function verPersonasRol($rol){
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->verPersonasRol($rol);
        return $respuesta;
    }
    function verPersonas() {
        $type = $_GET["type"];
        $tpl = new TemplatePower("templates/listadoPersonas.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->listarSaldos();
        if ($type == "cliente") {
            $tpl->assign("var_list_rol", "Clientes");
            foreach ($respuesta as $r) {
                if ($r["rol"] == cliente) {
                    $tpl->newBlock("block_listado_personas");
                    $tpl->assign("var_list_nam", $r["name"]);
                    $tpl->assign("var_lis_cod", $r["id_persona"]);

                    $debeSQL = $var_persona->totalFactura($r["id_persona"]);
                    $debe = 0;
                    foreach ($debeSQL as $d) {
                        $debe = $d["suma_factura"];
                    }



                    $haberSQL = $var_persona->totalCobro($r["id_persona"]);
                    $haber = 0;
                    foreach ($haberSQL as $h) {
                        $haber = $h["suma_cobro"];
                    }
                    //if($haber==NULL)$haber=0;

                    $dif = $debe - $haber;
                    if ($dif <= 0) {
                        $tpl->assign("var_list_cuenta", "$ " . abs($dif));
                        $tpl->assign("color_cuenta", "btn btn-success");
                    } else {
                        $tpl->assign("var_list_cuenta", "-$ " . $dif);
                        $tpl->assign("color_cuenta", "btn btn-danger");
                    }
                }
            }
        } else {
            $tpl->assign("var_list_rol", "Proveedores");
            $tpl->gotoBlock("_ROOT");
            foreach ($respuesta as $r) {
                if ($r["rol"] == proveedor) {
                    $tpl->newBlock("block_listado_personas");
                    $tpl->assign("var_list_nam", $r["name"]);
                    $tpl->assign("var_lis_cod", $r["id_persona"]);


                    $debeSQL = $var_persona->totalFactura($r["id_persona"]);
                    $debe = 0;
                    foreach ($debeSQL as $d) {
                        $debe = $d["suma_factura"];
                    }



                    $haberSQL = $var_persona->totalCobro($r["id_persona"]);
                    $haber = 0;
                    foreach ($haberSQL as $h) {
                        $haber = $h["suma_cobro"];
                    }
                    //if($haber==NULL)$haber=0;

                    $dif = $debe - $haber;
                    if ($dif <= 0) {
                        $tpl->assign("var_list_cuenta", "$ " . abs($dif));
                        $tpl->assign("color_cuenta", "btn btn-success");
                    } else {
                        $tpl->assign("var_list_cuenta", "-$ " . $dif);
                        $tpl->assign("color_cuenta", "btn btn-danger");
                    }
                }
            }
        }

        return $tpl->getOutputContent();
    }

    function altaModificarPersona(){
        $idPersona = strip_tags($_REQUEST["id"]);
        $persona = new Persona_model();
        $respuesta = $persona->verPersona($idPersona);
            
        $tpl = new TemplatePower("templates/modificarPersona.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        foreach ($respuesta as $res){
            $tpl->assign("var_lis_cod",$res["id_persona"]);
            $tpl->assign("var_lis_fech",$res["createDate"]);
            $tpl->assign("apellidoNombre",$res["name"]);
            $tpl->assign("direccion",$res["address"]);
            $tpl->assign("phone",$res["phone"]);
            $tpl->assign("mail",$res["mail"]);
            $type="";
            if($res["rol"]==cliente){
                $type="cliente";
                $tpl->assign("defecto0","");
                $tpl->assign("defecto1","selected");
            }else{
                $type="proveedor";
                $tpl->assign("defecto0","selected");
                $tpl->assign("defecto1","");
            }
        }
        $tpl->assign("var_type",$type);    
        return $tpl->getOutputContent();
    }
    function altaPersona(){
        $tpl = new TemplatePower("templates/nuevaPersona.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        return $tpl->getOutputContent();
            
    }
    function verPersonaCuenta(){
        $id_persona=$_REQUEST["id"];
        $tpl = new TemplatePower("templates/detallesCompraVenta.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        
        $fecha= getdate();
        $d=$fecha["mday"];
        $m=$fecha["mon"];
        $a=$fecha["year"];
        $conFecha=$d."-".$m."-".$a;
       
        $cadena="";
        $var_persona= new Persona_Model();
        $persona = $var_persona->verPersona($id_persona);
        foreach ($persona as $person) {
            if($person["rol"]==cliente){
                $cadena="Cliente: ".$person["name"];
            } else {
                $cadena="Proveedor: ".$person["name"];
            }
        }
        $row = $var_persona->verCuentaFactura($id_persona);        
        $tpl->assign("var_list_titulo",$cadena);
       
        $debe=0;
        $haber=0;
        
        foreach ($row as $r) {
            $tpl->newBlock("block_listado_cuenta");
            $tpl->assign("var_list_fecha",$r["fecha"]); 
            $tpl->assign("var_list_nro_pedido",$r["codigo"]);
            
            if($r["tipo"]=='factura'){
                $tpl->assign("var_cuenta",$r["precio"]);
                $tpl->assign("var_abonado","");
                $tpl->assign("link","index.php?action=Factura::verFactura&id=".$id_persona);
                $debe+=$r["precio"];
            }else{
                $tpl->assign("var_cuenta","");
                $tpl->assign("var_abonado",$r["precio"]);
                $tpl->assign("link","index.php?action=Cobros::verCobro&id=".$r["codigo"]);
                $haber+=$r["precio"];
            }
            
            
            $tpl->assign("var_id_persona",$id_persona);
            //$tpl->assign("var_list_fecha",$r["fecha_cobro"]);

            
           
        }
        
        $tpl->gotoBlock("_ROOT");
        $actual=$debe-$haber;
        $tpl->assign("var_debe",$debe);
        $tpl->assign("var_haber",$haber);
        $tpl->assign("var_fecha",$conFecha);
        $tpl->assign("var_id_persona",$id_persona);
        if($actual>0){
            $tpl->assign("clase_estilo","text-danger");
            $tpl->assign("var_estado_cuenta",$actual);
        }else{
            $tpl->assign("clase_estilo","text-success");
            $tpl->assign("var_estado_cuenta",abs($actual));
        }
        
        
        return $tpl->getOutputContent();
    }
}


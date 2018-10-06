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
      
    function verPersonas(){
        $tpl = new TemplatePower("templates/listadoPersonas.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
            
        $var_persona = new Persona_Model();
        $respuesta =  $var_persona->verPersonas();
            
        if($respuesta){
            $tpl->gotoBlock("_ROOT");
            foreach ($respuesta as $r){
                $tpl->newBlock("block_listado_personas");
                $tpl->assign("var_list_nam",$r["name"]);
                $tpl->assign("var_list_direccion",$r["address"]);
                $tpl->assign("var_list_email",$r["mail"]);
                $tpl->assign("var_lis_cod",$r["id_persona"]);
                if($r["rol"] == cliente){
                    
                $tpl->assign("var_list_rol","Cliente");
                }else{
                $tpl->assign("var_list_rol","Proveedor");
                }
            }
        }else{
            $tpl->newBlock("block_no_listado_personas");
        }
       return $tpl->getOutputContent();
    }
        
    function verPersonasRol($rol){
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->verPersonasRol($rol);
        return $respuesta;
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
        if($respuest["rol"] == cliente){
            
                $tpl->assign("rol","Cliente");
                }else{
                $tpl->assign("rol","Proveedor");
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
            if($res["rol"]==cliente){
                $tpl->assign("defecto0","");
                $tpl->assign("defecto1","selected");
            }else{
                $tpl->assign("defecto0","selected");
                $tpl->assign("defecto1","");
            }
        }
            
        return $tpl->getOutputContent();
    }
    function altaPersona(){
        $tpl = new TemplatePower("templates/nuevaPersona.html");
        $tpl->prepare();
        $tpl->gotoBlock("_ROOT");
        return $tpl->getOutputContent();
            
    }
}


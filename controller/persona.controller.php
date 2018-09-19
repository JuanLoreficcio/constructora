<?php
class Persona_Controller{
   function nuevaPersona ($name, $adress, $mail, $phone, $rol){
        $var_persona = new Persona_Model;
        $respuesta = $var_persona->nuevaPersona($name, $adress, $mail, $phone, $rol);
        return $respuesta;
  }
  
    function modificarPersona ($id_persona,$date,$name, $adress, $mail, $phone, $rol){
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->modificarPersona($id_persona,$date, $name, $adress, $mail, $phone, $rol);
        return $respuesta;
  }
  
    function eliminarPersona($id_persona){
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->eliminarPersona($id_persona);
        return $respuesta;
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
                $tpl->assign("var_list_tel",$r["phone"]);
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
}

?>
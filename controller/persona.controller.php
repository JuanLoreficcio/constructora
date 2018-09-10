<?php
class Persona_Controller{
   function nuevaPersona ($name, $adress, $mail, $phone, $rol){
        $var_persona = new Persona_Model;
       return  $var_persona->nuevaPersona($name, $adress, $mail, $phone, $rol);       
  }
  
    function modificarPersona ($id_persona,$date,$name, $adress, $mail, $phone, $rol){
        $var_persona = new Persona_Model();
        $var_persona->modificarPersona($id_persona,$date, $name, $adress, $mail, $phone, $rol);
  }
  
    function eliminarPersona($id_persona){
        $var_persona = new Persona_Model();
        $var_persona->eliminarPersona($id_persona);
  }
    
    function verPersonas(){
        $var_persona = new Persona_Model();
        $respuesta =  $var_persona->verPersonas();
        return $respuesta;
    }
    
    function verPersonasRol($rol){
        $var_persona = new Persona_Model();
        return $var_persona->verPersonasRol($rol);
    }
}

?>
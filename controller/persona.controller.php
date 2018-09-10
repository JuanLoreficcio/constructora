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
        $var_persona = new Persona_Model();
        $respuesta =  $var_persona->verPersonas();
        return $respuesta;
    }
    
    function verPersonasRol($rol){
        $var_persona = new Persona_Model();
        $respuesta = $var_persona->verPersonasRol($rol);
        return $respuesta;
    }
}

?>
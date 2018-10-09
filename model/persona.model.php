<?php //
class Persona_Model{
  function nuevaPersona ($name, $adress, $mail, $phone, $rol){
      global $db;
      $sql = "INSERT INTO `persona`(`id_persona`, `createDate`, `name`, `address`, `mail`, `phone`, `rol`) ".
             "VALUES (NULL,CURRENT_DATE(),'$name','$adress', '$mail', '$phone', '$rol')";
      $db->insert($sql);
  }
    function modificarPersona ($id_persona,$date,$name, $adress, $mail, $phone, $rol){
      global $db;
        $sql = "UPDATE `persona` SET `createDate` = '$date', `name` = '$name', `address` = '$adress',". 
      " `mail` = '$mail', `phone` = '$phone', `rol` = '$rol' WHERE `persona`.`id_persona` = $id_persona;";
      $db->update($sql);
  }
  
  function eliminarPersona($id_persona){
      global $db;
     $sql = "DELETE FROM `persona` WHERE `persona`.`id_persona` = '$id_persona';";
     $db->delete($sql);
  }
  
  function verPersonas(){
      global $db;
      $sql = "SELECT `id_persona`,`createDate`,`name`,`address`,`mail`,`phone`,`rol` FROM `persona` ORDER BY `id_persona`;";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{
          return false;
      } 
  }
  
  function verPersonasRol($rol){
      global $db;
        $sql = "SELECT * FROM persona WHERE persona.rol = '$rol' ORDER BY name";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  
  function verPersona($id_persona){
      global $db;
      $sql = "SELECT * FROM persona WHERE persona.id_persona = '$id_persona'";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  
}
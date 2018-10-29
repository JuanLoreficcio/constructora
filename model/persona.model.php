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
  
  function verCuentaFactura($id_persona){
       global $db;
       $sql="CREATE TEMPORARY TABLE temporal1(fecha DATE NOT NULL, codigo int NOT NULL, precio float NOT NULL,tipo varchar(50) NOT NULL);";
       $db->query($sql);
       $sql="CREATE TEMPORARY TABLE temporal2(fecha DATE NOT NULL, codigo int NOT NULL, precio float NOT NULL,tipo varchar(50) not null);";
       $db->query($sql);
       $sql= "INSERT INTO temporal1 "
               . "SELECT f.fecha as feha_factura,f.id_factura,f.total,'factura' "
               . "FROM persona p, factura f "
               . "WHERE p.id_persona = '$id_persona' "
               . "AND p.id_persona = f.id_persona;";
       $db->query($sql);
       $sql= "INSERT INTO temporal2 "
               . "SELECT c.fecha as feha_cobro,c.id_cobro,c.monto,'cobro' "
               . "FROM persona p, cobros c "
               . "WHERE p.id_persona = '$id_persona' "
               . "AND p.id_persona = c.id_persona;";
       $db->query($sql);
       $sql = "SELECT * FROM temporal1 UNION ALL SELECT * FROM temporal2 ORDER BY fecha";
        $result = $db->query($sql);
      if($result){
          return $result;
      }else{
          return false;
      }
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
  
  function verClientes(){
      global $db;
      $sql = "SELECT * FROM persona WHERE persona.rol ='1'";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  
  function verProveedores(){
      global $db;
      $sql = "SELECT * FROM persona WHERE persona.rol ='1'";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  
  function listarSaldos(){
      global $db;
      $sql = "SELECT * FROM `persona` "
              . "WHERE EXISTS (SELECT * FROM factura WHERE factura.id_persona = persona.id_persona)";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  function totalFactura($id_persona){
      global $db;
      $sql = "SELECT SUM(factura.total) as suma_factura "
              . "FROM persona,factura "
              . "WHERE persona.id_persona = '$id_persona'"
              . "AND persona.id_persona = factura.id_persona";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  function totalCobro($id_persona){
      global $db;
      $sql = "SELECT SUM(cobros.monto) as suma_cobro "
              . "FROM persona,cobros "
              . "WHERE persona.id_persona = '$id_persona'"
              . "AND persona.id_persona = cobros.id_persona";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
  }
  
}
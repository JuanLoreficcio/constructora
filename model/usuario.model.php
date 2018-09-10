<?php

class Usuario_Model{
    function nuevoUsuario($name,$password,$rol){
        global $db;
        $sql = "INSERT INTO `usuario`(`id_user`, `name`, `password`, `rol`) ".
             "VALUES (NULL,'$name','$password' ,'$rol');";
        $db->insert($sql,false);         
    }
    
    function modificarUsuario($id_user,$name,$password,$rol){
        global $db;
        $sql = "UPDATE `usuario` SET `name` = '$name', `password` = '$password', `rol` = '$rol' WHERE `usuario`.`id_user` = $id_user;";
        $db->update($sql);
    }
    
    function eliminarUsuario($id_user){
        global $db;
        $sql = "DELETE FROM `usuario` WHERE `persona`.`id_user` = $id_user";
        $db->delete($sql);
    }
    
    function verUsuario(){
      global $db;
      $sql = "SELECT * FROM `usuario` ORDER BY 'name'";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{
          return false;
      } 
    }
    
    function verUsuarioRol($rol){
      global $db;
      $sql = "SELECT * FROM `usuario` WHERE rol='$rol' ORDER BY 'name'";
      $result = $db->query($sql);
      if($result){
          return $result;
      }else{ 
          return false;
      }
    }
}   


?>
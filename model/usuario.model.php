<?php  
class Usuario_Model{
    function nuevoUsuario($name,$password,$rol){
        global $db;
        $sql = "INSERT INTO `usuario`(`id_user`, `name`, `password`, `rol`) ".
             "VALUES (NULL,'$name','$password' ,'$rol');";
        $respuesta =$db->insert($sql,false); 
        return $respuesta;
    }
        
    function modificarUsuario($id_user,$name,$password,$rol){
        global $db;
        $sql = "UPDATE `usuario` SET `name` = '$name', `password` = '$password', `rol` = '$rol' WHERE `usuario`.`id_user` = $id_user;";
        $respuesta = $db->update($sql);
        return $respuesta;        
    }
        
    function eliminarUsuario($id_user){
        global $db;
        $sql = "DELETE FROM `usuario` WHERE `persona`.`id_user` = $id_user";
        $respuesta = $db->delete($sql);
        return $respuesta;
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
    
    function validarUsuario($user,$pass,$rol){
        global $db;
        $sql = "SELECT * FROM `usuario` WHERE `name` = '$user' AND `password` = '$pass' AND `rol` = '$rol'";
        $result = $db->query($sql);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
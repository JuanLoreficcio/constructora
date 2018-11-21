<?php

class Ingreso_Controller {

    var $messages = null;

    function main() {
        $tpl = new TemplatePower("templates/inicioSesion.html");
        $tpl->prepare();
        return $tpl->getOutputContent();
    }

    function iniciarSesion() {
        $userF = strip_tags($_POST["username"]);
        $pass = strip_tags($_POST["password"]);
        $user=strtolower($userF); 
        $var_user = new Usuario_Model();
        $usuario = $var_user->validarUsuario($user, $pass, "admin");
        $fila =  mysqli_num_rows($usuario);
        if ($fila==1) {
            $_SESSION["conect"] = true;
            return header("Location: index.php?action=Factura::verTodasFactura&type=venta");
        } else {
            $_SESSION["conect"] = false;
            return $this->main();
        }
        
    }

}

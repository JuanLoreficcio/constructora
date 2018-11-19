<?php
class Ingreso_Controller {

  var $messages = null;
  function main() {
    $tpl = new TemplatePower("templates/inicioSesion.html");
    $tpl->prepare();
    return $tpl->getOutputContent();
  }  
}

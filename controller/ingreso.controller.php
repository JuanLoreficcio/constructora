<?php
class Ingreso_Controller {

  var $messages = null;


  function main() {
    $tpl = new TemplatePower("recursos/_html/index.html");
    $tpl->prepare();
    /* $tpl->assign("hrefInicio","index.php");
    $tpl->assign("hrefProducto","index.php?action=Producto::verProductos");
    $tpl->assign("hrefPersona","index.php?action=Persona::verPersonas");
    $tpl->assign("hrefFactura","index.php?action=Factura::verTodasFactura");
    */
    return $tpl->getOutputContent();
  }  
}

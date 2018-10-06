<?php
	include("inc.configuration.php");
	include("recursos/_php/class.mysqli.php");
	include("recursos/_php/utils.php");
        include("recursos/_php/class.TemplatePower.inc.php");
        include("recursos/constantes.php");
	
	// Controllers
        include("controller/ingreso.controller.php");
        include("controller/persona.controller.php");
	include("controller/usuario.controller.php");
	include("controller/producto.controller.php");
        include("controller/estado.controller.php");
        include("controller/tipo.controller.php");
        include("controller/cobros.controller.php");
        include("controller/factura.controller.php");
        
    // Models
	include("model/persona.model.php");
        include("model/usuario.model.php");
        include("model/producto.model.php");
        include("model/estado.model.php");
        include("model/tipo.model.php");
        include("model/cobros.model.php");
        include("model/factura.model.php");
        include("model/pedido.model.php");
<?php
	include("inc.configuration.php");

	include("recursos/_php/class.mysqli.php");
	include("recursos/_php/utils.php");
        include("recursos/_php/class.TemplatePower.inc.php");
	
	// Controllers
        include("controller/persona.controller.php");
	include("controller/usuario.controller.php");
	include("controller/producto.controller.php");
        include("controller/estado.controller.php");
        include("controller/tipo.controller.php");
        include("controller/cobros.controller.php");
        
    // Models
	include("model/persona.model.php");
        include("model/usuario.model.php");
        include("model/producto.model.php");
        include("model/estado.model.php");
        include("model/tipo.model.php");
        include("model/cobros.model.php");
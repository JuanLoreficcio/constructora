<?php
	include("inc.configuration.php");

	include("recursos/_php/class.mysqli.php");
	include("recursos/_php/utils.php");
	
	// Controllers
        include("controller/persona.controller.php");
	include("controller/usuario.controller.php");
	include("controller/producto.controller.php");
        include("controller/estado.controller.php");
        // Models
	include("model/persona.model.php");
        include("model/usuario.model.php");
        include("model/producto.model.php");
        include("model/estado.model.php");
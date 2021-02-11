<?php
	require_once("controller/ConfiguracionController.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	require_once("view/TwigView.php");
	require_once("view/Configuracion.php");
	ConfiguracionController::getInstance()->configuracion();
?>
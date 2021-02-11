<?php
	
	require_once("controller/DemograficoController.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	require_once("view/TwigView.php");
	require_once("view/DemograficoModificar.php");
	require_once("view/Pacientes.php");

	DemograficoController::getInstance()->demograficoModificar();
?>
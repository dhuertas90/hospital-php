<?php
	
	require_once("controller/PacienteController.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	require_once("view/TwigView.php");
	require_once("view/PacienteVerMas.php");
	PacienteController::getInstance()->pacienteVerMas();
?>
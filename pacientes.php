<?php

	require_once("controller/PacienteController.php");
	require_once("view/TwigView.php");
	require_once("view/Pacientes.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	PacienteController::getInstance()->pacientes();

?>
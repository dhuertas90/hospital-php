<?php
	
	require_once("controller/DemograficoController.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	require_once("view/TwigView.php");
	require_once("view/DemograficoVerMas.php");
	DemograficoController::getInstance()->demograficoVerMas();
?>
<?php
	require_once("controller/ResourceController.php");
	require_once("model/ModelGeneric.php");
	require_once("model/Model.php");
	require_once("view/TwigView.php");
	require_once("view/Login.php");
	require_once("view/Backend.php");
	
	ResourceController::getInstance()->checkearIniciar();
?>
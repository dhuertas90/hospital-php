<?php

	require_once("controller/UsuarioController.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	require_once("view/TwigView.php");
	require_once("view/UsuarioAgregar.php");
	UsuarioController::getInstance()->usuarioAgregar();
?>
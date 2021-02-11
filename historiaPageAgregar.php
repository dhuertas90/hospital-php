<?php

	require_once("controller/HistoriaController.php");
	require_once("view/TwigView.php");
	require_once("view/HistoriaAgregar.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	HistoriaController::getInstance()->historiaPageAgregar();

?>
<?php

	require_once("controller/ReportesController.php");
	require_once("view/TwigView.php");
	require_once("view/Curvas.php");
	require_once("model/Model.php");
	require_once("model/ModelGeneric.php");
	ReportesController::getInstance()->curvaPpc();
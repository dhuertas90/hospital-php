<?php

require_once('controller/ResourceController.php');
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('model/Model.php');
require_once('model/ModelGeneric.php');

if (isset($_GET["action"]) && $_GET["action"] == 'logout'){
    ResourceController::getInstance()->logout();
}else{
	ResourceController::getInstance()->home();
}

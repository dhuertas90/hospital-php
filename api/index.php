<?php

require '../vendor/autoload.php';
require_once 'ApiModel/Repository.php';
require_once 'ApiController/Controller.php';

// instantiate the App object
$app = new \Slim\App();



$app->get('/turnos/{fecha}', function ($request, $response, $args) {

	$turnos = Controller::getInstance()->getTurnosDisponibles($args['fecha']);

	return $response
		->withHeader('Content-type', 'application/json')
		->getBody()
		->write(
			json_encode($turnos)
		);
});


$app->post('/reservar', function ($request, $response) {
    
	$data	=	$request->getParsedBody();
	$msg	=	Controller::getInstance()->reservar($data);

	return $response
		->withHeader('Content-type', 'application/json')
		->getBody()
		->write(
			json_encode($msg)
		);
});



// Run application
$app->run();

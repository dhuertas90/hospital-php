<?php

require_once 'ApiModel/Repository.php';

class Controller {


	private static $instance;

	public static function getInstance() {

	    if (!isset(self::$instance)) {
	        self::$instance = new self();
	    }

	    return self::$instance;
	}

	private function __construct() {

	}


	public function getTurnosDisponibles($fecha){

		$turnos = Repository::getInstance()->getTurnosDisponibles($fecha);
		
		return $turnos;
	}

	public function reservar($data) {

		$resultado = Repository::getInstance()->reservar($data['fecha'], $data['horario']);

		if ($resultado == 1){
			//Devuelve el mensaje de fracaso de reserva, concatenando los datos enviados por el body.
			$msg = 'No se pudo realizar la reserva para paciente: ' . $data['documento'] . ', fecha: ' . $data['fecha'] . ', horario: '. $data['horario'];
		}else{
			//Devuelve un codigo unico: en este caso un patron "000" y "fff" con el Documento en medio.
			$msg = 'La reserva se realizo exitosamente. Codigo de turno: ' . '000' . $data['documento'] . 'fff';
		}

		return $msg;
	}




}
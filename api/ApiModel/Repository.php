<?php

class Repository {

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
		//Turnos disponibles para las fechas indicadas (fechas estáticas)

		switch ($fecha) {
			case '28-11-2017':
				//todos los turnos disponibles
				return array('8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', 
							'11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', 
							'16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30');

			case '29-11-2017':
				/*
					turnos disponibles: 	8:00 hasta 12:30
				*/
				return array('8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', 
							'11:30', '12:00', '12:30');
			
			case '30-11-2017':
				/*
					turnos disponibles:		13:00 hasta 19:30
				*/
				return array('13:00', '13:30', '14:00', '14:30', '15:00', '15:30', 
							'16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30');
			
			case '01-12-2017':
				/*
					turnos disponibles:		12:00 hasta 14:00
				*/
				return array('12:00', '12:30', '13:00', '13:30', '14:00');
			
			default:
				//no existe turnos para la fecha ingresada
				return array();
		}
	}

	public function reservar($fecha, $hora){
		//Simula una reservacion en un horario sobre una fecha indicada.
		//El horario y fecha deben existir para poder efectivizar la reservacion.

		$turnos_en_fecha = $this->getTurnosDisponibles($fecha);

		//Devuelve "0" en caso de exito, o "1" en caso contrario.
		if (empty($turnos_en_fecha)){
			return 1;
		}
		if (in_array($hora, $turnos_en_fecha)){
			return 0;
		}else{
			return 1;
		}
	}


}
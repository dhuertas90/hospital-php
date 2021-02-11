<?php

require_once("controller/ResourceController.php");

class ConfiguracionController extends ResourceController{
	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }
	
    public function configuracion(){
    	$info_config= Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	if( in_array("administrador", $_SESSION["roles"]) ){
	    	$view = new Configuracion();
	    	$view -> show($_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $info_config, '', $_SESSION["roles"]);
	    }
    }

    public function checkearConfiguracion(){
    	session_start();
    	$this->comprobarSesion();
    	$dato;
    	if (ctype_space($_POST["titulo"]) || ctype_space($_POST["descripcion"]) || ctype_space($_POST["email"]) || ctype_space($_POST["cantidad-pagina"]) || ctype_space($_POST["habilitado"]) || ctype_space($_POST["mensaje"])){
    		$dato="Debe completar todos los campos";
    		$info_config= Model::getInstance()->datosConfiguracion();
	    	$view = new Configuracion();
	    	$view -> show($_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $info_config, $dato, $_SESSION["roles"]);
    	}
    	else{
    		$datos= array('descripcion'=>$_POST["descripcion"], 'titulo'=> $_POST["titulo"], 'mail'=>$_POST["email"], 'cantidad_pagina'=>$_POST["cantidad-pagina"], 'habilitado'=> $_POST["habilitado"], 'mensaje'=>$_POST["mensaje"]);
    		Model::getInstance()->modificarConfiguracion($datos);
    		header("location: ./backend.php");
    	}
    }


}



?>
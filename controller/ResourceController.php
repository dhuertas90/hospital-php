<?php

class ResourceController{
	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }

    public function setSession($usuario, $email, $roles, $permisos){
    	session_start();
    	$_SESSION["nombre_usuario"]=$usuario;
    	$_SESSION["email"]=$email;
		$_SESSION["roles"]=$roles;
		$_SESSION["permisos"]=$permisos;
    }

    public function comprobarSesion(){
    	if(!isset($_SESSION["roles"])){
    		header("Location: login.php");
    	}
    }

    public function perfilUsuario(){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$view = new Backend();
    	$view->show($_SESSION["nombre_usuario"], $info_config['titulo'], $info_config['mail'], $info_config["descripcion_hospital"] , $_SESSION["roles"], $_SESSION["permisos"]);
    }

    public function login(){
    	$info_config=Model::getInstance()->datosConfiguracion();
    	$view = new Login();
    	$view->show($info_config["titulo"], $info_config["mail"], '');
    }


    public function checkearIniciar(){
    	$info_config=Model::getInstance()->datosConfiguracion();
    	$consultarNombreUsuario = Model::getInstance()->existeNombreUsuario($_POST["username"]);
    	$usuario;
    	$msj;
    	if (!$consultarNombreUsuario){
    		$msj= "El nombre de usuario ingresado es incorrecto";
    	}else{
    		$consultarPassword = Model::getInstance()->existePassword($_POST["username"], $_POST["password"]);
    		if (!$consultarPassword){
    			$msj= "La contraseña es incorrecta";
    		}else{
    			$usuario = Model::getInstance()->getUserLogin($_POST["username"], $_POST["password"]);
    			$roles=Model::getInstance()->getRolesUserWithId($usuario["id"]);
    			$permisos=Model::getInstance()->getPermisosUserWithId($usuario["id"]);
    			if($usuario["active"] == 0 || ($info_config["habilitado"]==0 && !in_array("administrador", $roles) )) {
    				$msj= "Usted no puede ingresar al sitio";
    			}else{
    				$msj="correctamente";
    			}
    		}
    	}
    	if ($msj == "correctamente"){
    		$this->setSession($usuario["username"], $usuario["email"], $roles, $permisos);
    		$view = new Backend();
    		$view->show($_SESSION["nombre_usuario"], $info_config['titulo'], $info_config['mail'], $info_config["descripcion_hospital"], $_SESSION["roles"], $permisos);
    	}else{
    		$view= new Login();
    		$view->show($info_config["titulo"], $info_config["mail"], $msj);
    	}
    }

    public function logout(){
	    	session_start();
	    	session_destroy();
			$parametros_cookies = session_get_cookie_params();
			setcookie(session_name(),0,1,$parametros_cookies["path"]);
	    	$this->home();
    }

    public function home(){
    	$info_config=Model::getInstance()->datosConfiguracion();
    	$view = new Home();
    	if ($info_config["habilitado"]==1){
    		$view->show($info_config["titulo"], $info_config["mail"], $info_config["descripcion_hospital"]);
    	}
    	else{
    		$view->showDeshabilitado($info_config["titulo"], $info_config["mail"], $info_config["mensaje"]);
    	}
    }

    public function getArrayUrl($string){
        $url = "https://api-referencias.proyecto2017.linti.unlp.edu.ar/" . $string;
        $object_json = file_get_contents($url);
        $object_array = json_decode($object_json, true);
        return $object_array;
    }

    public function getNombresFromArray($array){
        $arrayNombres = [];
        foreach ($array as $elem) {
            $arrayNombres[] = $elem["nombre"];   
        }
        return $arrayNombres;
    }

    public function dias_transcurridos($fecha_i, $fecha_f){
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias); $dias = floor($dias);     
        return $dias;
    }

    public function semanas($dias){
        return round($dias/7);
    }

}
<?php

require_once("controller/ResourceController.php");

class HistoriaController extends ResourceController{

	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }

    //muestra pagina con las historias clinicas
    public function historiasPaciente($id_paciente=null){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();

    	$view = new Historias();
        $paciente_id;
    	if( (in_array("pediatra", $_SESSION["roles"]) || in_array("administrador", $_SESSION["roles"])) ){
	    	$pagina;
	    	if (!isset($_GET["pagina"])){
	    		$pagina="";
	    	}else{
	    		$pagina=$_GET["pagina"];
	    	}

            if ($id_paciente==null){
	    	  $data=Model::getInstance()->listadoHistoria($_GET["id_paciente"], $pagina, $info_config['cantidad_pagina']);
              $paciente_id=$_GET["id_paciente"];
            }else{
                $data=Model::getInstance()->listadoHistoria($id_paciente, $pagina, $info_config['cantidad_pagina']);
                $paciente_id=$id_paciente;
            }

            $hoy = date("Y-m-d");
            $edad_semanas=$this->edadSemanas($paciente_id, $hoy);

            $msg = 'desabilitar';
            if ($edad_semanas < 14){
                $msg = 'habilitar';
                if($edad_semanas <= 104286){
                    $msg = 'habilitar-tallas';
                }
            }
            if (!isset($_GET['msj'])){
                $error = '';
            }else{
                $error = $_GET['msj'];
            }
	    	if ( count($data) > 0 ){
	    		$view->show($data['items'], $paciente_id, $data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], $msg, $error);
	    	}else{
                header('location: ./pacientes.php');
            }

	    }else{
            header('location: ./pacientes.php');
	    }
    }

    public function edadSemanas($id_paciente, $fechaControl){ 
    //recibe id del paciente(busca su fecha de nac) y calcula la edad (semanas) hasta la fecha pasada por parametro
        $f_nac=Model::getInstance()->getFechaNacimiento($id_paciente);
        $edad_dias=$this->dias_transcurridos($f_nac['fecha_nac'], $fechaControl);
        $edad_semanas=$this->semanas($edad_dias);
        return $edad_semanas;
    }

    //muestra los datos de la historia clinica
    public function historiaVer(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();

        if( in_array("pediatra", $_SESSION["roles"])  && in_array("historia_show", $_SESSION["permisos"]) ){
            $historia = Model::getInstance()->getHistoriaWithId($_GET["id_historia"]);
            $usuario_control=Model::getInstance()->getUsuarioWithId($historia["id_usuario"]);
            $edadSemanas = $this->edadSemanas($_GET['id_paciente'], $historia['fecha']);
            $view = new HistoriaVer();
            $view->show($historia, $edadSemanas, $usuario_control["username"], $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"]);
        }
    }

    //pagina para el alta de historia clinica
    public function historiaPageAgregar(){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();

    	$view= new HistoriaAgregar();
    	$view->show($_GET["id_paciente"], $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], '', $_SESSION["roles"]);
    }

    //realiza el insert de un control a la Historia clinica.
    public function historiaAgregar(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();
        $usuario=Model::getInstance()->getUsuarioWithName($_POST["usuario"]);

        if( in_array("pediatra", $_SESSION["roles"])  && in_array("historia_new", $_SESSION["permisos"]) ){
            $historiaclinica=array('fecha'=>$_POST["fecha"], 'peso'=>$_POST["peso"], 'vacunas'=>$_POST["vacunas"], 'vacunas_obs'=>$_POST["vacunas_obs"], 'maduracion'=>$_POST["maduracion"], 'maduracion_obs'=>$_POST["maduracion_obs"], 'examen_f'=>$_POST["examen_f"], 'examen_f_obs'=>$_POST["examen_f_obs"], 'pc'=>$_POST["pc"], 'ppc'=>$_POST["ppc"], 'talla'=>$_POST["talla"], 'alimentacion'=>$_POST["alimentacion"], 'obs_grales'=>$_POST["obs_grales"], 'id_usuario'=>$usuario["id"], 'id_paciente'=>$_POST["id_paciente"]);
            Model::getInstance()->agregarHistoria($historiaclinica);
            $msj='El control se agrego a la Historia Clinica correctamente';
            header("location: ./historiaVerTodas.php?id_paciente=".$_POST["id_paciente"].'&msj=' . $msj);
        }
        else{
            $msj='NO SE PUDO AGREGAR';
            $view= new HistoriaAgregar();
            $view->show($_POST["paciente"], $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $msj, $_SESSION["roles"]);
        }
    }

    //muestra en pantalla los datos en el form a modificar.
    public function modificarInfoHistoria(){
    	$info_config = Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$historia = Model::getInstance()->getHistoriaWithId($_GET["id_historia"]);
        $usuario_control = Model::getInstance()->getUsuarioWithId($historia['id_usuario']);
    	$view= new HistoriaModificar();
    	$view->show($historia, $usuario_control["username"], $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"],'', $_SESSION["roles"]);
    }


    //realiza el update de un control de la Historia clinica
    public function historiaModificar(){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
        $usuario = Model::getInstance()->getUsuarioWithName($_POST["usuario"]);
        $msj='La operacion se realizo correctamente';
    	if( in_array("pediatra", $_SESSION["roles"])  && in_array("historia_update", $_SESSION["permisos"]) ){
	    		$datosHistoria=array('id'=>$_POST["id_historia"], 'fecha'=>$_POST["fecha"], 'peso'=>$_POST["peso"], 'vacunas'=>$_POST["vacunas"], 'vacunas_obs'=>$_POST["vacunas_obs"], 'maduracion'=>$_POST["maduracion"], 'maduracion_obs'=>$_POST["maduracion_obs"], 'examen_f'=>$_POST["examen_f"], 'examen_f_obs'=>$_POST["examen_f_obs"], 'pc'=>$_POST["pc"], 'ppc'=>$_POST["ppc"], 'talla'=>$_POST["talla"], 'alimentacion'=>$_POST["alimentacion"], 'obs_grales'=>$_POST["obs_grales"], 'id_usuario'=>$usuario["id"], 'id_paciente'=>$_POST["id_paciente"]);
                Model::getInstance()->modificarHistoria($datosHistoria);
                header("location: ./historiaVerTodas.php?id_paciente=" . $_POST["id_paciente"] . '&msj=' . $msj);
    	}
        else{
            $msj = "Ocurrio un error";
            $historia = Model::getInstance()->getHistoriaWithId($_POST["id"]);
            $view = new HistoriaModificar();
            $view->show($historia, $_SESSION["nombre_usuario"], $info_config['titulo'], $info_config['mail'], $msj, $_SESSION["roles"]); 
        }
    }

    public function historiaBorrar(){
        $msj='La operacion no se pudo realizar';
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();
        if( isset($_SESSION["roles"])){

            if( ( in_array("pediatra", $_SESSION["roles"]) || in_array("administrador", $_SESSION["roles"]) )  && in_array("historia_destroy", $_SESSION["permisos"]) ){
                Model::getInstance()->eliminarHistoriaWithId($_GET["id_historia"]);
                $msj='El control se elimino correctamente de la Historia Clinica';
            }
            else{
                $msj='No posee los roles o permisos';
            }
        }
        header("location: ./historiaVerTodas.php?id_paciente=" . $_GET["id_paciente"] . '&msj=' . $msj);
    }




}

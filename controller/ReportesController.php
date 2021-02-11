<?php

require_once("controller/ResourceController.php");

class ReportesController extends ResourceController {
	
	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }

	public function curvaCrecimiento(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();
        $paciente_id = $_GET["id_paciente"];
        
        if( (in_array("pediatra", $_SESSION["roles"]) || in_array("administrador", $_SESSION["roles"])) ){
            $data=Model::getInstance()->getHistorias($paciente_id);
            $nombre_paciente = Model::getInstance()->getNombreWithId($paciente_id);
            if(count($data)>0){
                $pesos=[];
                foreach ($data as $d) {
                    $pesos[]= $d["peso"];
                }
                $view = new Curvas();
                $view->showCrecimiento($pesos, $nombre_paciente['nombre'], $paciente_id, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"]);
            }
            else{
                header("location: ./pacientes.php");
            }
        }
        else{
            header("location: ./pacientes.php");
        }
    }

     public function curvaTalla(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();
        $paciente_id = $_GET["id_paciente"];
        
        if( (in_array("pediatra", $_SESSION["roles"]) || in_array("administrador", $_SESSION["roles"])) ){
            $data=Model::getInstance()->getHistorias($paciente_id);
            $nombre_paciente = Model::getInstance()->getNombreWithId($paciente_id);
            if(count($data)>0){
                $tallas=[];
                foreach ($data as $d) {
                    $tallas[]= $d["talla"];
                }
                $view = new Curvas();
                $view->showTalla($tallas, $nombre_paciente['nombre'], $paciente_id, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"]);
            }
            else{
                header("location: ./pacientes.php");
            }
        }
        else{
            header("location: ./pacientes.php");
        }
    }

     public function curvaPpc(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();
        $paciente_id = $_GET["id_paciente"];
        
        if( (in_array("pediatra", $_SESSION["roles"]) || in_array("administrador", $_SESSION["roles"])) ){
            $data=Model::getInstance()->getHistorias($paciente_id);
            $nombre_paciente = Model::getInstance()->getNombreWithId($paciente_id);
            if(count($data)>0){
                $ppcs=[];
                foreach ($data as $d) {
                    $ppcs[]= $d["ppc"];
                }
                $view = new Curvas();
                $view->showPpc($ppcs, $nombre_paciente["nombre"], $paciente_id, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"]);
            }
            else{
                header("location: ./pacientes.php");
            }
        }
        else{
            header("location: ./pacientes.php");
        }    
    }

}
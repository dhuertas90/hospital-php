<?php

require_once("controller/ResourceController.php");

class DemograficoController extends ResourceController{
	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }


	//VISUALES
    public function demograficoAgregar(){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();

        $tipo_vivienda_array = $this->getArrayUrl("tipo-vivienda");
        $tipo_vivienda_nombres = $this->getNombresFromArray($tipo_vivienda_array);

        $tipo_calefaccion_array = $this->getArrayUrl("tipo-calefaccion");
        $tipo_calefaccion_nombres = $this->getNombresFromArray($tipo_calefaccion_array);

        $tipo_agua_array = $this->getArrayUrl("tipo-agua");
        $tipo_agua_nombres = $this->getNombresFromArray($tipo_agua_array);

    	$view= new DemograficoAgregar();
    	$view->show($_GET["id_paciente"], $_GET["id_demografico"], $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $tipo_vivienda_nombres, $tipo_calefaccion_nombres, $tipo_agua_nombres, $_SESSION["roles"], $_SESSION["permisos"]);
    }

   	public function demograficoVerMas(){
   		$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	if( ( in_array("recepcionista", $_SESSION["roles"]) || in_array("pediatra", $_SESSION["roles"]) ) && in_array("demografico_show", $_SESSION["permisos"]) ){
	    	$paciente = Model::getInstance()->getPacienteWithId($_GET["id_paciente"]);
	    	$datos_demog = Model::getInstance()->getDatosDemograficosPaciente($paciente["id"]);
            if($datos_demog["id_paciente"]==$_GET["id_paciente"]){
                $msj="DATOS DEMOGRAFICOS";
    	    	$view = new DemograficoVerMas();
    	    	$view->show($paciente, $datos_demog, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"], $msj);
            }else{
                header("location: ./pacientes.php");
            }
        }else{
            header("location: ./pacientes.php");
        }
	}

	public function demograficoModificar(){
		$info_config = Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
        $msj='';
    	$paciente = Model::getInstance()->getPacienteWithId($_GET["id_paciente"]);
    	$datos_demog = Model::getInstance()->getDatosDemograficosPaciente($paciente["id"]);

        $tipo_vivienda_array = $this->getArrayUrl("tipo-vivienda");
        $tipo_vivienda_nombres = $this->getNombresFromArray($tipo_vivienda_array);

        $tipo_calefaccion_array = $this->getArrayUrl("tipo-calefaccion");
        $tipo_calefaccion_nombres = $this->getNombresFromArray($tipo_calefaccion_array);

        $tipo_agua_array = $this->getArrayUrl("tipo-agua");
        $tipo_agua_nombres = $this->getNombresFromArray($tipo_agua_array);

        if ( $datos_demog["id_paciente"]==$_GET["id_paciente"] ){ //existe el registro.
        	$view= new DemograficoModificar();
        	$view->show($paciente, $datos_demog, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $tipo_vivienda_nombres, $tipo_calefaccion_nombres, $tipo_agua_nombres, $_SESSION["roles"],  $msj);
	    }
        else{ //no existe, debe cargarlo.
            header("location: ./demograficoAgregar.php?id_paciente=" . $_GET["id_paciente"] . "&id_demografico=" . $paciente["id_demografico"] );
        }
    }

    //FUNCIONALES
	public function demograficoBorrar(){
        $msj='La operacion no se pudo realizar';
        if( isset($_SESSION["roles"])){

            if( in_array("administrador", $_SESSION["roles"])  && in_array("demografico_destroy", $_SESSION["permisos"]) ){
                Model::getInstance()->eliminarDemograficoWithId($_GET["id_demografico"]);
                Model::getInstance()->eliminarDemograficoInPaciente($_GET["id_paciente"]);
                $msj='Los datos demograficos se eliminaron correctamente';
            }
        }
        header("location: ./pacientes.php?msj=" . $msj);
	}

	public function checkearDemograficoAgregar(){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
        $msj='';
    	if (in_array("demografico_new", $_SESSION["permisos"]) && in_array("demografico_update", $_SESSION["permisos"]) ){
    		Model::getInstance()->eliminarDemograficoWithPaciente($_POST["id_paciente"]);
            $datosDemograficos=array('heladera'=>$_POST["heladera"], 'electricidad'=>$_POST["electricidad"], 'mascota'=>$_POST["mascota"], 'tipo_vivienda'=>$_POST["tipo_vivienda"], 'tipo_calefaccion'=>$_POST["tipo_calefaccion"], 'tipo_agua'=>$_POST["tipo_agua"], 'id_demografico'=>$_POST["id_demografico"]);
			Model::getInstance()->agregarDatosDemograficos($datosDemograficos, $_POST["id_paciente"]);
            $msj = "Los datos demograficos se agregaron exitosamente";
			header("location: ./pacientes.php?msj=" . $msj);
    	}
        else{
            header("location: ./demograficoAgregar.php?id_paciente=" . $_POST["id_paciente"] ."&id_demografico=" . $_POST["id_demografico"]);
        }
    }

	public function modificarInfoDemografico(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();
        $msj;
        $datos_demog = Model::getInstance()->getDatosDemograficosPaciente($_POST["id_paciente"]);
        $paciente=Model::getInstance()->getPacienteWithId($_POST["id_paciente"]);
    	if (in_array("demografico_update", $_SESSION["permisos"]) ){ 
            $datosDemograficos=array('heladera'=>$_POST["heladera"], 'electricidad'=>$_POST["electricidad"], 'mascota'=>$_POST["mascota"], 'tipo_vivienda'=>$_POST["tipo_vivienda"], 'tipo_calefaccion'=>$_POST["tipo_calefaccion"], 'tipo_agua'=>$_POST["tipo_agua"], 'id_paciente'=>$_POST["id_paciente"]); 
    		Model::getInstance()->modificarDemografico($datosDemograficos);
            $msj='Los datos demograficos fueron modificados correctamente';
            header("location: ./pacientes.php?msj=" . $msj);
        }else{
            $msj="No se pudo realizar la operacion";
            $view= new DemograficoModificar();
            $view->show($paciente, $datos_demog, $_SESSION["nombre_usuario"], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $msj); 
        }

    }
    
}
?>
<?php

require_once("controller/ResourceController.php");

class PacienteController extends ResourceController{
	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }

    public function graficoDemograficos(){
        $info_config=Model::getInstance()->iniciarDatos();
        $this->comprobarSesion();

        $pagina; //&& in_array("paciente_index", $_SESSION["permisos"])
        if (!isset($_GET["pagina"])){
            $pagina="";
        }else{
            $pagina=$_GET["pagina"];
        }
        //obtengo pacientes
        $data=Model::getInstance()->listadoPacientes($pagina, $info_config['cantidad_pagina']);
        $cant_pacientes = count($data);

        if ($cant_pacientes >0){
            $datos_demog_porcentajes = $this->getCantidadesTipoVivienda($data['items']);
            $view = new Curvas();
            $view->showDemograficos($datos_demog_porcentajes, $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail']);
        }
        else{
            header("location: ./pacientes.php");
        }
    }

    public function getCantidadesTipoVivienda($pacientes){
        //clave: tipo-vivienda => valor: (cantidad)
        $vivienda_cantidades=[];
        $total=0;   //total de pacientes que tienen los datos demograficos cargados en el sistema. Los que no tienen, no se los cuenta.
        $tipo_madera=0;
        $tipo_material=0;
        $tipo_chapa=0;

        foreach ($pacientes as $paciente) {
            $datos_demog    =   Model::getInstance()->getDatosDemograficosPaciente($paciente['id']);
            if( !($datos_demog==null) || !($datos_demog=='') ){
                $tipo_vivienda  =   $datos_demog["tipo_vivienda"];
                if ( !($tipo_vivienda == '') ){
                    if ($tipo_vivienda == 'Madera'){
                        $tipo_madera++;
                    }
                    if ($tipo_vivienda == 'Material'){
                        $tipo_material++;
                    }
                    if ($tipo_vivienda == 'Chapa'){
                        $tipo_chapa++;
                    }
                    if($tipo_vivienda == 'Madera' || $tipo_vivienda == 'Material' || $tipo_vivienda == 'Chapa'){
                        $total++;
                    }
                }
            }
        }

        $vivienda_cantidades[]=array('nombre'=>'Madera', 'cantidad'=>$tipo_madera);
        $vivienda_cantidades[]=array('nombre'=>'Material', 'cantidad'=>$tipo_material);
        $vivienda_cantidades[]=array('nombre'=>'Chapa', 'cantidad'=>$tipo_chapa);

        return $vivienda_cantidades;
    }

    public function pacientes(){
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$view = new Pacientes();
    	if( ( in_array("pediatra", $_SESSION["roles"]) || in_array("recepcionista", $_SESSION["roles"]) || in_array("historia_destroy", $_SESSION["permisos"]) ) ){
	    	$pagina; //&& in_array("paciente_index", $_SESSION["permisos"])
	    	if (!isset($_GET["pagina"])){
	    		$pagina="";
	    	}else{
	    		$pagina=$_GET["pagina"];
	    	}

	    	$data=Model::getInstance()->listadoPacientes($pagina, $info_config['cantidad_pagina']);
            $cant_pacientes = count($data);

	    	if ($cant_pacientes >0){
                if (!isset($_GET['msj'])){
                    $msj = '';
                }else{
                    $msj = $_GET['msj'];
                }
	    		$view->show($data['items'], $data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], $msj);
	    	}else{
	    		header('location: backend.php');
	    	}
	    }else{
	    	header('location: backend.php');
	    }
    }

    public function pacienteAgregar(){ //comprobacion y redireccionamiento a la pagina con el formulario a completar.
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();

        $tipo_documento_array = $this->getArrayUrl("tipo-documento");
        $tipo_documento_nombres = $this->getNombresFromArray($tipo_documento_array);

        $obra_social_array = $this->getArrayUrl("obra-social");
        $obra_social_nombres = $this->getNombresFromArray($obra_social_array);

        $view= new PacienteAgregar();
    	$view->show($_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $tipo_documento_nombres, $obra_social_nombres, $_SESSION["roles"]);
    }

    public function checkearPacienteAgregar(){ //realiza el new de paciente.
    	$dato=$this->validarPaciente();
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	if ( $dato == "El paciente ya se encuentra registrado" && in_array("paciente_new", $_SESSION["permisos"]) ){
    		//agrego paciente (id_demografico vacio)
    		$datosPaciente=array('apellido'=>$_POST["apellido"], 'nombre'=>$_POST["nombre"], 'fecha_nac'=>$_POST["fecha_nac"], 'genero'=>$_POST["genero"], 'tipo_doc'=>$_POST["tipo_doc"], 'numero_doc'=>$_POST["numero_doc"], 'domicilio'=>$_POST["domicilio"], 'telcel'=>$_POST["telcel"], 'obra_social'=>$_POST["obra_social"], 'id_demografico'=>null);
			Model::getInstance()->agregarPaciente($datosPaciente);
			//obtengo el id del paciente agregado- ir a MODEL
			$id_ultimo=Model::getInstance()->idPacienteUltimo($datosPaciente);
			//creo arreglo vacio para insertar el id_paciente, luego necesito para busqueda.
			$datosDemograficos=array('heladera'=>'', 'electricidad'=>'', 'mascota'=>'', 'tipo_vivienda'=>'', 'tipo_calefaccion'=>'', 'tipo_agua'=>'', 'id_paciente'=>$id_ultimo); 
			Model::getInstance()->generarDatosDemograficos($datosDemograficos, $id_ultimo);
			//obtengo el id de la fila, a partir de id_paciente.
			$id_demografico=Model::getInstance()->getIdDemograficosWithPaciente($id_ultimo);
    		//agregar el id_demografico a la columna del paciente id_ultimo
    		Model::getInstance()->agregarIdDemografico($id_ultimo, $id_demografico);
            $msj    =   'El paciente se agrego correctamente'; 
            header("location: ./pacientes.php?msj=".$msj);
    	}
        else{
        	header("location: ./pacienteAgregar.php");
        }
    }

    public function validarPaciente(){
    	$dato;
    	$consultarExistenciaPaciente = Model::getInstance()->existePaciente($_POST["nombre"], $_POST["apellido"], $_POST["tipo_doc"], $_POST["numero_doc"]);
    	if ($consultarExistenciaPaciente>0){
    		$dato= "El paciente ya se encuentra registrado";
    	}else{
    		$dato="Hubo un error en la modificacion";
    	}
    	return $dato;
    }

    public function pacienteVerMas(){ //muestra en pantalla los datos.
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	if( ( in_array("recepcionista", $_SESSION["roles"]) || in_array("pediatra", $_SESSION["roles"]) ) && in_array("paciente_show", $_SESSION["permisos"]) ){
	    	$paciente = Model::getInstance()->getPacienteWithId($_GET["id"]);
	    	$datosDemograficos = Model::getInstance()->getDatosDemograficosPaciente($paciente["id"]);
	    	$view = new PacienteVerMas(); //revisar
	    	$view->show($paciente, $datosDemograficos, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"]);
	    }
    }

    public function pacienteModificar(){ //muestra en pantalla los datos con form a modificar.
    	$info_config = Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$paciente = Model::getInstance()->getPacienteWithId($_GET["id"]);

        $tipo_documento_array = $this->getArrayUrl("tipo-documento");
        $tipo_documento_nombres = $this->getNombresFromArray($tipo_documento_array);

        $obra_social_array = $this->getArrayUrl("obra-social");
        $obra_social_nombres = $this->getNombresFromArray($obra_social_array);
    	
        $view= new PacienteModificar();
    	$view->show($paciente, $tipo_documento_nombres, $obra_social_nombres, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"],'');
    }

    public function modificarInfoPaciente(){ //realiza el update del paciente
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
        $paciente = Model::getInstance()->getPacienteWithId($_POST["id"]);
    	if( ( in_array("recepcionista", $_SESSION["roles"]) || in_array("pediatra", $_SESSION["roles"]) ) && in_array("paciente_update", $_SESSION["permisos"]) ){
    		$dato=$this->validarPaciente();
	    	if ( ($dato =="El paciente ya se encuentra registrado") ) {
	    		$datosPaciente=array('nombre'=>$_POST["nombre"],'apellido' => $_POST['apellido'], 'fecha_nac'=>$_POST["fecha_nac"], 'genero'=> $_POST["genero"], 'tipo_doc' => $_POST['tipo_doc'],'numero_doc' => $_POST['numero_doc'], 'domicilio'=>$_POST["domicilio"], 'telcel'=>$_POST["telcel"], 'obra_social'=>$_POST["obra_social"], 'id'=> $_POST["id"]);
                Model::getInstance()->modificarPaciente($datosPaciente);

	    		$msj    =   'El paciente se modifico correctamente'; 
               
                header("location: ./pacientes.php?msj=".$msj);
            }
            else{
                header("location: ./pacienteModificar.php?id=".$_POST["id"]);
            }
        }
        else{ 
            header("location: ./pacienteModificar.php?id=".$_POST["id"]);
        }
    }

    public function pacienteBorrar(){
        $info_config=Model::getInstance()->iniciarDatos();
        $msj='La operacion no se pudo realizar';
        if( isset($_SESSION["roles"])){

            if( in_array("administrador", $_SESSION["roles"])  && in_array("paciente_destroy", $_SESSION["permisos"]) ){
                Model::getInstance()->eliminarPacienteWithId($_GET["id"]);
                Model::getInstance()->eliminarDemograficoWithId($_GET["id_demografico"]);
                $msj='El paciente se elimino correctamente';
            }
            else{
                $msj='No posee los permisos necesarios';
            }
        }
        header("location: ./pacientes.php?msj=" . $msj);
    }

    public function pacienteBuscarByNombreApellido(){
    	$info_config=Model::getInstance()->iniciarDatos();
	    $this->comprobarSesion();
	   	$pagina;
    	if (!isset($_GET["pagina"])){
		    	$pagina="";
		}else{
		  	$pagina=$_GET["pagina"];
		}
		$data=Model::getInstance()->listadoPacientesByNyA($_POST["nombre_paciente"], $_POST["apellido_paciente"], $pagina, $info_config['cantidad_pagina']);

        $cant_pacientes =   count($data);

        $view = new Pacientes();
		if ($cant_pacientes > 0){
	    		$view->show($data['items'],$data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], '');
	    }else{
	    	$view->show([], 0, 0, $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], '');
	    }
	}

	public function pacienteBuscarByTipoNumero(){
    	$info_config=Model::getInstance()->iniciarDatos();
	    $this->comprobarSesion();
	   	$pagina;
    	if (!isset($_GET["pagina"])){
		    	$pagina="";
		}else{
		  	$pagina=$_GET["pagina"];
		}
		$data=Model::getInstance()->listadoPacientesByTyN($_POST["tipo_doc"], $_POST["numero_doc"], $pagina, $info_config['cantidad_pagina']);

        $cant_pacientes =   count($data);
		
        $view = new Pacientes();
		if ($cant_pacientes > 0){
	    	$view->show($data['items'], $data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], '');
	    }else{
	    	$view->show([], 0, 0, $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], '');
	    }
	}
    
}
?>
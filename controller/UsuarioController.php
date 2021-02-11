<?php

require_once("controller/ResourceController.php");

class UsuarioController extends ResourceController{
	private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }


    public function usuarios(){ //muestra en pantalla listado de los usuarios (necesita permiso: usuario_show)
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	if( in_array("administrador", $_SESSION["roles"]) && in_array("usuario_index", $_SESSION["permisos"]) ){ //linea permiso en array
	    	$pagina;
	    	if (!isset($_GET["pagina"])){
	    		$pagina="";
	    	}else{
	    		$pagina=$_GET["pagina"];
	    	}
	    	$data=Model::getInstance()->listadoUsuarios($pagina, $info_config['cantidad_pagina']);
	    	
            if (isset($_GET['msj'])){
                $msj = $_GET['msj'];
            }else{
                $msj = '';
            }
            $view = new Usuarios();
            if (count($data) > 0){
                $view->show($data['items'], $data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], $msj);
            }else{
                $view->show([], 0, 0, $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"], $msj);
            }
	    }
    }

	public function usuarioAgregar(){ //MUESTRA EL FORMULARIO PARA NEW
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$roles=Model::getInstance()->getRoles();
    	$view= new UsuarioAgregar();
    	$view->show($roles, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], '', $_SESSION["roles"]);
    }

    public function checkearUsuarioAgregar(){ //REALIZA EL NEW USUARIO
    	$dato=$this->validar();
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
        $msj = '';
    	if ($dato == "correctamente" && in_array("usuario_new", $_SESSION["permisos"]) ){ //linea permiso en array
    		$hoy=(new DateTime())->format('Y-m-d');
    		$datosUsuario=array('usuario' => $_POST["nombre_usuario"], 'clave'=> $_POST["password"], 'nombre'=> $_POST["nombre"], 'apellido'=> $_POST["apellido"], 'email'=> $_POST["email"], 'created_at'=> $hoy, 'updated_at'=> $hoy, 'habilitado'=>$_POST["habilitado"]);
			Model::getInstance()->agregarUsuario($datosUsuario);
			$id_ultimo=Model::getInstance()->idUsuarioUltimo($datosUsuario); //faltan condicion de existencia en formulario
			Model::getInstance()->asignarRolesUsuario($id_ultimo, $_POST["roles_group"]);
            //le asigno los permisos segun su/s rol/es
            Model::getInstance()->generarPermisosUsuario($id_ultimo, $_POST["roles_group"]);
            $msj = 'El usuario fue agregado correctamente';
            header("location: ./usuarios.php?msj=" . $msj);
    	}
        else{
            header("location: ./usuarioAgregar.php");
        }
    }

    public function validar(){
    	$dato;
    	if ( !isset($_POST['roles_group']) || ctype_space ($_POST["nombre_usuario"]) || ctype_space($_POST["nombre"]) || ctype_space($_POST["apellido"]) || ctype_space($_POST["email"])  || ctype_space($_POST["password"]) || ctype_space($_POST["password_repeat"])){
    		$dato= "Debe completar todos los campos";
    	}else{
    		if ( $_POST["password"] != $_POST["password_repeat"]){
    			$dato = "No coinciden las contraseñas";
    		}else{
    			$consultarNombreUsuario = Model::getInstance()->existeNombreUsuario($_POST["nombre_usuario"]);
    			if ($consultarNombreUsuario>0){
    				$dato= "El nombre de usuario ya existe registrado";
    			}else{
    				$dato="correctamente";
    			}
    		}
    	}
    	return $dato;
    }

    public function usuarioVerMas(){ //muestra pantalla con los datos de un usuario.
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	if( in_array("administrador", $_SESSION["roles"]) && in_array("usuario_show", $_SESSION["permisos"]) ){
	    	$usuario = Model::getInstance()->getUsuarioWithId($_GET["id"]);
	    	$roles=Model::getInstance()->getRolesUserWithId($usuario["id"]);
	    	$permisos=Model::getInstance()->getPermisosUserWithId($usuario["id"]); //linea obtener permisos
	    	$view = new UsuarioVerMas();
	    	$view->show($usuario, $roles, $permisos, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], $_SESSION["roles"]);
	    }
    }

    public function usuarioModificar(){ //muestra pantalla con los datos de un usuario para modificarlos.
    	$info_config = Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$usuario = Model::getInstance()->getUsuarioWithId($_GET["id"]);
    	$roles_todos=Model::getInstance()->getRoles();
    	$roles_usuario=Model::getInstance()->getRolesUserWithId($usuario["id"]);
    	$permisos=Model::getInstance()->getPermisos(); //todos los permisos
    	$view= new UsuarioModificar();
    	$view->show($usuario, $roles_todos, $permisos, $_SESSION["nombre_usuario"], $info_config["titulo"], $info_config["mail"], ' ', $_SESSION["roles"], $roles_usuario);
    }

    public function modificarInfoUsuario(){ //realiza el update del usuario
    	$info_config=Model::getInstance()->iniciarDatos();
    	$this->comprobarSesion();
    	$ok=false;
        $dato;
    	if (in_array("usuario_update", $_SESSION["permisos"])){
	    	if ( !ctype_space ($_POST["nombre_usuario"]) ){
	    		$hoy=(new DateTime())->format('Y-m-d');
	    		$datosUsuario=array( 'usuario'=> $_POST["nombre_usuario"], 'clave'=>$_POST["password"], 'nombre'=>$_POST["nombre"], 'apellido'=>$_POST["apellido"], 'email'=>$_POST["email"], 'created_at'=>$_POST["created_at"],  'updated_at'=> $hoy, 'habilitado'=>$_POST["habilitado"], 'id'=> $_POST["id"]);
	    		Model::getInstance()->modificarUsuario($datosUsuario);
	    		Model::getInstance()->asignarRolesUsuario($_POST["id"], $_POST["roles_group"]);
                Model::getInstance()->generarPermisosUsuario($_POST["id"], $_POST["roles_group"]); //genera los permisos segun su/s rol/es
	    		$msj = 'El usuario se modifico correctamente';
                
                header("location: ./usuarios.php?msj=" . $msj);
	    	}
	    }
        else{
            header("location: ./usuarioModificar.php?id=".$_POST["id"]);
        }
    }

    public function usuarioBorrar(){ //realiza el destroy del usuario

        $info_config=Model::getInstance()->iniciarDatos();
        $msj='La operacion no se pudo realizar';
        if( isset($_SESSION["roles"])){

            if( in_array("administrador", $_SESSION["roles"])  && in_array("usuario_destroy", $_SESSION["permisos"]) ){
                Model::getInstance()->eliminarUsuarioWithId($_GET["id"]);
                Model::getInstance()->eliminarRolesUsuarioWithId($_GET["id"]);
                Model::getInstance()->eliminarPermisosUsuarioWithId($_GET["id"]); //eliminar permisos de un usuario
                $msj='El usuario se elimino correctamente';
            }
            else{
                $msj='No posee los permisos necesarios';
            }
        }
        header("location: ./usuarios.php?msj=" . $msj);
    }

    public function usuarioBuscarByUsername(){
    	$info_config=Model::getInstance()->iniciarDatos();
	    $this->comprobarSesion();
	    if(in_array("administrador", $_SESSION["roles"]) ){
		   	$pagina;
	    	if (!isset($_GET["pagina"])){
			    	$pagina="";
			}else{
			  	$pagina=$_GET["pagina"];
			}
			$data=Model::getInstance()->listadoUsuariosByUsername($_POST["nombre_usuario"], $pagina, $info_config['cantidad_pagina']);
			$view = new Usuarios();
			if (count($data) > 0){
		    		$view->show($data['items'], $data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"]);
		    }else{
		    	$view->show([], 0, 0, $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"] );
		    }
		}
	}
	public function usuarioBuscarByEstado(){
    	$info_config=Model::getInstance()->iniciarDatos();
	    $this->comprobarSesion();
	    if(in_array("administrador", $_SESSION["roles"]) ){
		   	$pagina;
	    	if (!isset($_GET["pagina"])){
			    	$pagina="";
			}else{
			  	$pagina=$_GET["pagina"];
			}
			$data=Model::getInstance()->listadoUsuariosByEstado($_POST["estado"], $pagina, $info_config['cantidad_pagina']);
			$view = new Usuarios();
			if (count($data) > 0){
		    		$view->show($data['items'], $data['totalPaginas'], $data['paginaActual'], $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"]);
		    }else{
		    	$view->show([], 0, 0, $_SESSION['nombre_usuario'], $info_config['titulo'], $info_config['mail'], $_SESSION["roles"], $_SESSION["permisos"] );
		    }
		}
	}

}
?>
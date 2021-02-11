<?php
	
/**
 * Description of Backend
 *
 * @author huertas-sosa
 */

	class Backend extends TwigView{

		public function show($nombre_usuario, $titulo, $email, $descripcion, $roles, $permisos){
			echo self::getTwig()->render("backendGeneral.html.twig", array('nombre_usuario'=>$nombre_usuario, 'titulo'=>$titulo, 'email'=>$email, 'descripcion'=>$descripcion, 'roles'=>$roles, 'permisos'=>$permisos));
		}
	}
?>
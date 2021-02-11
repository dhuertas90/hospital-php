<?php

	class UsuarioModificar extends TwigView{
		public function show($datos_usuario, $roles_usuario, $permisos, $usuario, $titulo, $email, $error, $roles, $roles_usuario){
			echo self::getTwig()->render('modificarInfoUsuario.html.twig', array('datos'=>$datos_usuario, 'usuario'=>$usuario , 'titulo'=>$titulo, 'email'=>$email, 'error'=>$error, 'roles'=>$roles, 'roles_usuario'=>$roles_usuario, 'permisos'=>$permisos));
		}
		
	}
?>
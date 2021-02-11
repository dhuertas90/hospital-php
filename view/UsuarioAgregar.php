<?php

	class UsuarioAgregar extends TwigView{

		public function show($usuario_roles, $usuario, $titulo, $email, $error, $roles){
			echo self::getTwig()->render('usuarioAgregar.html.twig', array('roles'=>$usuario_roles, 'usuario'=>$usuario, 'titulo'=> $titulo, 'email'=>$email, 'error'=>"", 'error'=>$error, 'roles'=>$roles));
		}
	}
?>
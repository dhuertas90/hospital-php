<?php

	class Configuracion extends TwigView{
		public function show($usuario, $titulo, $email,  $info_config, $error, $roles){
			echo self::getTwig()->render('configuracion.html.twig', array('nombre_usuario'=>$usuario, 'titulo'=>$titulo, 'email'=>$email, 'info_config'=>$info_config, 'error'=>$error, 'roles'=>$roles));
		}
	}
?>
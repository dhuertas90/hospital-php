<?php
	
	class UsuarioVerMas extends TwigView{

		public function show($datos_usuario, $usuario_roles, $usuario_permisos, $nombre_usuario, $titulo, $email, $roles){
			echo self::getTwig()->render('usuarioVerMas.html.twig', array('datos_usuario'=>$datos_usuario, 'usuario_roles'=>$usuario_roles, 'usuario_permisos'=>$usuario_permisos, 'usuario'=>$nombre_usuario, 'titulo' => $titulo, 'email'=>$email, 'roles'=>$roles));
		}
	}
?>
<?php
	
	class Usuarios extends TwigView{

		public function show($usuarios, $totalPaginas, $paginaActual, $usuario, $titulo, $email, $roles, $permisos, $msj){
			echo self::getTwig()->render('usuarios.html.twig', array('usuarios'=>$usuarios, 'totalPaginas'=>$totalPaginas, 
				'paginaActual'=>$paginaActual, 'nombre_usuario'=>$usuario, 'titulo'=>$titulo, 'email'=>$email, 
				'roles'=>$roles, 'permisos'=>$permisos, 'error'=>$msj));
		}
	}
?>
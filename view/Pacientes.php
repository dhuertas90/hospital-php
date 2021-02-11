<?php
	
	class Pacientes extends TwigView{

		public function show($pacientes, $totalPaginas, $paginaActual, $usuario, $titulo, $email, $roles, $permisos, $msj){
			echo self::getTwig()->render('pacientes.html.twig', array('pacientes'=>$pacientes, 'totalPaginas'=>$totalPaginas, 
				'paginaActual'=>$paginaActual, 'nombre_usuario'=>$usuario, 'titulo'=>$titulo, 'email'=>$email, 'roles'=>$roles, 
				'permisos'=>$permisos, 'msj'=>$msj));
		}
	}
?>
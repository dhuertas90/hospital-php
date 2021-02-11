<?php
	
	class Historias extends TwigView{

		public function show($historias, $paciente_id, $totalPaginas, $paginaActual, $usuario, $titulo, $email, $roles, $permisos, $msg, $error){
			echo self::getTwig()->render('historias.html.twig', array('historias'=>$historias, 'paciente_id'=>$paciente_id, 
				'totalPaginas'=>$totalPaginas, 'paginaActual'=>$paginaActual, 'nombre_usuario'=>$usuario, 'titulo'=>$titulo, 
				'email'=>$email, 'roles'=>$roles, 'permisos'=>$permisos, 'msg'=>$msg, 'msj'=>$error));
		}
	}
?>
<?php

	class HistoriaAgregar extends TwigView{

		public function show($paciente, $usuario, $titulo, $email, $error, $roles){
			echo self::getTwig()->render('historiaAgregar.html.twig', array('paciente'=>$paciente, 'usuario'=>$usuario, 'titulo'=> $titulo, 'email'=>$email, 'error'=>$error, 'roles'=>$roles));
		}
	}
?>
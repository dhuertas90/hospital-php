<?php

	class HistoriaModificar extends TwigView{

		public function show($historia, $usuario_control, $usuario, $titulo, $email, $error, $roles){
			echo self::getTwig()->render('modificarInfoHistoria.html.twig', array('historia'=>$historia, 'usuario_control'=>$usuario_control, 'usuario'=>$usuario, 'titulo'=> $titulo, 'email'=>$email, 'error'=>$error, 'roles'=>$roles));
		}
	}
?>
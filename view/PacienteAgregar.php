<?php

	class PacienteAgregar extends TwigView{

		public function show($usuario, $titulo, $email, $tipo_doc_nombres, $obra_social_nombres, $roles){
			echo self::getTwig()->render('pacienteAgregar.html.twig', array('usuario'=>$usuario, 'titulo'=> $titulo, 'email'=>$email, 'tipo_doc_nombres'=>$tipo_doc_nombres, 'obra_social_nombres'=>$obra_social_nombres, 'roles'=>$roles));
		}
	}
?>
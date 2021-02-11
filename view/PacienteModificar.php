<?php

	class PacienteModificar extends TwigView{
		public function show($datos_paciente, $tipo_doc_nombres, $obra_social_nombres, $usuario, $titulo, $email, $roles, $error){
			echo self::getTwig()->render('modificarInfoPaciente.html.twig', array('datos'=>$datos_paciente, 'tipo_doc_nombres'=>$tipo_doc_nombres, 'obra_social_nombres'=>$obra_social_nombres, 'usuario'=>$usuario , 'roles'=>$roles, 'titulo'=>$titulo, 'email'=>$email, 'error'=>$error));
		}	
	}
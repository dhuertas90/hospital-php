<?php
	
	class PacienteVerMas extends TwigView{

		public function show($datos_paciente, $datos_demograficos,  $usuario, $titulo, $email, $roles){
			echo self::getTwig()->render('pacienteVerMas.html.twig', array('datos_paciente'=>$datos_paciente, 'datos_demograficos'=>$datos_demograficos, 'usuario'=>$usuario , 'titulo' => $titulo, 'email'=>$email, 'roles'=>$roles));
		}
	}
?>
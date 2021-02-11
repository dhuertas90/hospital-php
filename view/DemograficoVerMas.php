<?php
	
	class DemograficoVerMas extends TwigView{

		public function show($datos_paciente, $datos_demograficos,  $usuario, $titulo, $email, $roles, $error){
			echo self::getTwig()->render('datosDemograficoVerMas.html.twig', array('datos_paciente'=>$datos_paciente, 'datos_demograficos'=>$datos_demograficos, 'usuario'=>$usuario , 'titulo' => $titulo, 'email'=>$email, 'roles'=>$roles, 'error'=>$error));
		}
	}
?>
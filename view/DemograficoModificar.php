<?php

	class DemograficoModificar extends TwigView{
		public function show($paciente, $datos_demog, $usuario, $titulo, $email, $t_vivienda, $t_calefaccion, $t_agua, $roles, $error){
			echo self::getTwig()->render('modificarDatosDemograficos.html.twig', array( 'paciente'=>$paciente, 'datos'=>$datos_demog, 'usuario'=>$usuario , 'tipo_calefaccion'=>$t_calefaccion, 'tipo_vivienda'=>$t_vivienda, 'tipo_agua'=>$t_agua, 'roles'=>$roles, 'titulo'=>$titulo, 'email'=>$email, 'error'=>$error));
		}	
	}
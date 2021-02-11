<?php

	class DemograficoAgregar extends TwigView{

		public function show($id_paciente, $id_demografico, $usuario, $titulo, $email, $t_vivienda, $t_calefaccion, $t_agua, $roles, $permisos){
			echo self::getTwig()->render('datosDemograficosAgregar.html.twig', array('paciente'=>$id_paciente, 'demografico'=>$id_demografico, 'usuario'=>$usuario, 'titulo'=> $titulo, 'email'=>$email, 'tipo_calefaccion'=>$t_calefaccion, 'tipo_vivienda'=>$t_vivienda, 'tipo_agua'=>$t_agua, 'roles'=>$roles, 'permisos'=>$permisos));
		}
	}
?>
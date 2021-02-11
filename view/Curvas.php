<?php
	
	class Curvas extends TwigView{

		public function showCrecimiento($data, $paciente, $id_paciente, $usuario, $titulo, $mail){
			echo self::getTwig()->render('curvaCrecimiento.html.twig', array('pesos'=>$data, 'paciente'=>$paciente, 'id_paciente'=>$id_paciente, 'email'=>$mail));
		}

		public function showTalla($data, $paciente, $id_paciente, $usuario, $titulo, $mail){
			echo self::getTwig()->render('curvaTalla.html.twig', array('tallas'=>$data, 'paciente'=>$paciente, 'id_paciente'=>$id_paciente, 'email'=>$mail));
		}

		public function showPpc($data, $paciente, $id_paciente, $usuario, $titulo, $mail){
			echo self::getTwig()->render('curvaPpc.html.twig', array('ppcs'=>$data, 'paciente'=>$paciente, 'id_paciente'=>$id_paciente, 'email'=>$mail));
		}

		public function showDemograficos($viviendas_porcentajes, $usuario, $titulo, $mail){
			echo self::getTwig()->render('graficoDemograficos.html.twig', array('viviendas_porcentajes'=>$viviendas_porcentajes, 'usuario'=>$usuario, 'titulo'=>$titulo, 'email'=>$mail) );
		}

	}
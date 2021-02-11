<?php
	
	class HistoriaVer extends TwigView{
		public function show($historia, $edad, $usuario_control, $usuario, $titulo, $email, $roles){
			echo self::getTwig()->render('historiaVer.html.twig', array('historia'=>$historia, 'edad'=>$edad, 'usuario_control'=>$usuario_control, 'nombre_usuario'=>$usuario, 'titulo'=>$titulo, 'email'=>$email, 'roles'=>$roles) );
		}
	}
?>
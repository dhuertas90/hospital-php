<?php

/**
 * Description of Home
 *
 * @author huertas-sosa
 */


class Home extends TwigView {
    
    public function show($titulo, $email, $descripcion) {
        
        echo self::getTwig()->render("home.html.twig", array('titulo'=>$titulo, 'email'=>$email, 'descripcion'=>$descripcion));
       // echo self::getTwig()->render('backendGeneral.html.twig', []);
    }
    
    public function showDeshabilitado($titulo, $email, $mensaje){
			echo self::getTwig()->render('homeDeshabilitado.html.twig', array('titulo'=>$titulo, 'email'=>$email, 'mensaje'=>$mensaje));
	}
}
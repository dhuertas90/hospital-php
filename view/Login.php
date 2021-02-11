<?php

/**
 * Description of Login
 *
 * @author huertas-sosa
 */

class Login extends TwigView {
    
    public function show($titulo, $email, $error) {
        
        echo self::getTwig()->render('login.html.twig', array('titulo'=>$titulo, 'email'=>$email, 'error'=>$error));
       
        
    }
    
}
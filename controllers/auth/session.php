<?php

class Session{

    private $sessionName = 'user';

    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE){// Si no hay una sesión iniciada, la inicia
            session_start();
        }
    }

    //Sirve para verificar si existe la sesion
    public function exists() {
        return isset($_SESSION[$this->sessionName]);
    } 

    
}
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

    public function closeSession(){
        session_start();
        session_destroy();
    }

    //Sirve para establecer el usuario actual
    public function setCurrentUser($user){ //Set = establecer; Current = actual;  User = usuario 
        $_SESSION[$this->sessionName] = $user;
    }

    public function getCurrentUser(){ //Sirve para obtener el usuario actual
        return $_SESSION[$this->sessionName] ?? null;
    }
    
}
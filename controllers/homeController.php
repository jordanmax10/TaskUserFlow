<?php
require_once __DIR__ . '/../libs/controller.php';

class HomeController extends Controller {


    public function login() {
        require_once __DIR__.'/../views/auth/login.php';
    }
}
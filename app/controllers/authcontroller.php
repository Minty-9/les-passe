<?php
class AuthController {
    public function login() {
        require_once 'views/auth/login.php';
    }
    public function register() {
        require_once 'views/auth/register.php';
    }
    public function logout() {
        logout_user();
        redirect(APP_URL . '/auth/login');
    }
}
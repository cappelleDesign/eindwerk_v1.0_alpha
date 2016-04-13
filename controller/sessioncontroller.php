<?php

class SessionController {

    private function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_name('neoludus_service');
            session_set_cookie_params(0);
            session_start();
        }
    }

    public function checkUserActivity() {
        $this->startSession();
        session_write_close();
        return isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800);
        // request 30 minates ago
    }

    public function updateUserActivity() {
        $this->startSession();
        $_SESSION['LAST_ACTIVITY'] = time();
        session_write_close();
    }

    public function isLoggedOn() {
        $this->startSession();
        session_write_close();
        return isset($_SESSION['current_user']);
    }

    public function setSessionAttr($key, $val) {
        $this->startSession();
        $_SESSION[$key] = $val;
        session_write_close();
    }

    public function getSessionAttr($key) {
        $this->startSession();
        session_write_close();
        return $_SESSION[$key];
    }

}

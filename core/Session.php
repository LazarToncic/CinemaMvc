<?php

namespace app\core;

class Session
{
    public string $USER_SESSION = "USER";
    public string $ROLE_SESSION = "ROLE";
    public string $CART_SESSION = "CART";
    public string $FLASH_MESSAGE_SESSION = "FLASH_MESSAGE";
    public string $FLASH_MESSAGE_ERROR = "FLASH_MESSAGE_ERROR";
    public string $FLASH_MESSAGE_SUCCESS = "FLASH_MESSAGE_SUCCESS";

    public function __construct() {
        session_start();

        $flashMessages = $_SESSION[$this->FLASH_MESSAGE_SESSION] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage["remove"] = true;
            unset($flashMessages[$key]);
        }

        $_SESSION[$this->FLASH_MESSAGE_SESSION] = $flashMessages;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function setFlash($key, $message) {
        $_SESSION[$this->FLASH_MESSAGE_SESSION][$key] = [
            "remove" => false,
            "value" => $message
        ];
    }

    public function getFlash($key) {
        return $_SESSION[$this->FLASH_MESSAGE_SESSION][$key]["value"] ?? false;
    }


}
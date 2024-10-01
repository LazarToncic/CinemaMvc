<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\LoginModel;
use app\models\RegistrationModel;

class AuthController extends Controller
{

    public function login() {
        if (Application::$app->session->get(Application::$app->session->USER_SESSION) !== false) {
            header("location:" . "/home");
        }
        $this->view("login", "auth", null);
    }

    public function loginProcess() {
        $loginModel = new LoginModel();
        $loginModel->mapData($this->router->request->all());

        $loginModel->validate();

        if ($loginModel->errors) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Imate greske!");
            return $this->view("login", "auth", $loginModel);
        }

        if ($loginModel->login()) {
            Application::$app->session->set(Application::$app->session->USER_SESSION, $loginModel->email);
            header("location:" . "/home");
        }

        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "login nije uspesno prosao!");
        return $this->view("login", "auth", $loginModel);
    }

    public function logout() {
        Application::$app->session->remove(Application::$app->session->USER_SESSION);
        Application::$app->session->remove(Application::$app->session->ROLE_SESSION);
        header("location:" . "/home");
    }

    public function registration() {
        $this->view("registration", "auth", null);
    }

    public function registrationProcess() {
        $registrationModel = new RegistrationModel();
        $registrationModel->mapData($this->router->request->all());

        $registrationModel->validate();

        if ($registrationModel->errors) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Registracija nije dobra");
            return $this->view("registration", "auth", $registrationModel);
        }

        $registrationModel->register();

        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Registracija je prosla!");

        return $this->view("login", "auth", null);
    }

    public function authorize(): array
    {
        return [];
    }
}
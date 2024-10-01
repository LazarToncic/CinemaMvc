<?php

namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller
{
    public function index() {
        $this->view("home", "empty", null);
    }

    public function authorize(): array
    {
        return [];
    }
}
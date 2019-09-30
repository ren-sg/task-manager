<?php

namespace App\Controllers;

use Core\View;
use InvalidArgumentException;

class UserController extends \Core\Controller {
    public $messages = [];

    public function indexAction() {
        if (array_key_exists('submit', $_POST)) {
            $this->login();
        }
        View::render('LoginPage.html', []);
    }

    public function logoutAction() {
        $user_object = new \App\Models\UserModel();
        $user_object->logout();
        header('Location: /');
    }

    protected function login() {
        $user_object = new \App\Models\UserModel();

        try {
            $user = $user_object->login($_POST);
            header('Location: /');
        } catch (InvalidArgumentException $e) {
            $this->messages['error'] = $e->getMessage();
        }
    }
}

<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class LoginController extends Controller {

    public function signin() {
        $alert = '';
        $success = '';
        if (!empty( $_SESSION['alert'])) {
            $alert =  $_SESSION['alert'];
            $_SESSION['alert'] = '';
        }

        if (!empty($_SESSION['success'])) {
            $success =  $_SESSION['success'];
            $_SESSION['success'] = '';
        }

        $this->render('login', [
            'alert' => $alert,
            'success' => $success
        ]);
    }

    public function signinAction() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($email && $password) {
            $token = UserHandler::verifyLogin($email, $password);
            if ($token) {
                $_SESSION['token'] = $token;

                $_SESSION['success'] = '<p style="color: white; display: inline; padding: 5px 15px; background-color: green; font-weight: 600; font-size: 1.3em; text-align: center; margin: 20px auto; border-radius: 20px; box-shadow: 0px 0px 10px black;">logado com sucesso</p>';
                $this->redirect('/');
                exit;
            } else {
                $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">Email e/ou senha incorretos</p>';
                $this->redirect('/login');
                exit;
            }
        } else {
            $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">preencha os campos corretamente</p>';
            $this->redirect('/login');
            exit;
        }
    }

    public function signup() {
        $alert = '';
        $success = '';
        if (!empty($_SESSION['alert'])) {
            $alert = $_SESSION['alert'];
            $_SESSION['alert'] = '';
        }

        if (!empty($_SESSION['success'])) {
            $success =  $_SESSION['success'];
            $_SESSION['success'] = '';
        }
        $this->render('cadastro', [
            'alert' => $alert,
            'success' => $success
        ]);
    }

    public function signupAction() {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $nasc = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($name && $email && $password && $nasc) {
            $dateNasc = explode('/', $nasc);
            if (count($dateNasc) == 3) {
                $birthdate = $dateNasc[2].'-'.$dateNasc[1].'-'.$dateNasc[0];
                if (strtotime($birthdate)) {
                    if (UserHandler::emailExists($email) === false) {
                        $token = UserHandler::addUser($name, $email, $password, $birthdate);
                        $_SESSION['token'] = $token;
                        $_SESSION['success'] = '<p style="color: white; display: inline; padding: 5px 15px; background-color: green; font-weight: 600; font-size: 1.3em; text-align: center; margin: 20px auto; border-radius: 20px; box-shadow: 0px 0px 10px black;">logado com sucesso</p>';
                        $this->redirect('/');
                    } else {
                        $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">este e-mail já está em uso. Escolha outro!</p>';
                        $this->redirect('/cadastro');
                        exit;
                    }
                } else {
                    $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">data de nascimento inválida</p>';
                    $this->redirect('/cadastro');
                    exit;
                }
            } else {
                $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">data de nascimento inválida</p>';
                $this->redirect('/cadastro');
                exit;
            }
        } else {
            $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">preencha os campos obrigatórios *</p>';
            $this->redirect('/cadastro');
            exit;
        }
    }

    public function logout() {
        $_SESSION['token'] = '';
        $this->redirect('/');
    }

}
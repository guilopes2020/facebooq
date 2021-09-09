<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index($attbts = []) {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

        //detectando o usuário acessado
        $id = $this->loggedUser->id;
        
        if (!empty($attbts['id'])) {
            $id = $attbts['id'];
        }
        
        // pegando informações do usuário
        $user = UserHandler::getUser($id, true);

        if (!$user) {
            $this->redirect('/');
            exit;
        }

        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        // pegando o feed do usuário
        $feed = PostHandler::getUserFeed($id, $page, $this->loggedUser->id);

        // verificar se EU sigo o usuário
        $isFollowing = false;
        if ($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isFollowing
        ]);
    }

    public function follow($attbts) {
        $to = intval($attbts['id']);

        if (UserHandler::idExists($to)) {
            if (UserHandler::isFollowing($this->loggedUser->id, $to)) {
                // deixar de seguir
                UserHandler::unfollow($this->loggedUser->id, $to);
            } else {
                UserHandler::follow($this->loggedUser->id, $to);

            }
        }
        
        $this->redirect('/perfil/'.$to);
    }

    public function friends($attbts=[]) {
        //detectando o usuário acessado
        $id = $this->loggedUser->id;
        
        if (!empty($attbts['id'])) {
            $id = $attbts['id'];
        }
        
        // pegando informações do usuário
        $user = UserHandler::getUser($id, true);

        if (!$user) {
            $this->redirect('/');
            exit;
        }

        // verificar se EU sigo o usuário
        $isFollowing = false;
        if ($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' =>$isFollowing
        ]);
    }

    public function photos($attbts=[]) {
        //detectando o usuário acessado
        $id = $this->loggedUser->id;
        
        if (!empty($attbts['id'])) {
            $id = $attbts['id'];
        }
        
        // pegando informações do usuário
        $user = UserHandler::getUser($id, true);

        if (!$user) {
            $this->redirect('/');
            exit;
        }

        // verificar se EU sigo o usuário
        $isFollowing = false;
        if ($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' =>$isFollowing
        ]);
    }

    public function update() {
        $user = UserHandler::getUser($this->loggedUser->id, true);
        if ($user) {
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
            $this->render('configuracoes', [
                'alert' => $alert,
                'success' => $success,
                'loggedUser' => $this->loggedUser,
                'user' => $user
            ]);
        } else {
            $this->redirect('/');
        }
    }

    public function updateAction() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $emailAtual = filter_input(INPUT_POST, 'emailAtual', FILTER_VALIDATE_EMAIL);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $passwordVerify = filter_input(INPUT_POST, 'passwordVerify', FILTER_SANITIZE_SPECIAL_CHARS);
        $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
        $work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'] ?? null;
        $cover = $_FILES['cover'] ?? null;

        $updateFields = [];

        if ($avatar && !empty($avatar['tmp_name'])) {
            $newAvatar = $avatar;

            if (in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                $avatarName = $this->cutImage($newAvatar, 200, 200, 'media/avatars');
                $updateFields['avatar'] = $avatarName;
            }
        }

        if ($cover && !empty($cover['tmp_name'])) {
            $newCover = $cover;

            if (in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                $coverName = $this->cutImage($newCover, 850, 310, 'media/covers');
                $updateFields['cover'] = $coverName;
            }
        }

        if (!empty($password)) {
            $dateNasc = explode('/', $birthdate);
            if (count($dateNasc) == 3) {
                $birthdate = $dateNasc[2].'-'.$dateNasc[1].'-'.$dateNasc[0];
                if (strtotime($birthdate)) {
                    if($password === $passwordVerify) {
                        if (UserHandler::emailExists($email) === false || $emailAtual === $email) {

                            $updateFields['name'] = $name;
                            $updateFields['email'] = $email;
                            $updateFields['password'] = $password;
                            $updateFields['birthdate'] = $birthdate;
                            $updateFields['city'] = $city;
                            $updateFields['work'] = $work;

                            $token = UserHandler::updateUser($id, $updateFields);
                            $_SESSION['token'] = $token;
                            $_SESSION['success'] = '<p style="color: white; display: inline; padding: 5px 15px; background-color: green; font-weight: 600; font-size: 1.3em; text-align: center; margin: 20px auto; border-radius: 20px; box-shadow: 0px 0px 10px black;">alterações realizadas com sucesso!</p>';
                            $this->redirect('/perfil');
                        } else {
                            $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">este e-mail já está em uso. Escolha outro!</p>';
                            $this->redirect('/configuracoes');
                            exit;
                        }
                    } else {
                        $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">Senhas não conferem!</p>';
                        $this->redirect('/configuracoes');
                        exit;
                    }    
                } else {
                    $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">data de nascimento inválida</p>';
                    $this->redirect('/configuracoes');
                    exit;
                }
            } else {
                $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">data de nascimento inválida</p>';
                $this->redirect('/configuracoes');
                exit;
            }
        } else {
            $_SESSION['alert'] = '<p style="color: red; text-align: center; margin-top: 20px;">Preencha o campo senha</p>';
            $this->redirect('/configuracoes');
            exit;
        }
    }

    public function cutImage($file, $w, $h, $folder) {
        list($widthOrig, $heightOrig) = getimagesize($file['tmp_name']);
        $ratio = $widthOrig / $heightOrig;

        $newWidth = $w;
        $newHeight = $newWidth / $ratio;

        if ($newHeight < $h) {
            $newHeight = $h;
            $newWidth = $newHeight * $ratio;
        }

        $x = $w - $newWidth;
        $y = $h - $newHeight;
        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($w, $h);
        switch ($file['type']) {
            case 'image/jpeg':
            case 'image/jpg':    
                $image = imagecreatefromjpeg($file['tmp_name']);        
            break;

            case 'image/png':    
                $image = imagecreatefrompng($file['tmp_name']);        
            break;
        }

        imagecopyresampled($finalImage, $image, $x, $y, 0, 0, $newWidth, $newHeight, $widthOrig, $heightOrig);

        $fileName = md5(time().rand(0, 9999)).'.jpg';

        imagejpeg($finalImage, $folder.'/'.$fileName);

        return $fileName;
    }
}
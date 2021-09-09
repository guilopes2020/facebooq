<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class AjaxController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if ($this->loggedUser === false) {
            header("Content-Type: application/json");
            echo json_encode(['error' => 'Usuário não logado']);
            exit;
        }
    }

    public function like($attbts) {
        $id = $attbts['id'];

        if (PostHandler::isLiked($id, $this->loggedUser->id)) {
            PostHandler::deleteLike($id, $this->loggedUser->id);
        } else {
            PostHandler::addLike($id, $this->loggedUser->id);
        }
    }

    public function comment() {
        $array = ['error' => ''];

        $id = filter_input(INPUT_POST, 'id');
        $txt = filter_input(INPUT_POST, 'txt');

        if ($id && $txt) {
            PostHandler::addComment($id, $txt, $this->loggedUser->id);

            $array['link'] = '/perfil/'.$this->loggedUser->id;
            $array['avatar'] = '/media/avatars/'.$this->loggedUser->avatar;
            $array['name'] = $this->loggedUser->name;
            $array['body'] = $txt;
        }

        header("Content-Type: application/json");
        echo json_encode($array);
        exit;
    }

    public function upload() {
        $array = ['error' => ''];

        if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
            
            $photo = $_FILES['photo'];
            $maxWidth = 800;
            $maxHeight = 800;

            if (in_array($photo['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {

                list($widthOrig, $heightOrig) = getimagesize($photo['tmp_name']);
                $ratio = $widthOrig / $heightOrig;
                $newWidth = $maxWidth;
                $newHeight = $maxHeight;
                $ratioMax = $maxWidth / $maxHeight;

                if ($ratioMax > $ratio) {
                    $newWidth = $newHeight * $ratio;
                } else {
                    $newHeight = $newWidth / $ratio;
                }

                $finalImage = imagecreatetruecolor($newWidth, $newHeight);
                switch ($photo['type']) {
                    case 'image/png':
                        $image = imagecreateFrompng($photo['tmp_name']);
                    break;
                    
                    case 'image/jpg':
                    case 'image/jpg':    
                        $image = imagecreateFromjpeg($photo['tmp_name']);
                    break;
                }

                imagecopyresampled($finalImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $widthOrig, $heightOrig);

                $photoName = md5(time().rand(0, 9999)).'.jpg';
                imagejpeg($finalImage, __DIR__.'/../../media/uploads/'.$photoName);

                PostHandler::addPost('photo', $this->loggedUser->id, $photoName);
            }

    } else {
        $array['error'] = 'Nemhuma imagem enviada!';
    }

    header("Content-Type: application/json");
            echo json_encode($array);
            exit;
        }

}
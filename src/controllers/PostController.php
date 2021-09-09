<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class PostController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function new() {
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);
        if ($body) {
            PostHandler::addPost('text', $this->loggedUser->id, $body);
        }

        $this->redirect('/');
    }

    public function delete($attbts = []) {
        
        if (!empty($attbts['id'])) {
            $idPost = $attbts['id'];

            PostHandler::deletePost($idPost, $this->loggedUser->id);
        }

        $this->redirect('/');
    }


}
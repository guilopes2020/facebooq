<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class SearchController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index($attbts = []) {
        $searchTerm = filter_input(INPUT_GET, 's', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($searchTerm)) {
            $this->redirect('/');
        }

        $users = UserHandler::searchUser($searchTerm);

        $this->render('search', [
            'loggedUser' => $this->loggedUser,
            'users' => $users
        ]);
    }
}
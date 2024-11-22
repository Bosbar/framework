<?php

namespace Bosbar;

use Bosbar\Handlers\DatabaseHandler;
// use Bosbar\Controller;

class LoginController  extends Controller
{

    private $database;

    public function __construct() {
        parent::__construct();
        $this->database = new DatabaseHandler();
    }

    /**
     * Default function of the controller.
     * @return void
     */
    public function index() {
        $this->login();
    }

    public function login() {
        $this->loadView("login", "index", _('Inloggen'), 0, []);
    }
}
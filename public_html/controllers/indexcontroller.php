<?php

namespace Bosbar\Controllers;

use Bosbar\Controller;
use Bosbar\Handlers\DatabaseHandler;
use Bosbar\Handlers\HallHandler;

class IndexController extends Controller {
    public function index() {
        // Initialize the necessary handlers
        $dbHandler = new DatabaseHandler();
        echo LOGIN_NEEDED;
        // Assuming the LOGGING_NEEDED is defined somewhere in a config file or globally
        if (defined('LOGIN_NEEDED') && LOGIN_NEEDED === true) {
            // If logging is needed, redirect to the login page
            $this->redirect(SITE_ROOT . '/login/login');
        } else {
            // If logging is not needed, redirect to the dashboard
            $this->redirect(SITE_ROOT . '/dashboard/index');
        }
    }
    
    // Assuming you have a redirect method in the base controller
    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }
}
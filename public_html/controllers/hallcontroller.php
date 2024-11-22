<?php

namespace WelkeHal\Controllers;

use WelkeHal\Controller;
use WelkeHal\Handlers\DatabaseHandler;

class HallController extends Controller {
    public function index() {
        echo "Index Controller Index Method<br>";

        $dbHandler = new DatabaseHandler();
        // Example usage of DatabaseHandler
        $result = $dbHandler->useDb("SELECT * FROM `halls`");
        var_dump($result);

        var_dump("hoi");
    }

    public function test($arg1, $arg2) {
        echo $arg1 . $arg2;
    }
}

?>

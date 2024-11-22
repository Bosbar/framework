<?php

namespace WelkeHal\Controllers;

use WelkeHal\Controller;
use WelkeHal\Handlers\HallHandler;

class ApiController extends Controller {

    public function hallConfirmedStatus() {
        $hallHandler = new HallHandler();

        // Assuming HallHandler has a method isHallConfirmed that returns a boolean
        $confirmed = $hallHandler->isHallConfirmed("afv0v@v928!!");

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['confirmed' => $confirmed]); // Ensure $confirmed is a boolean
        return;
    }

    public function overrule() {
        $hallHandler = new HallHandler();
        $hallHandler->overruleHall("afv0v@v928!!");
        
        header('Location: http://proxiart.nl/welkehal/index');
        exit;
    }

    public function confirm() {
        $hallHandler = new HallHandler();
        $hallHandler->confirmHall("afv0v@v928!!");
        
        header('Location: http://proxiart.nl/welkehal/index');
        exit;
    }
}
?>

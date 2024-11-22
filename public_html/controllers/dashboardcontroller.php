<?php

namespace Bosbar\Controllers;
 
use Bosbar\Controller;

/**
 * Standard Dashboard controller example.
 * @category   Controllers
 * @package    Bosbar
 */
class DashboardController extends Controller
{
    private $_sec;

    /**
     * Constructor, assigns the user to the view.
     * @return void
     */
    public function __construct() {
        // parent::__construct(AuthorizationTypes::$dashboard);
        // $this->_sec = new SecurityHandler();
        // $this->view->assignTemplate("alertbox", array("type", "title", "description", "icon", "btnText", "href"));
    }

    /**
     * Default view, loads the dashboard.
     * @return void
     */
    public function index() {
        $this->loadView(
            'dashboard',
            'index',
            'Dashboard',
            0,
            [
                'css' => ['setup.css'],
                'js' => [],
            ]
        );
    }
}

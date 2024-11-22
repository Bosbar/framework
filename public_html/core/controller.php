<?php

namespace Bosbar;

use Bosbar\Handlers\PermissionHandler;
use Bosbar\Types\PermissionTypes;
use Bosbar\View;

class Controller 
{
    protected $permission;
    protected $view;

    public function __construct() {
        $this->view = new View();
        $this->permission = new PermissionHandler();
    }

    /**
     * @param string variableFilename viewfile name.
     * @param string variableFolder   folder the viewfile is located.
     * @param string pageTitle        Title shown in the tab.
     * @param array data              
     */
    protected function loadViewBackup($variableFilename, $variableFolder, $pageTitle, $setup, $data = []) {
        echo $variableFilename . "<br>";
        echo $variableFolder . "<br>";
        echo $pageTitle . "<br>";

        // $this->view->setSiteTitle($pageTitle);
        // $this->view->Assign("page", $pageTitle);
        // $this->view->setCSS("bootstrap.min.css");
        // $this->view->setCSS("standard.css");
        // $this->view->setCSS("callout.css");
        // $this->view->setCSS("metisMenu.min.css");
        // $this->view->setCSS("fontawesome-all.min.css");
        // if ($setup > 1) {
        //     $this->view->setCSS("sidebar.css");
        // }
        // foreach ($data['css'] as $cssSingle) {
        //     $this->view->setCSS($cssSingle . ".css");
        // }
        // foreach ($data['js'] as $cssSingle => $website) {
        //     $this->view->setCSSExternal($cssSingle . ".css", $website);
        // }
        // $this->view->setJS("jquery-3.5.1.min.js");
        // $this->view->setJSFooter("bootstrap.min.js");
        // $this->view->setJSFooter("metisMenu.min.js");
        // $this->view->setJSFooter("fontawesome.min.js");
        // foreach ($data['js'] as $jsSingle) {
        //     $this->view->setJSFooter($jsSingle . ".js");
        // }
        // foreach ($externalJS as $jsSingle => $website) {
        //     $this->view->setJSExternal($jsSingle . ".js", $website);
        // }
        
        $this->setViewSetup($variableFilename, $variableFolder, $setup);
        $this->view->outPutView(); //render view, added because of modules
    }

    function loadView($variableFolder, $variableFilename, $pageTitle, $setup, $data = []) {
        // Construct the full path to the view file
        $viewFilePath = realpath(__DIR__ . "/../") . "/views/$variableFolder/$variableFilename.php";
    
        // Check if the view file exists before including
        if (file_exists($viewFilePath)) {
            // Extract data variables to be available in the view
            extract($data);
    
            // Include the header file
            include realpath(__DIR__ . "/../") . "/views/header.php";
    
            // Include the view file
            include $viewFilePath;
    
            // Include the footer file
            include realpath(__DIR__ . "/../") . "/views/footer.php";
        } else {
            // Handle case where view file doesn't exist
            echo "View file not found: $viewFilePath";
        }
    }

    /**
     * Assign a value to the global $data variable.
     * @param string $key   Key to assign to in the array.
     * @param mixed  $value Value to assign to the name.
     * @return void
     */
    protected function assign($key, $value) {
        $this->view->assign($key, $value);
    }

    protected function setViewSetup($which, $target, $setup) {
        if ($setup > 0) {
            //HEADER
            $this->view->assign('header', $this->view->render("header"));
            //Navbar
            $this->view->assign('navbar', $this->view->render("navbar"));
            //Sidebar
            $this->view->assign('sidebar_used', $setup == 2);
            if ($setup == 2) {
                $this->view->assign('sidebar', $this->view->render("sidebar"));
            }
            //Content
            $this->view->assign('content', $this->view->render($which . DS . $target));
            // FOOTER
            $this->view->assign('footer', $this->view->render("footer"));
        }
    }
}

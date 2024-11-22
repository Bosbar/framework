<?php
namespace Bosbar;

use SG\Handlers\AccountHandler;
use ReflectionMethod;

/**
 * Check if environment is development and display errors *
 * @category Core
 * @package SG
 */
class dispatcher
{
    public static function setReporting() {
        if (DEV_ENV) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
        }
    }

    public static function standardCallHook() {
        global $user;
        global $url;
        $api = false;
        $start = count(explode('/', SITE_ROOT)) - 1;
        if (USE_HTTPS && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
            header("refresh:0; url=https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            return;
        }
        $urlArray = array();
        if (!isset($url) || $url == SITE_ROOT) {
            $controllerName = DEFAULT_CONTROLLER;
            $action = DEFAULT_ACTION;
        } else {
            if (strpos($url, '?')) {
                $urlArray = explode("/", strstr($url, '?', true));
            } else {
                $urlArray = explode("/", $url);
            }
            if ($urlArray[$start] === 'api') {
                $start = $start + 1;
                $api = true;
            }
            $controllerName = $urlArray[$start];
            $action = (isset($urlArray[$start + 1]) && $urlArray[$start + 1] != '') ? $urlArray[$start + 1] : DEFAULT_ACTION;
        }
        $queryParams = array();
        for ($i = $start + 2; $i < count($urlArray); $i++) {
            $queryParams[] = $urlArray[$i] != '' ? $urlArray[$i] : null;
        }

        //modify controller name to fit naming convention
        $controller_namespace = $api ? 'SG\\Api\\' : 'SG\\Controllers\\';
        $class = $controller_namespace . ucfirst($controllerName) . 'Controller';
        if ($controllerName == "") {
            //empty controllerName means default controller.
            $controllerName = DEFAULT_CONTROLLER;
            $action = DEFAULT_ACTION;
            $class = $controller_namespace . ucfirst($controllerName) . 'Controller';
        }

        /*Setup language*/
        $localeArray = array("nl" => "nl_NL","en" => "en_US");
        if (isset($_GET['lang']) && in_array($_GET['lang'], $localeArray)) {
            $_SESSION['locale'] = $_GET['lang'];
        }
        $selected = "en_US";
        if (isset($_SESSION['locale'])) {
            $selected = $_SESSION['locale'];
        }
        $results = putenv("LC_ALL=$selected");
        if (!$results) {
            exit('putenv failed');
        }
        //fix for Turkish and other weird languages breaking PHP (https://bugs.php.net/bug.php?id=18556)
        setlocale(LC_CTYPE, 'en_US');
        setlocale(LC_ALL, $selected);
        bindtextdomain("messages", "../locale");
        textdomain('messages');
        /*Done language*/
        if (class_exists($class) && !$user->exceptionList($controllerName, $api) && !$user->getUser()->isLoggedIn()) {
            if ($api) {
                try {
                    self::apiOauth($controllerName, $class, $action, $queryParams);
                } catch (\Exception $e) {
                    header("refresh:0; url=" . SITE_ROOT . 'api/index/');
                }
            } else {
                header("refresh:0; url=" . SITE_ROOT . 'index/');
            }
            exit(1);
        }
        //instantiate the appropriate class
        if (class_exists($class) && (int)method_exists($class, $action)) {
            $reflection = new ReflectionMethod($class, $action);
            if (!$reflection->isPublic()) {
                $action = DEFAULT_ACTION;
            }
            $controller = new $class();
            call_user_func_array(array($controller, $action), $queryParams);
        } elseif (class_exists($class) && !(int)method_exists($class, $action)) {
            $controller = new $class();
            $action = DEFAULT_ACTION;
            $controller->$action();
        } else {
            //Error: Controller Class not found, show 404 page (better than index)
            header('HTTP/1.0 404 Not Found');
            if (DEV_ENV) {
               die("1. File <strong>'$controllerName.php'</strong> containing class <strong>'$class'</strong> might be missing. 2. Method <strong>'$action'</strong> is missing in <strong>'$controllerName.php'</strong>");
        } else {
                die();
            }
        }
    }

    public static function initialize() {
        // global $user;
        self::setReporting();
        // $user = new AccountHandler();
        self::standardCallHook();
    }

    private static function apiOauth($controllerName, $class, $action, $queryParams) {
        global $server;
        $server = new AuthorizationServer();
        self::apiCallHook($controllerName, $class, $action, $queryParams);
    }

    public static function apiCallHook($controllerName, $class, $action, $queryParams) {
        //instantiate the appropriate class
        if (class_exists($class) && (int)method_exists($class, $action)) {
            $reflection = new ReflectionMethod($class, $action);
            if (!$reflection->isPublic()) {
                $action = DEFAULT_ACTION;
            }
            $controller = new $class();
            call_user_func_array(array($controller, $action), $queryParams);
        } elseif (class_exists($class) && !(int)method_exists($class, $action)) {
            if (is_numeric($action)) {
                $queryParams = array($action);
            } else {
                $queryParams = array();
            }
            $controller = new $class();
            $action = DEFAULT_ACTION;
            call_user_func_array(array($controller, $action), $queryParams);
        } else {
            //Error: Controller Class not found
            die("1. File <strong>'$controllerName.php'</strong> containing class <strong>'$class'</strong> might be missing. 2. Method <strong>'$action'</strong> is missing in <strong>'$controllerName.php'</strong>");
        }
    }

}
<?php

namespace Bosbar;

use Dotenv\Dotenv;

// Load Composer's autoloader
require_once(__DIR__ . '/../vendor/autoload.php');

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../config');
$dotenv->load();

if($_ENV['DEBUG']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}


// Access environment variables
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_PORT', $_ENV['DB_PORT']);

// Other configuration settings...
define('LOGIN_NEEDED', FALSE);
define('SITE_ROOT',  $_ENV['SITE_ROOT']);
define('DEV_ENV', isset($_ENV['DEV_ENV']) ? $_ENV['DEV_ENV'] : 1);
define('USE_HTTPS', isset($_ENV['USE_HTTPS']) ? $_ENV['USE_HTTPS'] : 1);

define('DEFAULT_CONTROLLER', "index");
define('DEFAULT_ACTION', "index");

define('JS_VERSION', 0);
define('CSS_VERSION', 0);
?>

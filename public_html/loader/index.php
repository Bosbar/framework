<?php

// Load Composer's autoloader and other required files
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../core/controller.php");
require_once(__DIR__ . "/../core/functions.php");

// Function to handle the request
function handleRequest() {
    // Parse the request URI
    $requestUri = $_SERVER['REQUEST_URI'];

    // Trim leading/trailing slashes from the request URI
    $trimmedPath = trim($requestUri, '/');

    // Split the trimmed path into segments
    $segments = explode('/', $trimmedPath);

    // Controller name defaults to Index if not specified
    $controllerName = ucfirst($segments[0] ?? 'Index');
    
    // Function name defaults to index if not specified
    $functionName = $segments[1] ?? 'index';

    // Arguments are the remaining segments
    $arguments = array_slice($segments, 2);

    // Construct the controller file path
    $controllerFile = __DIR__ . "/../controllers/". strtolower($controllerName) ."controller.php";

    // Check if the controller file exists
    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        // Formulate the fully qualified controller class name
        $controllerClass = 'Bosbar\\Controllers\\' . $controllerName . 'Controller';

        // Check if the controller class exists
        if (class_exists($controllerClass)) {
            // Instantiate the controller
            $controller = new $controllerClass();

            // Check if the function exists in the controller
            if (method_exists($controller, $functionName)) {
                // Call the controller function with arguments
                call_user_func_array([$controller, $functionName], $arguments);
            } else {
                echo "Function $functionName not found in controller $controllerName";
            }
        } else {
            echo "Controller class $controllerClass not found";
        }
    } else {
        echo "Controller file $controllerFile not found";
    }
}

function requireHandlersFromFolder($folderPath) {
    // Scan the specified folder for PHP files
    $files = scandir($folderPath);

    foreach ($files as $file) {
        // Exclude current and parent directory indicators
        if ($file !== '.' && $file !== '..') {
            // Construct the full file path
            $filePath = $folderPath . '/' . $file;

            // Check if it's a PHP file
            if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                // Require the file
                require_once $filePath;

                // Assuming class naming convention: Filename should match class name
                $className = pathinfo($file, PATHINFO_FILENAME);

                // Check if the class exists
                if (class_exists($className)) {
                    // Instantiate the class (assuming a default constructor)
                    new $className();
                }
            }
        }
    }
}

// Call the function to handle the request
requireHandlersFromFolder('../handlers');
handleRequest();
?>

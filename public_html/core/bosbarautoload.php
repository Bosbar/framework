<?php

namespace Bosbar;

define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

//Composer autoload
require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');
//Configs
require_once(ROOT . DS . 'config' . DS . 'config.php');
// phpcs:enable

function bosbarLoader($class) {
    // Break the class name into parts by namespace
    $namespaceParts = explode("\\", $class);
    $partsCount = count($namespaceParts);
    $className = $namespaceParts[$partsCount - 1];

    // Determine the directory based on the namespace structure
    if ($partsCount > 2) {
        $directory = $namespaceParts[$partsCount - 2];
    } else {
        $directory = "core";
    }

    // Construct the file path and include the class file if it exists
    $filePath = ROOT . DS . strtolower($directory) . DS . strtolower($className) . '.php';
    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

spl_autoload_register('Bosbar\\bosbarLoader');

require_once  ROOT . DS . 'vendor' . DS . 'autoload.php';
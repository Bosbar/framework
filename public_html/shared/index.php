<?php
// Set session cookie parameters for 10 hours with secure settings
session_set_cookie_params(3600 * 10, '/', '', true, true);

/**
 * Get the current page URL
 *
 * @return string Current page URL
 */
function getCurrentPageURL() {
    $url = 'http';
    
    // Check if the connection is secure (HTTPS)
    if ((!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") || $_SERVER['SERVER_PORT'] == 443) {
        $url .= "s";
    }
    
    $url .= "://";
    
    // Append server name and request URI
    if ($_SERVER["SERVER_PORT"] != "80") {
        $url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    
    return $url;
}

// Retrieve the current page URL
$currentURL = getCurrentPageURL();

// Include the custom autoload file from the library directory
require_once dirname(dirname(__FILE__)) . '/library/bosbarautoload.php';

// Start the router
\Bosbar\Dispatcher::initialize();
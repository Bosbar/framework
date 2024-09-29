<?php

// Function to set data for the view
function setViewData($key, $value) {
    $_SESSION[$key] = $value;
}

// Function to get data for the view
function getViewData($key) {
    return $_SESSION['viewData'][$key] ?? null;
}

// Function to render a view file with optional data
/**
 * @param string variableFilename viewfile name.
 * @param string variableFolder   folder the viewfile is located.
 * @param string pageTitle        Title shown in the tab.
 * @param array data              
 */
function renderView($variableFilename, $variableFolder, $pageTitle, $data = []) {
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

function setupRenderViw() {

}
}
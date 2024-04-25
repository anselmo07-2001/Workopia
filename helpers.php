<?php

/** 
 *   GET THE BASE PATH
 *   @param string $path
 *   @return string
 */


function basePath($path = "") {
    // __DIR__ return the absolute path of the file folder
    return __DIR__ . "/" . $path;
}


/**
 *   LOAD THE VIEW
 *   @param string $name
 *   @return void
 */
function loadView($name) {

   $viewPath = basePath("views/{$name}.view.php");

   inspectAndDie($name);

   if (file_exists($viewPath)) {
       require $viewPath;
   } else {
        echo "View '{$name} not found!'";
   }
}

/**
 *   LOAD A PARTIAL
 *   @param string $name
 *   @return void
 */
function loadPartial($name) {
    $partialsPath = basePath("views/partials/{$name}.php");

    if (file_exists($partialsPath)) {
        require $partialsPath;
    }
    else {
         echo "Partials '{$name} not found!'";
    }
}

/**
 *   INSPECT A VALUE(s)
 * 
 *    @param mixed $value
 *    @return void
 * 
 */

 function inspect($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
 }

function inspectAndDie($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}
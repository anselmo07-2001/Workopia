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
function loadView($name, $data= []) { 
   $viewPath = basePath("views/{$name}.view.php");

   if (file_exists($viewPath)) {
       extract($data);
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
    echo "--------------------------------";
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    echo "--------------------------------";
 }

function inspectAndDie($value) {
    echo "--------------------------------";
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
    echo "--------------------------------";
}

/**
 * Format Salary
 * 
 * @param string $salary
 * @param string Formatted Salary
 * 
 */
function formatSalary($salary) {
    return "$" . number_format(floatval($salary));
}
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
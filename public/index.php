<?php
    require "../helpers.php";
    require basePath("Router.php");
    require basePath("Database.php");

    // Instatiating the router
    $router = new Router();    

    //Get routes
    $routes = require basePath("routes.php");
    
    // GET current URI AND HTTP METHOD
    $uri = $_SERVER["REQUEST_URI"];
    $method = $_SERVER["REQUEST_METHOD"];
  
    //ROUTE THE REQUEST
    $router->route($uri, $method);
?>
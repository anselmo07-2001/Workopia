<?php     
    require __DIR__ . "/../vendor/autoload.php";
    
    use Framework\Router;
    use Framework\Session;

    Session::start();

    require "../helpers.php";

    // Instatiating the router
    $router = new Router();    

    //Get routes
    $routes = require basePath("routes.php");
    
    // GET current URI AND HTTP METHOD
    $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    // inspect($uri);
 
    //ROUTE THE REQUEST
    $router->route($uri);
?>
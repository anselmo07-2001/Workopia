<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router {
    protected $routes = [];

    public function registerRoute($method, $uri, $action) {
        list($controller, $controllerMethod) = explode("@", $action);
        
        $this->routes[] = [
            "method" => $method,
            "uri" => $uri,
            "controller" => $controller,
            "controllerMethod" => $controllerMethod
        ];   
    }
 
    /**
     * ADD A GET ROUTE
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller) {
       $this->registerRoute("GET", $uri, $controller);
    }

     /**
     * ADD A POST ROUTE
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller) {
        $this->registerRoute("POST", $uri, $controller);
    }


     /**
     * ADD A PUT ROUTE
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller) {
        $this->registerRoute("PUT", $uri, $controller);
    }


     /**
     * ADD A DELETE ROUTE
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller) {
        $this->registerRoute("DELETE", $uri, $controller);
    }

    /**
     *  ROUTE THE REQUEST
     * 
     *   @param string $uri
     *   @param string $method
     *   @param void
     * 
     */
    public function route($uri) {
       
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        // Check for _method input
        if ($requestMethod === "POST" && isset($_POST["_method"])) {
            //override the request method with the value of _method
            $requestMethod = strtoupper($_POST["_method"]);
        }
  
        foreach($this->routes as $route) {
    
            // Split the current URI into segments
            $uriSegments = explode("/", trim($uri, "/"));
        
            // Split the route uri into segments
            $routeSegments = explode("/", trim($route["uri"], "/"));    

            $match = true;

            // Check if the number of segments matches
            if (count($uriSegments) === count($routeSegments) && 
                strtoupper($route["method"] === $requestMethod)) {
                   $params = [];
                   $match = true;
                   
                   for($i = 0; $i < count($uriSegments); $i++) {
                       // if the uri do not match and there is no param
                       if ($routeSegments[$i] !== $uriSegments[$i] && 
                            !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                            $match = false;
                            break;
                       }

                       //Check for the params and add to $params array
                       if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                           $params[$matches[1]] = $uriSegments[$i];                    
                       }
                   }

                   if ($match) {
                    // Extract controller and controller method
                       $controller = "App\\Controllers\\" . $route["controller"];
                       $controllerMethod = $route["controllerMethod"];

                    // Instatiate the controller and call the method
                        $controllerInstance = new $controller();
                        $controllerInstance->$controllerMethod($params);
                        return;
                   } 

            }       
        }

        ErrorController::notFound();
    }
}
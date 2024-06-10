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
    public function route($uri, $method) {
        foreach($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === $method) {
                //Extract controller and controller method
                $controller = "App\\Controllers\\" . $route["controller"];
                $controllerMethod = $route["controllerMethod"];

                //Instatiate the controller and call the method
                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod();

                return;
            }    
        }

        ErrorController::notFound();
    }
}
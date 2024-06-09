<?php

namespace Framework;


class Router {
    protected $routes = [];

    public function registerRoute($method, $uri, $controller) {
        $this->routes[] = [
            "method" => $method,
            "uri" => $uri,
            "controller" => $controller
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
     *  Load error page
     *  @param int $httpCode
     * 
     *  @return void
     */
    public function error($httpCode = 404) {
        http_response_code($httpCode);   
        loadView("error/{$httpCode}");
        exit;
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
                require basePath('App/' . $route["controller"]);
                return;
            }    
        }

        $this->error();
    }
}
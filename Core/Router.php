<?php

namespace Core;

class Router {
    protected $routes = [];
    protected $controller = "";

    public function add($route, $controller){
        $this->routes[$route] = $controller;
    }

    public function match($uri){
        if($uri[1] != ""){
            foreach($this->routes as $route => $controller){
                if(preg_match("|^${route}$|", $uri[1], $matches)){
                    if(is_string($matches[0])){
                        $this->controller = $controller;
                        return true;
                    }
                }
            }
        } else if($this->routes["/"]) {
            $this->controller = $this->routes["/"];
            return true;
        }
        return false;
    }

    public function dispatch($request_uri){
        $uri = explode("/", $request_uri);
        if($this->match($uri)){
            $controller = "App\\Controllers\\{$this->controller}";
            if (class_exists($controller)){
                $controller_object = new $controller();
            }
        } else {
            throw new \Exception('Not found', 404);
        }
    }

}
?>

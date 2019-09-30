<?php

namespace Core;

class Router {
    protected $routes = [];
    protected $params = ['controller' => '', 'action' => 'indexAction'];

    public function add($route, $controller) {
        $this->routes[$route] = $controller;
    }

    public function match($uri) {
        if ('' != $uri[1]) {
            foreach ($this->routes as $route => $params) {
                if (preg_match("|^${route}$|", $uri[1], $matches)) {
                    if (is_string($matches[0])) {
                        $this->params['controller'] = $params[0];
                        if (array_key_exists('action', $params)) {
                            $this->params['action'] = $params['action'];
                        }

                        return true;
                    }
                }
            }
        } elseif ($this->routes['/']) {
            $this->params['controller'] = $this->routes['/'][0];

            return true;
        }

        return false;
    }

    public function dispatch($request_uri) {
        $query_params = [];
        $parsed_url = parse_url($request_uri);
        $uri = explode('/', $parsed_url['path']);
        if (array_key_exists('query', $parsed_url)) {
            parse_str($parsed_url['query'], $query_params);
        }
        if ($this->match($uri)) {
            $controller = "App\\Controllers\\{$this->params['controller']}";
            if (class_exists($controller)) {
                $controller_object = new $controller();
                if (method_exists($controller_object, $this->params['action'])) {
                    call_user_func_array([$controller_object, $this->params['action']], [$query_params]);
                }
            }
        } else {
            throw new \Exception('Not found', 404);
        }
    }
}

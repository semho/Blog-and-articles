<?php

namespace App;

use App\Exception\NotFoundException;

class Router
{
    /** @var array|Route[]  */
    private array $routes = [];

    public function get(string $path, array $callback)
    {
        $this->addRoute('get', $path, $callback);
    }
    
    public function post(string $path, array $callback)
    {
        $this->addRoute('post', $path, $callback); 
    }
    
    private function addRoute(string $method, string $path, array $callback)
    {
        $this->routes[] = new Route($method, $path, $callback);
    }

    public function dispatch(string $url, string $method)
    {
        $uri = trim($url, '/');
        $method = mb_strtolower($method);
        
        foreach ($this->routes as $route) {
            if ($route->match($uri, $method)) {
                return $route->run($uri);
            }
        }
        
        throw new NotFoundException('Page not found', 404);
    }
}

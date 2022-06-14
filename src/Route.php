<?php

namespace App;

use Closure;

class Route
{
    private string $method;
    private string $path;
    private Closure $callback;

    public function __construct(string $method, string $path, array $callback)
    {
        $this->method   = $method;
        $this->path     = $path;
        $this->callback = $this->prepareCallback($callback);
    }

    private function prepareCallback(array $callback): Closure
    {
        return function (...$params) use ($callback) {
            list($class, $method) = $callback;
            return (new $class)->{$method}(...$params);
        };
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function match(string $uri, string $method): bool
    {   
        return 
            preg_match('/^' . str_replace(['*', '/', '?', '%'], ['\w+', '\/', '\?', '[\w\-]+'], $this->getPath()) . '$/', $uri) &&
            $this->method === $method;
    }

    public function run(string $uri)
    {
        
        preg_match('/^' . str_replace(['*', '/', '?', '%'], ['(\w+)', '\/', '\?', '([\w\-]+)'], $this->getPath()) . '$/', $uri, $matches);
        array_shift($matches);
        return call_user_func_array($this->callback, $matches);
    }

}

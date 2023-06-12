<?php
namespace Howest\Diy\Routing;

use Howest\Diy\Routing\RouteCallback;


class Route{
    private array $routes;
    private string $prefix;

    public function __construct(){
        $this->routes = [];
        $this->prefix = "";
    }

    public function get(string $url, callable|string $callback): void{
        $url = $this->hydrateUrl($url);
        $this->addRoute("GET", $url, $callback);
    }

    public function post(string $url, callable|string $callback): void{
        $url = $this->hydrateUrl($url);
        $this->addRoute("POST", $url, $callback);
    }

    private function hydrateUrl(string $url): string{
        $url = $this->prefix . $url;

        if(!$this->hasLeadingSlach($url))
            $url = "/" . $url;

        return $url;
    }

    private function hasLeadingSlach(string $prefix): bool{
        return strlen($prefix) && $prefix[0] === "/";
    }

    private function addRoute(string $method, string $url, callable|string $callback): void{
        if(!isset($this->routes[$method]))
            $this->routes[$method] = [];

        $this->routes[$method][$url] = new RouteCallback($callback);
    }
    
    public function setPrefix(string $prefix): void{        
        $this->prefix = trim($prefix);
    }

    public function hasRoute(string $method, string $url): bool{
        return isset($this->routes[$method]) && isset($this->routes[$method][$url]);
    }

    public function getCallbackOrFalse(string $method, string $url): RouteCallback | bool { 
        $method = $this->hydrateMethod($method); 
        if( ! $this->hasRoute($method, $url)){
            return false;
        }

        return $this->routes[$method][$url];
    }

    private function hydrateMethod(string $method): string{
        return strtoupper($method);
    }


}

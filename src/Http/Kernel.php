<?php
namespace Howest\Diy\Http;

use Howest\Diy\Routing\RouteHandler;

class Kernel{    

    private array $routes;

    public function __construct(){
        $this->routes = [];
    }

    public function handle(Request $request): Response {            
        $routeHandler = new RouteHandler($this->routes);    
        $response = $routeHandler->handle($request);    

        return $response;
 
    }

    public function addRoutes(array $routes): Kernel{
        foreach($routes as $prefix => $path){
            $this->routes[$prefix] = $path;
        }

        return $this;
    }
}


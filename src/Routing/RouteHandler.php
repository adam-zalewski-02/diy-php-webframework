<?php

namespace Howest\Diy\Routing;

use Exception;
use Howest\Diy\Http\Request;
use Howest\Diy\Http\Response;
use Howest\Diy\Routing\RouteCallback;

class RouteHandler
{

    private array $routes;

    public function __construct(array $routes)
    {

        $this->routes = $this->getPreparedRoutes($routes);
    }

    private function getPreparedRoutes(array $routes): array
    {
        $preparedRoutes = [];
        foreach ($routes as $prefix => $path) {
            $preparedRoutes[] = $this->getPreparedRoute($prefix, $path);
        }

        return $preparedRoutes;
    }

    private function getPreparedRoute(string $prefix, string $path): Route
    {
        // cfr. LARAVEL namespace Illuminate\Filesystem; => public function requireOnce($path, array $data = [])
        return (static function () use ($prefix, $path): Route {
            $route = new Route();

            $route->setPrefix($prefix);
            require_once $path;

            return $route;
        })();
    }

    public function handle(Request $request): Response
    {
        
        if (count($this->routes) === 0) {
            return new Response(Response::getStatusCodeMessage(404), 404);
        }

        $routeCallback = $this->getRouteCallback($request);        
        if(!$routeCallback){
            return new Response(Response::getStatusCodeMessage(404), 404);
        }

        return $this->executeRouteCallBack($routeCallback);
    }

    private function executeRouteCallBack(RouteCallback $routeCallback): Response{

        try{
            $data = $routeCallback->execute();
        
            return new Response($data, 200);      
        }catch(Exception $except){
            // log $except->getMessage();                        
        
            return new Response(Response::getStatusCodeMessage(500), 500);
        }  
    }

    private function getRouteCallback(Request $request): RouteCallback | false{
        $method = $request->method();
        $uri = $request->uriPath();

        $callback = false;
        $pointer = 0;
        while($this->noCallback($callback, $pointer)){
            $route = $this->routes[$pointer];
            $callback = $route->getCallbackOrFalse($method, $uri);    
                                  
            $pointer++;
        }

        return $callback;
    }

    private function noCallback(RouteCallback | bool $callback, int $pointer){
        return ! $callback && $pointer < count($this->routes);
    }

}



<?php 
namespace Howest\Diy\Routing;

use Exception;

class RouteCallback{

    // todo check for callable type
    private  $callback;

    public function __construct(string|callable $callback){
        $this->callback = $callback;
    }

     /**
     * @throws Exception
     */
    public function execute(): string|array|object {
               
        if(is_string($this->callback)){
            return $this->callControllerMethod($this->callback);            
        }
    
        return $this->callCallbackFunction($this->callback);         
    }

    public function isEmpty(): bool{
        return !($this->callback || trim($this->callback));
    }

     /**
     * @throws Exception
     */
    private function callControllerMethod($callback): string|array|object{
        $controllerParts = explode('@', $callback);
        if(count($controllerParts) !== 2){
            throw new Exception("Invalid controller method: " . $callback);
        }

        $data = $this->executeControllerMethod($controllerParts);
        return $data ??  "";
    }

     /**
     * @throws Exception
     */
    private function executeControllerMethod(array $controllerParts): string|array|object{
        $class = $controllerParts[0];
        $method = $controllerParts[1];

        if(!(class_exists($class) && method_exists($class, $method))){                           
            throw new Exception("Invalid controller method: " . $class . "@" . $method);
        }

        $controller = new $class();

        return $controller->$method();        
    }

    private function callCallbackFunction($callback): string|array|object {
        $data = $callback();
        return $data ??  "";
    }
}

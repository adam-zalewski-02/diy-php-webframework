<?php
namespace Howest\Diy\Http;

class Request{

    private $server;
    private $request;

    public function __construct(){
        $this->server = $_SERVER;
        $this->request = $this->sanitize($_REQUEST);
    }

    public function method(): string{
        return $this->server["REQUEST_METHOD"];
    }

    public function uri(): string{
        return $this->server["REQUEST_URI"];
    }

    public function uriPath(): string{
       $segments = explode("?", $this->server["REQUEST_URI"]);
       return $segments[0];
    }


    public function domain(): string{
        return $this->server["SERVER_NAME"];
    }


    public function parameters(): array{
        return $this->request;
    }

    public function parameter(string $key, string $default = ""): string{
        return $this->request[$key] ?? $default;
    }

    private function sanitize(array $request): array{
        $sanitized = [];
        foreach($request as $key => $value){
            $sanitized[$key] = htmlspecialchars($value);
        }
        return $sanitized;
    }

}

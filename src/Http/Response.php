<?php
namespace Howest\Diy\Http;

class Response{
    
    public const statusCodes = [
        200 => "200 OK",
        400 => "400 Bad Request",
        404 => "404 Not Found",
        500 => "500 Internal Server Error"
    ];

    private int $statusCode;
    private string|array|object $data;
    private string $contentType;

    public function __construct(string|array|object $data, int $statusCode = 200){
        $this->statusCode = $statusCode;
        $this->data = $data; 
        $this->setContentType($data);      
    }

    private function setContentType(string|array|object $data){
        $this->contentType = "text/html; charset=utf-8";
        if($this->isJson($data)){
            $this->contentType = "application/json; charset=utf-8";
        }
    }

    private function isJson($data): bool{
        return (is_array($data) || is_object($data));
    }

    public function send(): void{
        header("Content-Type: " . $this->contentType);
        header("HTTP/1.1 " . self::statusCodes[$this->statusCode]);

        $this->showData();
    }

    private function showData():void{
        if( ! $this->data){
            return;
        }

        if($this->isJson($this->data)){
            $this->data = json_encode($this->data);
        }

        print $this->data;        
    }
    
    // -- lame, but not topic of this demo
    public static function getStatusCodeMessage(int $statusCode): string{     
        return Response::statusCodes[$statusCode] ?? "500 - Unknown status code";
    }
}


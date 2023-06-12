<?php
require_once "../vendor/autoload.php";

use Howest\Diy\Http\Request;
use Howest\Diy\Http\Kernel;

$routes = [
    "" => "../routes/web.php",
    "api" => "../routes/api.php"
];

$request = new Request();

$kernel = new Kernel();
$response = $kernel
    ->addRoutes($routes)    
    ->handle($request);

$response->send();


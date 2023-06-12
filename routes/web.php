<?php 

// -- what we want to do

$route->get('/', function(): string{
    return "welcome<br/>";
});

$route->get('/about-me', "App\Controllers\AboutMeController@index");


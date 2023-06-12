<?php

// -- what we want to do

$route->get('/about-me', function(): void{
    print("in /about-me");
    return ["msg" => "your are awesome!"];
});


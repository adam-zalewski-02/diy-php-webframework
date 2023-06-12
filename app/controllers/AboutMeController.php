<?php namespace App\Controllers;

use Howest\Diy\Views\View;
use Howest\Diy\Http\Request;

final class AboutMeController {
    public function index(Request $request){
        $view = new View("aboutme", ["name" => $request->parameter("name", "unknown")]);
        return $view->render();
    }
}

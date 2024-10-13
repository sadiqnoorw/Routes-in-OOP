<?php
namespace App\Exception;

class RouteNotFoundException extends \Exception {
    
    public $message = "404 page not found";
}
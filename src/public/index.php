<?php

declare(strict_types=1);

/**
 * The entry point of the application.
 * 
 * This script sets up routing for the web application using the Router class.
 * It registers various routes and resolves the current request URI and method
 * to execute the corresponding controller action.
 */

// Autoload dependencies
require __DIR__ . "/../vendor/autoload.php";

use App\Router;

/**
 * Get the requested URL from the query string (or default to "/").
 * 
 * @var string $url The current request URI.
 */
$url = $_REQUEST["url"] ?? "/";

// Initialize the router
$route = new Router();

/**
 * Register GET and POST routes for the application.
 * 
 * - The '/' route points to the 'index' method of the Home class.
 * - The '/invoice' route points to the 'index' method of the Invoice class.
 * - The '/invoice/create' route handles both GET (form display) and POST (form submission).
 */
$route
    ->get("/", [App\Classes\Home::class, "index"])
    ->get("invoice", [App\Classes\Invoice::class, "index"])
    ->get("invoice/create", [App\Classes\Invoice::class, "create"])
    ->post('invoice/create', [App\Classes\Invoice::class, 'store']);

/**
 * Resolve the current request and execute the corresponding action.
 * 
 * @param string $url The current request URI.
 * @param string $requestMethod The HTTP request method (GET, POST, etc.).
 */
$action = $route->resolve($url, strtolower($_SERVER["REQUEST_METHOD"]));

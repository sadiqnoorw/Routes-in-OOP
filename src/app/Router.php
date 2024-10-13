<?php

namespace App;

use App\Exception\RouteNotFoundException;
/**
 * Class Router
 * 
 * A simple router class to register and resolve routes based on request methods.
 */
class Router
{
    /**
     * @var array $routes Stores all the registered routes.
     */
    private array $routes;

    /**
     * Registers a new route for a given request method.
     * 
     * @param string $requestMethod The HTTP method (e.g., 'get', 'post').
     * @param string $route The route URL pattern.
     * @param callable|array $action The action to be executed for the route, either a callback or a controller-method pair.
     * 
     * @return $this Returns the instance of the router to allow method chaining.
     */
    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    /**
     * Registers a GET route.
     * 
     * @param string $route The route URL pattern.
     * @param callable|array $action The action to be executed for the route.
     * 
     * @return $this Returns the instance of the router to allow method chaining.
     */
    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    /**
     * Registers a POST route.
     * 
     * @param string $route The route URL pattern.
     * @param callable|array $action The action to be executed for the route.
     * 
     * @return $this Returns the instance of the router to allow method chaining.
     */
    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    /**
     * Resolves the current request URI and method to execute the corresponding route action.
     * 
     * @param string $requestUri The current request URI.
     * @param string $requestMethod The HTTP method of the request.
     * 
     * @throws \RouteNotFoundException Thrown if the route is not found.
     */
    public function resolve(string $requestUri, string $requestMethod): void
    {
        /**
         * Fetch the action from the registered routes array based on the request method and URI.
         * If no action is found for the given route, it will return null.
         */
        $action = $this->routes[$requestMethod][$requestUri] ?? null;

        /**
         * If no action is found for the requested route, a RouteNotFoundException is thrown.
         */
        if (!$action) {
            throw new RouteNotFoundException();
        }

        /**
         * If the action is callable (i.e., a function or a closure), it is executed directly.
         */
        if (is_callable($action)) {
            call_user_func($action);
        }

        /**
         * If the action is an array, it assumes the format of [ClassName, method].
         * It will check if the class exists and then call the specified method.
         */
        if (is_array($action)) {
            [$class, $method] = $action;

            /**
             * Check if the class exists. If it does, create an instance of the class.
             */
            if (class_exists($class)) {
                $classInstance = new $class();

                /**
                 * Check if the specified method exists in the class.
                 * If it does, the method is called using call_user_func_array.
                 */
                if (method_exists($classInstance, $method)) {
                    call_user_func_array([$classInstance, $method], []);
                }
            }
        }
    }
}

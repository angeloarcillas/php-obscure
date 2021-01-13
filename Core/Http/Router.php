<?php
namespace Core\Http;

use Exception;

class Router
{
    private $host = "php-obscure"; // (OPTIONAL)
    private $controllerNamespace = "App\\Controllers\\";
    private $validMethods = ['GET','POST'];
    private $routes = [
        'GET' => [],
        'POST' => []
    ];
    private $params = null;

    /**
     * Start buffer
     */
    public function __construct()
    {
        ob_start();
    }

    /**
     * Unset $routes and $params
     * then flush buffer
     */
    public function __destruct()
    {
        unset($this->routes);
        unset($this->params);
        ob_end_flush();
    }

    /**
     * Instance router then set routes
     *
     * @param string $file
     * @return object
     */
    public static function load(string $file): object
    {
        $router = new static; // create object
        require $file; // set routes
        return $router; // return object
    }

    /**
     * Set GET routes
     *
     * @param string $uri
     * @param $controller
     */
    private function get(string $uri, $controller)
    {
        $uri = trim($this->host.$uri, '/');
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Set POST routes
     *
     * @param string $uri
     * @param string $controller
     */
    private function post(string $uri, $controller)
    {
        $uri = trim($this->host.$uri, '/');
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * process route
     *
     * @param string $uri
     * @param string $method
     */
    public function direct(string $uri, string $method)
    {
        // validate request method
        if (!$this->isValidMethod(strtoupper($method))) {
            throw new Exception("Invalid request method");
        }

        // loop through routes
        foreach ($this->routes[$method] as $route => $controller) {

            // check for wildcards
            if (strpos($route, '{')) {

                // set pattern for wildcards
                $pattern = preg_replace('/{([\w]+)}/', '(\w+)', $route);

                // match route
                if (preg_match('/^' . str_replace('/', '\/', $pattern) . '$/', $uri, $values)) {
                    // get all route wildcards
                    preg_match_all('/{(\w+)}/', $route, $keys);
                    // set parameter keys
                    $key = array_pop($keys);
                    // set parameter keys value
                    $value = array_splice($values, 1);
                    // set parameters
                    $this->params = array_combine($key, $value);
                } else {
                    // continue if route with wildcard and URI didnt match
                    continue;
                }
            } else {
                // continue if route and URI didnt match
                if ($uri !== $route) {
                    continue;
                }
            }

            // call function if controller is callable
            if (is_callable($controller)) {
                $controller($this->params);
                exit;
            }

            // call controller
            return $this->callAction(
                ...explode('@', $controller)
            );
        }

        throw new Exception("No routes defined for this url");
    }


    /**
     * Validate if request method is valid
     * @param string $method
     * @return bool
     */
    private function isValidMethod(string $method): bool
    {
        return in_array($method, $this->validMethods, true);
    }

    /**
     * execute action
     *
     * @param string $controller
     * @param string $action
     */
    private function callAction(string $controller, string $action)
    {
        // set class namspace
        $class = $this->controllerNamespace . $controller;

        // check if class exist
        if (! class_exists($class)) {
            throw new Exception("No Class defined for this Controller.");
        }

        // create object
        $object = new $class;

        // check if method exist
        if (! method_exists($object, $action)) {
            throw new Exception("No Method defined for this Class.");
        }

        // call method from class
        return $object->$action($this->params);
    }
}

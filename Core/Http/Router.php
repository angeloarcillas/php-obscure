<?php
namespace Core\Http;

use Exception;

class Router
{
    private $host = "php-obscure"; // (OPTIONAL)
    protected $controllerNamespace = "App\\Controllers\\";
    protected $validMethods = ['GET', 'POST', 'PUT', 'DELETE'];
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
    ];
    protected $params = [];

    protected $patterns = [
        ':int' => '([0-9]+)',
        ':str' => '([a-zA-Z]+)',
        ':any' => '(.*)',
    ];

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
        $router = new static; // create instance
        require $file; // set routes
        return $router; // return instace
    }

    /**
     * Set GET routes
     *
     * @param string $uri
     * @param $controller
     */
    protected function get(string $uri, $controller)
    {
        $uri = trim($this->host . $uri, '/');
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Set POST routes
     *
     * @param string $uri
     * @param string $controller
     */
    protected function post(string $uri, $controller)
    {
        $uri = trim($this->host . $uri, '/');
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Set PUT/PATCH routes
     *
     * @param string $uri
     * @param string $controller
     */
    protected function put(string $uri, $controller)
    {
        $uri = trim($this->host . $uri, '/');
        $this->routes['PUT'][$uri] = $controller;
    }

    /**
     * Set DELETE routes
     *
     * @param string $uri
     * @param string $controller
     */
    protected function delete(string $uri, $controller)
    {
        $uri = trim($this->host . $uri, '/');
        $this->routes['DELETE'][$uri] = $controller;
    }

    /**
     * process route
     *
     * @param string $uri
     * @param string $method
     */
    public function direct(string $uri, string $method)
    {
        $method = $_POST['_method'] ?? $method;
        // dd($method);

        // validate request method
        if (!$this->isValidMethod(strtoupper($method))) {
            throw new Exception("Invalid request method");
        }

        // loop through routes
        foreach ($this->routes[$method] as $route => $controller) {

            // check for wildcards
            if (str_contains($route, ':')) {

                $searches = array_keys($this->patterns);
                $replaces = array_values($this->patterns);
                $regex = '#^' . str_replace($searches, $replaces, $route) . '$#';

                if (preg_match($regex, $uri, $values)) {
                    $this->params = array_slice($values, 1);
                } else {
                    continue; // next loop
                }
            } else {
                // continue if route and URI didnt match
                if ($uri !== $route) {
                    continue;
                }
            }

            // call function if controller is callable
            if (is_callable($controller)) {
                $controller(...$this->params);
                exit;
            }

            // call controller
            return $this->callAction($controller);
        }

        return redirect("$this->host/404");

        // throw new Exception("No routes defined for this url");
    }

    /**
     * Validate if request method is valid
     * @param string $method
     * @return bool
     */
    protected function isValidMethod(string $method): bool
    {
        return in_array($method, $this->validMethods, true);
    }

    /**
     * execute action
     *
     * @param string $controller
     * @param string $action
     */
    protected function callAction(string $controller)
    {
        // set controller and action
        [$controller, $action ] = [...explode('@',$controller), null];
        // set class namspace
        $class = $this->controllerNamespace . $controller;

        // check if class exist
        if (!class_exists($class)) {
            throw new Exception("Controller: \"{$class}\" doesn't exists.");
        }

        // create object
        $object = new $class();

        // call class _invoke()
        if (!$action && is_callable($object)) return $object();

        // check if method exist
        if (!method_exists($object, $action)) {
            $action = $action ?? '__invoke';
            throw new Exception("Method: \"{$action}()\" is not defined on {$class}.");
        }

        // call method from class
        return $object->$action(...$this->params);
    }

    // redirect()->back();
    public function back()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("location: {$_SERVER['HTTP_REFERER']}", true, 302);
        }

        return null;
    }
}

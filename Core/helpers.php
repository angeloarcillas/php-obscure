<?php

/**
 * Require a view.
 *
 * @param  string $path
 * @param  array  $data
 */
if (!function_exists("view")) {
    function view(string $path, array $data = [])
    {
        // convert array to variable
        extract($data);

        // convert users.create to users/create
        $realSubPath = str_replace('.', '/', e($path));

        // path of file to rquire
        $realPath = "App/Views/{$realSubPath}.view.php";

        // require file
        return require_once $realPath;
    }
}

/**
 * Return file from assets folder
 *
 * @param string $path
 */
if (!function_exists("assets")) {
    function assets(string $path)
    {
        return 'App/Assets/' . e($path);
    }
}

/**
 * Redirect to new Page
 *
 * @param null|string $path
 * @param int $status
 * @param array $headers
 */
if (!function_exists('redirect')) {
    function redirect(
        ?string $path = null, // path to redirect
        int $status = 302, // http status code
        array $headers = [] // additional request headers
    ) {
        // check if no $path
        if (!$path) {
            // return Router class
            return new \Core\Http\Router();
        }

        // check if headers already sent
        if (headers_sent() === false) {
            // loop headers
            foreach ($headers as $header) header($header);

            // convert user.settings to user/settings
            $realSubPath = str_replace('.', '/', e($path));
            // trim excess forward slash
            $realPath = '/' . trim($realSubPath, '/');
            // redirect
            header("location:{$realPath}", true, $status);
            exit;
        }

        return false;
    }
}

/**
 * Get all request
 *
 * @param null|string $key
 *
 * @return array|string
 */
if (!function_exists("request")) {
    function request(?string $key = null)
    {
        // create Request instance
        $request = new \Core\Http\Request();

        // return request or request class
        return $key ?  $request->$key : $request;
    }
}

/**
 * Set csrf token
 */
if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        // check if token already set
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32)); // hash
            $_SESSION["csrf_lifespan"] = time() + 3600; // +60 minutes
            return $_SESSION["csrf_token"];
        }

        // return existing token
        // usable for one or more csrf field
        return $_SESSION["csrf_token"];
    }
}

/**
 * Create csrf field
 *
 * @return string
 */

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        return '<input
            type="hidden"
            name="_csrf"
            value="'. csrf_token() .'"
        >';
    }
}

/**
 * Create method field
 *
 * @return string
 */

if (!function_exists('method_field')) {
    function method_field(string $method)
    {
        return '<input
            type="hidden"
            name="_method"
            value="'. e($method) .'"
        >';
    }
}

/**
 * Encode string
 *
 * @param string $string
 */
if (!function_exists("e")) {
    function e(string $string)
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}

/**
 * Throw new exception
 *
 * @param string $msg
 */
if (!function_exists("error")) {
    function error(string $msg)
    {
        throw new \Exception($msg);
    }
}

/**
 * Die  and dump
 */
if (!function_exists("dd")) {
    function dd(...$params)
    {
        die(var_dump($params));
    }
}

/**
 * Get/set/delete session
 *
 * @return mixed
 */
if (!function_exists('session')) {

    function session(string|array $property, bool $delete = false)
    {
        // delete session
        if ($delete && is_string($property)) {
            unset($_SESSION[$property]);
            return true;
        }

        // set session
        if (is_array($property)) {
            // set session key
            $key = array_keys($property)[0];
            // set session value
            $_SESSION[$key] = $property[$key];
            return true;
        }

        // if key doesnt exists
        if (!isset($_SESSION[$property])) {
            $_SESSION['errors'] = "{$property} doesn't exists.";
            return false;
        }

        // get session
        return $_SESSION[$property];
    }
}

/**
 * Include component
 */
if (!function_exists('render')) {
    function render(string $path, array $data = [])
    {
        // convert array to variable
        extract($data);

        // convert users.create to users/create
        $realSubPath = str_replace('.', '/', $path);
        // path of file to require
        $realPath = "App/Views/{$realSubPath}.view.php";
        // require file
        return require_once $realPath;
    }
}

/**
 * Verify CSRF token
 */

if (!function_exists('verifyCsrf')) {
    function verifyCsrf(string $hash)
    {
        // check if csrf token exists
        if (!isset($_SESSION['csrf_token'])) return false;

        // check if csrf token exired
        $expired = $_SESSION['csrf_lifespan'] < time();

        // compare csrf token and csrf field
        $matched = hash_equals($_SESSION['csrf_token'],  $hash);

        if ($expired || !$matched) {
            $_SESSI['error'] = 'csrf token didnt match.';
            return redirect()->back();
        };

        // remove csrf sessions
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_lifespan']);

        // csrf token and csrf field matched
        return true;
    }
}

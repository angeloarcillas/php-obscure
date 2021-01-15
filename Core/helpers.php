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
        extract($data); // array to variable

        return require 'App/Views/' . str_replace('.', '/', e($path)) . '.view.php';
    }
}

/**
 * Return file from assets folder
 */
if (!function_exists("assets")) {
    function assets(string $path)
    {
        return 'App/Assets/' . e($path);
    }
}

/**
 * Redirect to new Page
 */
if (!function_exists('redirect')) {
    function redirect(?string $to = null, int $status = 302, array $headers = [])
    {
        if (!$to) {
            return new \Core\Http\Router();
        }

        // loop headers
        foreach ($headers as $header) {
            header($header);
        }

        // redirect
        header('location:/' .
            trim(str_replace('.', '/', e($to)), '/'),
            true,
            $status);

        exit;
    }
}

/**
 * Get all request
 *
 * @return array|string
 */
if (!function_exists("request")) {
    function request(?string $key = null)
    {
        // create request instance
        $request = new \Core\Http\Request();

        if (!$key) {
            return $request;
        }

        // return request $attribute[$key]
        return $request->$key;
    }
}

/**
 * Set csrf token
 */
if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
            $_SESSION["csrf_lifespan"] = time() + 3600;
            return $_SESSION["csrf_token"];
        }

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
        return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
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
        return '<input type="hidden" name="_method" value="' . $method . '">';
    }
}

/**
 * Encode string
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

    function session(string | array | object $x, bool $delete = false)
    {

        // session($key, true) | delete session
        if ($delete) {
            unset($_SESSION[$x]);
            return;
        }
        // session([$key => $value]) | set session
        if (is_array($x)) {
            $key = array_keys($x)[0];
            $_SESSION[$key] = $x[$key];
            return;
        }

        // if key doesnt exist
        if (!isset($_SESSION[$x])) {
            return false;
        }

        // session($key) | get session
        return $_SESSION[$x];
    }
}

if (!function_exists('render')) {
    function render(string $path, array $data = [])
    {
        extract($data);
        return require_once 'App/Views/' . str_replace('.', '/', $path) . '.view.php';
    }
}

if (!function_exists('verifyCsrf')) {
    function verifyCsrf(string $hash)
    {
        if ($_SESSION['csrf_lifespan'] < time()
                || !hash_equals(session('csrf_token'), $hash)
            ) {
            session(['error' => 'csrf token didnt match.']);
            return redirect()->back();
        };

        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_lifespan']);
        return;
    }
}

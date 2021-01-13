<?php

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 */
if (!function_exists("view")) {
    function view(string $name, array $data = [])
    {
        extract($data); // array to variable

        return require "App/Views/{$name}.view.php";
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
    function redirect(string $to, int $status = 302, array $headers = [])
    {
        // loop headers
        foreach ($headers as $header) {
            header($header);
        }

        // redirect
        header('location:/' . trim($to, "/"), true, $status);
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
        // retrieve $_REQUEST
        $request = \Core\Http\Request::request();

        if (!$key) {
            return (object) $request;
        }
        // return all request as object

        if (array_key_exists($key, $request)) {
            return $request[$key];
        }
        // return request

        error("Request key doesnt exist");
    }
}

/**
 * Set csrf token
 */
if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        $_SESSION["csrf_lifespan"] = time() + 3600;
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
function session(string | array $x, bool $delete = false)
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

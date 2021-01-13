<?php
namespace Core\Http;

use Exception;

class Request
{
    /**
     * @return string Request url w/out ?(Query string)
     */
    public static function uri(): string
    {
      return reset(...[explode('?',
        trim($_SERVER['REQUEST_URI'], '/')
      )]);
    }

    /**
     * @return string Request method
     */
    public static function method(): string
    {
      return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string Request variables
     */
    public static function request(): array
    {
      if (empty($_REQUEST))
          throw new Exception("Empty request");

      return array_map(function ($request) {
          return strip_tags(htmlspecialchars($request));
      }, $_REQUEST);
    }

    /**
     * @return mixed GET request
     */
    public static function query(?string $key = null)
    {
      if (!$key)
          return $_GET;

      if (array_key_exists($key, $_GET))
          return $_GET[$key];

      throw new Exception("Query {$key} doesnt exist");
    }
}

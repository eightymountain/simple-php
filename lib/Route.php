<?php

namespace Lib;

use BadMethodCallException;

/**
 * Class Route
 * @package Lib
 */
class Route
{
    private const CONTROLLER_PATH = 'App\\';
    private const STRING_REGEX = '[0-9aA-zZ]{1,}';
    private const INT_REGEX = '[0-9]{1,}';

    private static array $whiteMethod = ['get', 'post'];
    private static array $routes = [];

    public static function get($path, $function, $string = false)
    {
        self::add($path, $function, 'get', $string);
    }

    public static function post($path, $function, $string = false)
    {
        self::add($path, $function, 'post', $string);
    }

    private static function add($path, $function, $method, $string)
    {
        array_push(self::$routes, ['path' => $path, 'function' => $function, 'method' => $method, 'string' => $string]);
    }

    public static function run()
    {
        $parseUrl = parse_url($_SERVER['REQUEST_URI']);
        $pageName = $parseUrl['path'];
        $err = 404;

        foreach (self::$routes as $route) {
            self::changePath($route);

            // path가 등록되어있는지 확인
            if (preg_match($route['path'], $pageName)) {
                $method = strtolower($_SERVER['REQUEST_METHOD']);
                // http method 허용 확인
                if ( ! in_array($method, self::$whiteMethod) || $method !== strtolower($route['method'])) {
                    $err = 405;
                    continue;
                }

                list($clazz, $func) = explode('@', $route['function']);
                $clazz = str_replace('/', '\\', $clazz);
                $clazz = self::CONTROLLER_PATH . $clazz;

                $clazz = new $clazz();
                if (method_exists($clazz, $func) && is_callable([$clazz, $func])) {
                    $rs = call_user_func(array(new $clazz(), $func), chkParams($method === 'get' ? $_GET : $_POST));
                    if ( ! is_null($rs) && ctype_print($rs)) {
                        echo $rs;
                    }
                    $err = 0;
                    break;
                } else {
                    throw new BadMethodCallException(sprintf('function does not exist => %s', $route['function']));
                }
            }
        }

        if ($err !== 0) {
            self::error($err);
            exit;
        }
    }

    private static function changePath(&$route)
    {
        $route['oriPath'] = '';

        if (preg_match('/\{(.*?)\}/', $route['path'])) {
            $route['oriPath'] = $route['path'];

            if ($route['string']) {
                $route['path'] = preg_replace('/\{(.*?)\}/', self::STRING_REGEX, $route['path']);
            } else {
                $route['path'] = preg_replace('/\{(.*?)\}/', self::INT_REGEX, $route['path']);
            }
        }

        $route['path'] = '#^' . $route['path'] . '$#';
    }

    private static function error($state)
    {
        switch ($state) {
            case 400 :
                $msg = 'Bad Request';
                break;
            case 404 :
                $msg = 'Page Not Found';
                break;
            case 405 :
                $msg = 'Method Not Allowed';
                break;
            case 403 :
                $msg = 'Forbidden';
                break;
            case 401 :
                $msg = 'Unauthorized';
                break;
            default:
                $msg = '';
        }
        http_response_code($state);
        echo $msg;
    }
}

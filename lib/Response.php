<?php


namespace Lib;


class Response
{
    public static function json($data, $msg = '', $success = true, $httpStatusCode = 200)
    {
        header('Content-Type: application/json; charset=UTF-8');
        header("Access-Control-Allow-Origin: *");
        header('Accept-Encoding: gzip, deflate');
        header('Pragma: no-cache');
        header('Expires: 0');
        http_response_code($httpStatusCode);

        return json_encode(
            [
                'success' => $success,
                'data' => $data,
                'message' => $msg,
            ]
        );
    }

    public static function view($viewFileName, $vars=null)
    {
        if(!is_null($vars)){
            extract($vars);
        }


        $path = str_replace('/', DIRECTORY_SEPARATOR, $viewFileName);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

        require __ROOT__ . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $path;

        return true;
    }
}
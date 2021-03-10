<?php

namespace App;

use Exception;
use Lib\Route;

class Router
{
    public static function boot()
    {
        try {

            Route::get('/json/response', 'ExampleController@jsonResponse');
            Route::get('/view/response', 'ExampleController@viewResponse');
            Route::get('/', 'MainController@index');

            Route::run();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

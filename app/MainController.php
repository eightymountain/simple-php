<?php

namespace App;

use Lib\Response;

class MainController
{
    public function index($request)
    {
        return Response::view('/main.php');
    }
}

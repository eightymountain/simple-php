<?php

namespace App;

use Lib\Response;

class ExampleController extends Controller implements InterfaceCRUD
{
    public function jsonResponse($request)
    {
        return Response::json($request, 'test1');
    }

    public function viewResponse($request)
    {
        return Response::view('/example/view.php', ['name' => 'david', 'age' => 17]);
    }

    public function insert($request)
    {
    }
    public function update($request)
    {
    }
    public function delete($request)
    {
    }
    public function select($request)
    {
    }
}

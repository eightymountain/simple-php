<?php


namespace App;


interface InterfaceCRUD
{
    public function insert($request);
    public function update($request);
    public function delete($request);
    public function select($request);
}
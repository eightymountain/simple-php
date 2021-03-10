<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set("display_errors", '1');

define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

require __ROOT__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Router;
use Dotenv\Dotenv;

$env = Dotenv::createImmutable(__ROOT__);
$env->load();

require __ROOT__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'helper.php';

session_start();

Router::boot();
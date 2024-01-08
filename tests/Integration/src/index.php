<?php
declare(strict_types = 1);

use Gratis\Framework\Router\Router;
use Gratis\Tests\Integration\src\Controllers\EchoController;
use Gratis\Tests\Integration\src\Middlewares\HeaderValidatorMiddleware;

require_once __DIR__ . "/../../../vendor/autoload.php";

$router = new Router();

$router->register_middleware(new HeaderValidatorMiddleware("X-Validation-Header", "test",));
$router->get("/hello-world", new EchoController("Hello World"));

$router->serve_app(__DIR__ . "/View", __DIR__ . "/View/index.html");

$router->dispatch();
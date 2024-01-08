<?php
declare(strict_types = 1);

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use Gratis\Framework\Router\Router;
use Gratis\Framework\Router\IMiddlewareHandler;
use JetBrains\PhpStorm\NoReturn;

require_once __DIR__ . "/../../../vendor/autoload.php";

session_start();

$router = new Router();

$router->patch("/", new class implements IRequestHandler {

    #[NoReturn] #[Override]
    public function handle_request(Request $req, Response $res): void
    {
        $res->set_status_code(200);
    }
});

$router->dispatch();
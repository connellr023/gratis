<?php
declare(strict_types = 1);

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use Gratis\Framework\Router\Router;
use Gratis\Framework\Router\IMiddlewareHandler;

require_once __DIR__ . "/../vendor/autoload.php";

session_start();

$router = new Router();

//$router->register_middleware(
//    new class implements IMiddlewareHandler
//{
//    #[\Override]
//    public function handle_middleware(Request $req, Response $res, Closure $next): Response
//    {
//        echo $res->get_final_route();
//
//        return $res;
//    }
//});

$router->serve_app(__DIR__ . "/Build");

//$router->patch("/Build", new class implements IRequestHandler {
//
//    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
//    public function handle_request(Request $req, Response $res): void
//    {
//        $res->delete_cookie("Build");
//
//        $res->send_content("Patch Request");
//    }
//});

//$router->get("{/(.*)/}", new class implements IRequestHandler {
//
//    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
//    public function handle_request(Request $req, Response $res): void
//    {
//        $res->send_content("<h1>404</h1>");
//    }
//});

$router->dispatch();
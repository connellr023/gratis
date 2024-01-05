<?php
declare(strict_types = 1);

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use Gratis\Framework\Router\Router;
use Gratis\Framework\Router\IMiddlewareHandler;

require_once __DIR__ . "/../vendor/autoload.php";

$router = new Router();

$router->register_middleware(
    new class implements IMiddlewareHandler
{
    #[\Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        //$res->redirect("/getter");
        //$res->set_status_code(404);
        //$res->set_headers("Content-type:application/pdf");
        $next($req, $res);

        return $res;
    }
}, new class implements IMiddlewareHandler
{
    #[\Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        //$res->redirect("/");
        //$res->set_status_code(\Gratis\Framework\HTTP\Status::OK);
        $next($req, $res);

        return $res;
    }
});

$router->get("/", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        echo $req->get_route_accessed() . "\n";
        echo $res->get_final_route() . "\n";

        die("<h1>root page</h1>");
    }
});

$router->patch("/test", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        die("patch");
    }
});

$router->get("/getter", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        die("get");
    }
});

$router->get("{/\A\/test/}", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        echo "val: " . $req->get_from_url_body("test");
        die("<h1>test</h1>");
    }
});


$router->get("{/(.*)/}", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        die("<h1>404</h1>");
    }
});

$router->dispatch();
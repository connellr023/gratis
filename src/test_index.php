<?php
declare(strict_types = 1);

use Gratis\Framework\Router\Router;
use Gratis\Framework\IRequestHandler;
use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;

require_once __DIR__ . "/../vendor/autoload.php";

$router = new Router();

$router->get("/", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        var_dump($req->get_url_body());
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
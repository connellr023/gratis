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

$router->register_middleware(
    new class implements IMiddlewareHandler
{
    #[\Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        var_dump($req->get_from_session("login"));
        //$res->redirect("/getter");
        //$res->set_status_code(404);
        //$res->set_headers("Content-type:application/pdf");
        $res->append_content("<br />M1<br />");
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
        $res->append_content("M2<br />");
        $next($req, $res);

        return $res;
    }
});

$router->get("/", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        $res->set_cookie("test", "balls", 3600, same_site: "Lax");

        echo $req->get_route_accessed();
        echo $res->get_final_route();

        $res->send_content("<h1>Root Page</h1>");
    }
});

$router->patch("/test", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        $res->delete_cookie("test");

        $res->send_content("Patch Request");
    }
});

$router->get("/getter", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        //$res->update_session("login", true);
        $res->update_session("login", true);
        $res->send_content("<h1>Test Get Page</h1>");
    }
});

$router->get("{/\A\/test/}", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        $res->update_session("login", false);
        echo "val: " . $req->get_from_url_body("test");
        $res->send_content("<h1>Test Page</h1>");
    }
});


$router->get("{/(.*)/}", new class implements IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(Request $req, Response $res): void
    {
        $res->send_content("<h1>404</h1>");
    }
});

$router->dispatch();
<?php
declare(strict_types = 1);

use Gratis\Framework\Router\Router;
use Gratis\Tests\Integration\src\Controllers\EchoController;
use Gratis\Tests\Integration\src\Middlewares\HeaderValidatorMiddleware;

require_once __DIR__ . "/../../../vendor/autoload.php";

$router = new Router();

$hello_world_controller = new EchoController("Hello World");
$header_validator_middleware = new HeaderValidatorMiddleware("X-Validation-Header", "test");

$router->register_middleware($header_validator_middleware);

$router->get("/hello-world-get", $hello_world_controller);
$router->post("/hello-world-post", $hello_world_controller);
$router->patch("/hello-world-patch", $hello_world_controller);
$router->put("/hello-world-put", $hello_world_controller);
$router->delete("/hello-world-delete", $hello_world_controller);

$router->serve_app(__DIR__ . "/View", __DIR__ . "/View/index.html");

$router->dispatch();

$router->register_middleware(new class implements \Gratis\Framework\Router\IMiddlewareHandler {

    #[\Override]
    public function handle_middleware(\Gratis\Framework\HTTP\Request $req, \Gratis\Framework\HTTP\Response $res, Closure $next): \Gratis\Framework\HTTP\Response
    {
        // TODO: Implement handle_middleware() method.
    }
});
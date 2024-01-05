<?php
declare(strict_types = 1);

require_once __DIR__ . "/../vendor/autoload.php";

$router = new \Gratis\Framework\Router\Router();

$router->get("/", new class implements \Gratis\Framework\IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(array $request): void
    {
        die("<h1>root page</h1>");
    }
});

$router->patch("/test", new class implements \Gratis\Framework\IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(array $request): void
    {
        die("patch");
    }
});

$router->get("/getter", new class implements \Gratis\Framework\IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(array $request): void
    {
        var_dump($_GET);
        die("get");
    }
});

$router->get("{/\A\/test/}", new class implements \Gratis\Framework\IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(array $request): void
    {
        die("<h1>test</h1>");
    }
});

$router->dispatch();
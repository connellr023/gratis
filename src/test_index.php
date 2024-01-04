<?php
declare(strict_types = 1);

require_once __DIR__ . "/../vendor/autoload.php";

$router = new \Gratis\Framework\Routing\Router();

$router->post("/", new class implements \Gratis\Framework\IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(array $request): void
    {
        echo "post";
    }
});

$router->patch("/test", new class implements \Gratis\Framework\IRequestHandler {

    #[\JetBrains\PhpStorm\NoReturn] #[\Override]
    public function handle_request(array $request): void
    {
        echo "patch";
    }
});

$router->dispatch();
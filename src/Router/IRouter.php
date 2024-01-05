<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

use Gratis\Framework\IRequestHandler;

/**
 * Defines a contract of functions a basic router should implement
 * @author Connell Reffo
 */
interface IRouter
{
    public function get(string $route, IRequestHandler $handler): void;

    public function post(string $route, IRequestHandler $handler): void;

    public function patch(string $route, IRequestHandler $handler): void;

    public function put(string $route, IRequestHandler $handler): void;

    public function delete(string $route, IRequestHandler $handler): void;

    public function dispatch(): void;
}
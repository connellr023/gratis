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
    /**
     * Triggers a request handler registered to a route when a `GET` request is received
     * @param string $route The route accessed
     * @param IRequestHandler $handler The handler to be called
     * @return void
     */
    public function get(string $route, IRequestHandler $handler): void;

    /**
     * Triggers a request handler registered to a route when a `POST` request is received
     * @param string $route The route accessed
     * @param IRequestHandler $handler The handler to be called
     * @return void
     */
    public function post(string $route, IRequestHandler $handler): void;

    /**
     * Triggers a request handler registered to a route when a `PATCH` request is received
     * @param string $route The route accessed
     * @param IRequestHandler $handler The handler to be called
     * @return void
     */
    public function patch(string $route, IRequestHandler $handler): void;

    /**
     * Triggers a request handler registered to a route when a `PUT` request is received
     * @param string $route The route accessed
     * @param IRequestHandler $handler The handler to be called
     * @return void
     */
    public function put(string $route, IRequestHandler $handler): void;

    /**
     * Triggers a request handler registered to a route when a `DELETE` request is received
     * @param string $route The route accessed
     * @param IRequestHandler $handler The handler to be called
     * @return void
     */
    public function delete(string $route, IRequestHandler $handler): void;

    /**
     * Starts listening for requests and dispatches requests
     * to the appropriate request handler
     * @return void
     */
    public function dispatch(): void;
}
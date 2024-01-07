<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

/**
 * Defines a contract of functions a basic router can carry out
 * @author Connell Reffo
 */
interface IRouter
{
    /**
     * Registers middleware handlers to this router
     * @param IMiddlewareHandler ...$handlers A sequence of middleware handlers to be registered
     * @return void
     */
    public function register_middleware(IMiddlewareHandler ...$handlers): void;

    /**
     * Registers request listener(s) to a supplied request method and route <br />
     * Routes must follow the following format: `/example/route`
     * @param string $method The request method to listen for
     * @param string $route The route to listen for
     * @param IRequestHandler $handler The request handlers to be registered
     * @return void
     */
    public function register_route(string $method, string $route, IRequestHandler $handler): void;

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
}
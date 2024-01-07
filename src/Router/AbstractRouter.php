<?php

namespace Gratis\Framework\Router;

use Override;

/**
 * Abstract specification of a general router class
 * @author Connell Reffo
 */
abstract class AbstractRouter implements IRouter
{
    /**
     * @var IMiddlewareHandler[] An array of middleware handlers to be triggered on request
     */
    protected array $middleware_handlers;

    /**
     * @var array An associate array. Structured as follows: <br />
     * [
     *  (method) => [
     *    (route) => IRequestHandler
     *  ]
     * ]
     */
    protected array $request_handlers;

    /**
     * Router constructor
     */
    public function __construct()
    {
        $this->middleware_handlers = [];
        $this->request_handlers = [];
    }

    /**
     * Static utility method for ensuring routes do not end with "/"
     * @param string $route The route to be sanitized
     * @return string The sanitized route string
     */
    public static function sanitize_route_string(string $route): string
    {
        if (strlen($route) > 1) {
            return rtrim(preg_replace("#/+#", "/", $route), "/");
        }

        return "/";
    }

    #[Override]
    public function register_middleware(IMiddlewareHandler ...$handlers): void
    {
        $this->middleware_handlers = array_merge($this->middleware_handlers, $handlers);
    }

    /**
     * If a "/" character is added to the end, it will be removed <br />
     * In place of a route, a regular expression may also be
     * provided for more advanced route matching <br />
     * Regular expressions must be in the following form: `{<exp>}` <br />
     * <b>NOTE:</b> Delimiting "/" characters must be included within the braces
     */
    #[Override]
    public function register_route(string $method, string $route, IRequestHandler $handler): void
    {
        $route = self::sanitize_route_string($route);

        $this->request_handlers[$method] ??= [];
        $this->request_handlers[$method][$route] ??= [];
        $this->request_handlers[$method][$route] = $handler;
    }

    #[Override]
    public function get(string $route, IRequestHandler $handler): void
    {
        $this->register_route("GET", $route, $handler);
    }

    #[Override]
    public function post(string $route, IRequestHandler $handler): void
    {
        $this->register_route("POST", $route, $handler);
    }

    #[Override]
    public function patch(string $route, IRequestHandler $handler): void
    {
        $this->register_route("PATCH", $route, $handler);
    }

    #[Override]
    public function put(string $route, IRequestHandler $handler): void
    {
        $this->register_route("PUT", $route, $handler);
    }

    #[Override]
    public function delete(string $route, IRequestHandler $handler): void
    {
        $this->register_route("DELETE", $route, $handler);
    }

    /**
     * Starts listening for requests and dispatches requests
     * to the appropriate middleware and request handler(s)
     * @return void
     */
    public abstract function dispatch(): void;
}
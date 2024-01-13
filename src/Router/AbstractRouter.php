<?php

namespace Gratis\Framework\Router;

use Gratis\Framework\Utility;
use Override;

/**
 * Abstract specification of a general router class
 * @author Connell Reffo
 */
abstract class AbstractRouter implements IRouter
{
    /**
     * Pattern used for checking if a route string should be a regex route <br />
     * `< (exp) >`
     */
    protected const string REGEX_ROUTE_PATTERN = "~<\s+([^>]+)\s+>~";

    /**
     * @var IMiddlewareHandler[] An array of middleware handlers to be triggered on request
     */
    protected array $middleware_handlers;

    /**
     * @var array An associative array of request handlers that
     *            listen for routes that can be directly mapped
     */
    protected array $mappable_request_handlers;

    /**
     * @var array An associative array of request handlers that
     *            listen for routes that are a regular expression
     */
    protected array $regex_request_handlers;

    /**
     * Base constructor
     */
    public function __construct()
    {
        $this->middleware_handlers = [];
        $this->mappable_request_handlers = [];
        $this->regex_request_handlers = [];
    }

    /**
     * Helper method for extracting the RegExp enclosed between angle braces when registering routes
     * @param string $route The regex route to extract the inner regex from
     * @return string|false The extracted regex string or false if failed
     */
    protected static function extract_regex_from_route(string $route): string|false
    {
        return (preg_match(self::REGEX_ROUTE_PATTERN, $route, $matches) && isset($matches[1])) ? $matches[1] : false;
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
        $route = Utility::sanitize_route_string($route);

        if ($regex = self::extract_regex_from_route($route)) {
            $this->regex_request_handlers[$method] ??= [];
            $this->regex_request_handlers[$method][$regex] ??= [];
            $this->regex_request_handlers[$method][$regex] = $handler;
        }
        else {
            $this->mappable_request_handlers[$method] ??= [];
            $this->mappable_request_handlers[$method][$route] ??= [];
            $this->mappable_request_handlers[$method][$route] = $handler;
        }
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
     *
     * Request handlers should only be triggered if the middleware
     * handlers produce a successful HTTP status code
     * @return void
     */
    public abstract function dispatch(): void;
}
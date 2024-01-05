<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\IRequestHandler;

/**
 * Handles routes by use of request handlers
 * @author Connell Reffo
 */
class Router implements IRouter
{
    /**
     * @var string[] An array of commonly used HTTP request methods
     */
    private const array METHODS = [
        "GET",
        "POST",
        "PATCH",
        "PUT",
        "DELETE"
    ];

    /**
     * @var array An associate array. Structured as follows: <br />
     * [
     *  (method) => [
     *    (route) => IRequestHandler
     *  ]
     * ]
     */
    private array $handlers;

    /**
     * Router constructor
     */
    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * Registers request listener(s) to a supplied request method and route <br />
     * Routes must follow the following format: `/example/route` <br />
     * If a "/" character is added to the end, it will be removed <br />
     * In place of a route, a regular expression may also be
     * provided for more advanced route matching <br />
     * Regular expressions must be in the following form: `{<exp>}`
     * <b>NOTE:</b> Delimiting "/" characters must be included within the braces
     * @param string $method The request method to listen for
     * @param string $route The route to listen for
     * @param IRequestHandler $handler The request handlers to be registered
     * @return void
     */
    public function register(string $method, string $route, IRequestHandler $handler): void
    {
        // Sanitize trailing slashes from provided route
        if (strlen($route) > 1) {
            $route = rtrim(preg_replace("#/+#", "/", $route), "/");
        }

        if (!in_array($method, self::METHODS)) {
            return;
        }

        $this->handlers[$method] ??= [];
        $this->handlers[$method][$route] ??= [];
        $this->handlers[$method][$route] = $handler;
    }

    #[\Override]
    public function get(string $route, IRequestHandler $handler): void
    {
        $this->register("GET", $route, $handler);
    }

    #[\Override]
    public function post(string $route, IRequestHandler $handler): void
    {
        $this->register("POST", $route, $handler);
    }

    #[\Override]
    public function patch(string $route, IRequestHandler $handler): void
    {
        $this->register("PATCH", $route, $handler);
    }

    #[\Override]
    public function put(string $route, IRequestHandler $handler): void
    {
        $this->register("PUT", $route, $handler);
    }

    #[\Override]
    public function delete(string $route, IRequestHandler $handler): void
    {
        $this->register("DELETE", $route, $handler);
    }

    /**
     * Notifies a request handler registered to a specified method and route with received request data <br />
     * @param string $method The request method to notify
     * @param string $route The route to notify
     * @param Request $request The request to be handled by the request handler
     * @return void
     */
    public function map_route(string $method, string $route, Request $request): void
    {
        if (!isset($this->handlers[$method][$route])) {
            return;
        }

        /* @var $handler IRequestHandler */
        $handler = $this->handlers[$method][$route];
        $handler->handle_request($request, new Response());
    }

    /**
     * Every registered route will be treated as a regular expression
     * and attempt to match the passed route to each <br />
     *
     * Registered routes are deemed to be "regular expressions" if they are
     * enclosed in curly braces: `{<exp>}` <br />
     *
     * Regular expression used: `\{([^{}]+)}`
     *
     * If a route is matched via the regex, then the corresponding
     * request handler will be notified
     * @param string $method The request method to notify
     * @param string $route The route to notify
     * @param Request $request The request to be handled by the request handler
     * @return void
     */
    public function match_route(string $method, string $route, Request $request): void
    {
        if (!isset($this->handlers[$method])) {
            return;
        }

        /* @var $method_handlers array */
        $method_handlers = $this->handlers[$method];
        $pattern = "/\{([^{}]+)}/";

        /**
         * @var $route string
         * @var $handler IRequestHandler
         */
        foreach ($method_handlers as $registered_route => $handler) {
            $matches = [];
            preg_match($pattern, $registered_route, $matches);

            if (isset($matches[1])) {
                $route_pattern = $matches[1];
                $count = preg_match($route_pattern, $route);

                if ($count > 0) {
                    $handler->handle_request($request, new Response());
                }
            }
        }
    }

    /**
     * Triggered on request <br />
     * Notifies request handlers based on which method was used and which route was accessed in the request <br />
     * @param bool $match_regex True if the router should attempt to pattern match routes
     * @return void
     */
    #[\Override]
    public function dispatch(bool $match_regex = true): void
    {
        $method = $_SERVER["REQUEST_METHOD"];

        $parsed_url = parse_url($_SERVER["REQUEST_URI"]);
        $route = $parsed_url["path"] ?? "";

        // Generate request object
        $input = [];
        parse_str(file_get_contents("php://input"), $input);
        $req = new Request($route, $input, $_REQUEST);

        // `map_route` will run first; If no matches are made, then `match_route` will run if `$match_regex` is `true`
        $this->map_route($method, $route, $req);

        if ($match_regex) {
            $this->match_route($method, $route, $req);
        }
    }
}
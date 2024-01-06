<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Override;

/**
 * Handles routes by use of request handlers
 * @author Connell Reffo
 */
class Router implements IRouter
{
    /**
     * @var IMiddlewareHandler[] An array of middleware handlers to be triggered on request
     */
    private array $middleware_handlers;

    /**
     * @var array An associate array. Structured as follows: <br />
     * [
     *  (method) => [
     *    (route) => IRequestHandler
     *  ]
     * ]
     */
    private array $request_handlers;

    /**
     * Router constructor
     */
    public function __construct()
    {
        $this->middleware_handlers = [];
        $this->request_handlers = [];
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
        // Sanitize trailing slashes from provided route
        if (strlen($route) > 1) {
            $route = rtrim(preg_replace("#/+#", "/", $route), "/");
        }

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
     * Processes all middleware handlers
     * @param Request $req The client request object
     * @param Response $res The initial response object
     * @return Response The final response object
     */
    public function process_middleware(Request $req, Response $res): Response
    {
        $stack = array_reverse($this->middleware_handlers);
        $next = function ($req_next, $res_next) {
            return $res_next;
        };

        /* @var $handler IMiddlewareHandler */
        foreach ($stack as $handler) {
            $next = function (Request $request, Response $response) use ($handler, $next) {
                return $handler->handle_middleware($request, $response, $next);
            };
        }

        return $next($req, $res);
    }

    /**
     * <b>NOTE:</b> The route that will attempt to be mapped is the
     * final route of the response object <br />
     * Notifies a request handler registered to a specified method and route with received request data <br />
     * @param string $method The request method to notify
     * @param Request $req The request to be handled by the request handler
     * @param Response $res The response object
     * @return void
     */
    public function map_request_handler(string $method, Request $req, Response $res): void
    {
        $route = $res->get_final_route();

        if (!isset($this->request_handlers[$method][$route])) {
            return;
        }

        /* @var $handler IRequestHandler */
        $handler = $this->request_handlers[$method][$route];
        $handler->handle_request($req, $res);
    }

    /**
     * <b>NOTE:</b> The route that will attempt to be matched is the
     * final route of the response object <br />
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
     * @param Request $req The request to be handled by the request handler
     * @param Response $res The response object
     * @return void
     */
    public function match_request_handler(string $method, Request $req, Response $res): void
    {
        if (!isset($this->request_handlers[$method])) {
            return;
        }

        /* @var $method_handlers array */
        $method_handlers = $this->request_handlers[$method];
        $pattern = "/\{([^{}]+)}/";

        /**
         * @var $registered_route string
         * @var $handler IRequestHandler
         */
        foreach ($method_handlers as $registered_route => $handler) {
            $matches = [];
            preg_match($pattern, $registered_route, $matches);

            if (isset($matches[1])) {
                $route_pattern = $matches[1];
                $count = preg_match($route_pattern, $res->get_final_route());

                if ($count > 0) {
                    $handler->handle_request($req, $res);
                }
            }
        }
    }

    /**
     * Triggered on request <br />
     * First processes middleware then notifies request handlers based on
     * which method was used and which route was accessed in the request
     * @param bool $match_regex True if the router should attempt to pattern match routes
     * @return void
     */
    #[Override]
    public function dispatch(bool $match_regex = true): void
    {
        $method = $_SERVER["REQUEST_METHOD"];

        $parsed_url = parse_url($_SERVER["REQUEST_URI"]);
        $route = $parsed_url["path"] ?? "";

        // Generate request and response object
        $input = [];
        parse_str(file_get_contents("php://input"), $input);

        $req = new Request(
            $route,
            $input,
            $_REQUEST,
            $_COOKIE,
            $_SESSION
        );
        $res = new Response($route);
        $res = $this->process_middleware($req, $res);

        // `map_request_handler` will run first; If no matches are made, then `match_request_handler` will run if `$match_regex` is `true`
        $this->map_request_handler($method, $req, $res);

        if ($match_regex) {
            $this->match_request_handler($method, $req, $res);
        }
    }
}
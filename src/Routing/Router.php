<?php
declare(strict_types = 1);

namespace Gratis\Framework\Routing;

use Gratis\Framework\IRequestHandler;

/**
 * Handles routes by use of request handlers
 * @author Connell Reffo
 */
class Router
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
     * Registers request listener(s) to a supplied request method and route
     * @param string $method The request method to listen for
     * @param string $route The route to listen for
     * @param IRequestHandler $handler The request handlers to be registered
     * @return void
     */
    public function register(string $method, string $route, IRequestHandler $handler): void
    {
        if (!in_array($method, self::METHODS)) {
            return;
        }

        $this->handlers[$method] ??= [];
        $this->handlers[$method][$route] ??= [];
        $this->handlers[$method][$route] = $handler;
    }

    /**
     * Alias for register() with a `GET` request
     */
    public function get(string $route, IRequestHandler $handler): void
    {
        $this->register("GET", $route, $handler);
    }

    /**
     * Alias for register() with a `POST` request
     */
    public function post(string $route, IRequestHandler $handler): void
    {
        $this->register("POST", $route, $handler);
    }

    /**
     * Alias for register() with a `PATCH` request
     */
    public function patch(string $route, IRequestHandler $handler): void
    {
        $this->register("PATCH", $route, $handler);
    }

    /**
     * Alias for register() with a `PUT` request
     */
    public function put(string $route, IRequestHandler $handler): void
    {
        $this->register("PUT", $route, $handler);
    }

    /**
     * Alias for register() with a `DELETE` request
     */
    public function delete(string $route, IRequestHandler $handler): void
    {
        $this->register("DELETE", $route, $handler);
    }

    /**
     * Notifies a request handler registered to a specified method and route with received request data
     * @param string $method The request method to notify
     * @param string $route The route to notify
     * @param array $request The request to be handled by the request handler
     * @return void
     */
    public function trigger(string $method, string $route, array $request): void
    {
        if (isset($this->handlers[$method][$route])) {

            /* @var $handler IRequestHandler */
            $handler = $this->handlers[$method][$route];
            $handler->handle_request($request);
        }
    }

    /**
     * Triggered on request <br />
     * Notifies request handlers based on which method was used and which route was accessed in the request <br />
     * @return void
     */
    public function dispatch(): void
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $route = $_SERVER["REQUEST_URI"];
        $request = [];

        parse_str(file_get_contents("php://input"), $request);

        $this->trigger($method, $route, $request);
    }
}
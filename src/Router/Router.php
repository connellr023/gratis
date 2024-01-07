<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

use Gratis\Framework\Controllers\ServeStaticDirectoryController;
use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Utility;
use Override;

/**
 * Handles routes by use of request handlers <br />
 * Concrete implementation of a router with necessary functionality
 * @author Connell Reffo
 */
class Router extends AbstractRouter
{
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

        $method_handlers = $this->request_handlers[$method];
        $pattern = "/\{([^{}]+)}/";

        foreach ($method_handlers as $registered_route => $handler) {
            if (preg_match($pattern, $registered_route, $matches) && isset($matches[1])) {
                $route_pattern = $matches[1];

                if (preg_match($route_pattern, $res->get_final_route()) > 0) {
                    $handler->handle_request($req, $res);
                }
            }
        }
    }

    /**
     * Serves to root route: "/" <br />
     * This function is intended for serving single-page web apps where webpage
     * routing is handled by a front-end framework <br />
     * However this will still statically serve all files to "/" route in the given `$app_build_path` directory
     * @param string $app_build_path Is the full path to the directory containing the app's static markup
     * @param string $default_file_path Is the full path to the default file to be served if nothing else found
     * @return void
     */
    public function serve_app(string $app_build_path, string $default_file_path): void
    {
        $route_pattern = "~^\/?(\/[\w.-]+)*$~";
        $this->get("{ $route_pattern }", new ServeStaticDirectoryController($app_build_path, $default_file_path));
    }

    /**
     * Triggered on request <br />
     * First processes middleware then notifies request handlers based on
     * which method was used and which route was accessed in the request
     * @return void
     */
    #[Override]
    public function dispatch(): void
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $route = Utility::sanitize_route_string(parse_url($_SERVER["REQUEST_URI"])["path"] ?? "");

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

        $res = $this->process_middleware($req, new Response($route));

        // `map_request_handler` will run first; If no matches are made, then `match_request_handler` will run
        $this->map_request_handler($method, $req, $res);
        $this->match_request_handler($method, $req, $res);
    }
}
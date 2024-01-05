<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Closure;

/**
 * Specifies a contract for a class that handles HTTP requests
 * @author Connell Reffo
 */
interface IMiddlewareHandler
{
    /**
     * Handles incoming HTTP requests before they are dispatched to their final route handler <br />
     * This method can terminate the script, but it does not have to (and probably should not in most cases)
     * @param Request $req An object that represents an HTTP request
     * @param Response $res An object that handles sending an HTTP response
     * @param Closure $next Is the next middleware handler function to be called
     * @return Response The new response object
     */
    public function handle_middleware(Request $req, Response $res, Closure $next): Response;
}
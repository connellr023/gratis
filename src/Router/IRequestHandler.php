<?php
declare(strict_types = 1);

namespace Gratis\Framework\Router;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use JetBrains\PhpStorm\NoReturn;

/**
 * Specifies a contract for a class that handles HTTP requests
 * @author Connell Reffo
 */
interface IRequestHandler
{
    /**
     * Handles incoming HTTP requests <br />
     * This function is permitted to terminate the script
     * @param Request $req An object that represents an HTTP request
     * @param Response $res An object that handles sending an HTTP response
     * @return void
     */
    public function handle_request(Request $req, Response $res): void;
}
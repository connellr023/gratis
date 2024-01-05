<?php
declare(strict_types = 1);

namespace Gratis\Framework;

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
     * <b>NOTE:</b> This method is intended to terminate the script
     * @param Request $req An object that represents an HTTP request
     * @param Response $res An object that handles sending an HTTP response
     * @return void
     */
    #[NoReturn]
    public function handle_request(Request $req, Response $res): void;
}
<?php
declare(strict_types = 1);

namespace Gratis\Framework;

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
     * @param array $request An associate array that represents the request to be handled
     * @return void
     */
    #[NoReturn]
    public function handle_request(array $request): void;
}
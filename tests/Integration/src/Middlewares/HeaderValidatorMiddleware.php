<?php
declare(strict_types = 1);

namespace Gratis\Tests\Integration\src\Middlewares;

use Closure;
use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IMiddlewareHandler;
use Override;

/**
 * Rejects HTTP requests that don't have a specified cookie with a value associated with them
 */
class HeaderValidatorMiddleware implements IMiddlewareHandler
{
    private string $header_name;
    private string $header_value;

    public function __construct(string $header_name, string $header_value)
    {
        $this->header_name = $header_name;
        $this->header_value = $header_value;
    }

    #[Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        if ($req->get_from_header($this->header_name) != $this->header_value) {
            $res->set_status_code(403);

            echo "Forbidden";
        }
        else {
            $next($req, $res);
        }

        return $res;
    }
}
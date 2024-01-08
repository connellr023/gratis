<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit\Stubs;

use Closure;
use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IMiddlewareHandler;
use Override;

class IMiddlewareHandlerStub extends AbstractTriggerTracker implements IMiddlewareHandler
{
    #[Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        $this->trigger();
        $next($req, $res);

        return $res;
    }
}
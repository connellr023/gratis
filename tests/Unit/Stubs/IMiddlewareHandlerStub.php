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
    private int $status_code;

    public function __construct(int $status_code = 200)
    {
        parent::__construct();

        $this->status_code = $status_code;
    }

    #[Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        $this->trigger();
        $res->set_status_code($this->status_code);
        $next($req, $res);

        return $res;
    }
}
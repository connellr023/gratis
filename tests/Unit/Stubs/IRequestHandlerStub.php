<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit\Stubs;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use Override;

class IRequestHandlerStub extends AbstractTriggerTracker implements IRequestHandler
{
    #[Override]
    public function handle_request(Request $req, Response $res): void
    {
        $this->trigger();
    }
}
<?php
declare(strict_types = 1);

namespace Gratis\Tests\Stubs;

use Gratis\Framework\Router\Router;

class RouterStub extends Router
{
    public function reflect_middleware_handlers(): array
    {
        return $this->middleware_handlers;
    }

    public function reflect_request_handlers(): array
    {
        return $this->request_handlers;
    }
}
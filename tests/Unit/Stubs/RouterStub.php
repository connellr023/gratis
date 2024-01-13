<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit\Stubs;

use Gratis\Framework\Router\Router;

class RouterStub extends Router
{
    public function reflect_middleware_handlers(): array
    {
        return $this->middleware_handlers;
    }

    public function reflect_mappable_request_handlers(): array
    {
        return $this->mappable_request_handlers;
    }

    public function reflect_regex_request_handlers(): array
    {
        return $this->regex_request_handlers;
    }
}
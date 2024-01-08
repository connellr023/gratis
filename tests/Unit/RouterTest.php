<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\Router;
use Gratis\Tests\Unit\Stubs\IMiddlewareHandlerStub;
use Gratis\Tests\Unit\Stubs\IRequestHandlerStub;
use PHPUnit\Framework\TestCase;
use Error;

class RouterTest extends TestCase
{
    private Request $test_req;
    private Response $test_res;

    private Router $router;

    public function setUp(): void
    {
        $this->test_req = new Request(
            "/",
            [],
            [],
            [],
            []
        );
        $this->test_res = new Response("/");
        $this->router = new Router();
    }

    public function test_all_handlers_triggered_in_process_middleware()
    {
        $this->expectNotToPerformAssertions();

        $mw1 = new IMiddlewareHandlerStub();
        $mw2 = new IMiddlewareHandlerStub();
        $mw3 = new IMiddlewareHandlerStub();

        $should_trigger = [$mw1, $mw2, $mw3];

        $this->router->register_middleware($mw1, $mw2, $mw3);
        $this->router->process_middleware($this->test_req, $this->test_res);

        foreach ($should_trigger as $handler) {
            if (!$handler->is_triggered()) {
                throw new Error("Expected handler to be triggered");
            }
        }
    }
}
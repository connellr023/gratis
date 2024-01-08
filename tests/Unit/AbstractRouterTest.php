<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\Router\IMiddlewareHandler;
use Gratis\Framework\Router\IRequestHandler;
use Gratis\Tests\Unit\Stubs\RouterStub;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class AbstractRouterTest extends TestCase
{
    /* @throws Exception */
    public function test_register_middleware(): void
    {
        $router = new RouterStub();
        $mw = $this->createMock(IMiddlewareHandler::class);

        $this->assertEquals([], $router->reflect_middleware_handlers());
        $router->register_middleware($mw);
        $this->assertTrue(in_array($mw, $router->reflect_middleware_handlers()));
    }

    /* @throws Exception */
    public function test_register_route(): void
    {
        $router = new RouterStub();
        $rh = $this->createMock(IRequestHandler::class);

        $method = "TEST";
        $route = "/";

        $expected = [
            $method => [
                $route => $rh
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->register_route($method, $route, $rh);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }

    /* @throws Exception */
    public function test_register_route_same_twice(): void
    {
        $router = new RouterStub();
        $rh1 = $this->getMockBuilder(IRequestHandler::class)
            ->setMockClassName("unique1")
            ->getMock();

        $rh2 = $this->getMockBuilder(IRequestHandler::class)
            ->setMockClassName("unique2")
            ->getMock();

        $method = "TEST";
        $route = "/";

        $expected = [
            $method => [
                $route => $rh2
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->register_route($method, $route, $rh1);
        $router->register_route($method, $route, $rh2);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }

    /* @throws Exception */
    public function test_get(): void
    {
        $router = new RouterStub();
        $rh = $this->createMock(IRequestHandler::class);

        $route = "/";

        $expected = [
            "GET" => [
                $route => $rh
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->get($route, $rh);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }

    /* @throws Exception */
    public function test_post(): void
    {
        $router = new RouterStub();
        $rh = $this->createMock(IRequestHandler::class);

        $route = "/";

        $expected = [
            "POST" => [
                $route => $rh
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->post($route, $rh);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }

    /* @throws Exception */
    public function test_patch(): void
    {
        $router = new RouterStub();
        $rh = $this->createMock(IRequestHandler::class);

        $route = "/";

        $expected = [
            "PATCH" => [
                $route => $rh
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->patch($route, $rh);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }

    /* @throws Exception */
    public function test_put(): void
    {
        $router = new RouterStub();
        $rh = $this->createMock(IRequestHandler::class);

        $route = "/";

        $expected = [
            "PUT" => [
                $route => $rh
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->put($route, $rh);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }

    /* @throws Exception */
    public function test_delete(): void
    {
        $router = new RouterStub();
        $rh = $this->createMock(IRequestHandler::class);

        $route = "/";

        $expected = [
            "DELETE" => [
                $route => $rh
            ]
        ];

        $this->assertEquals([], $router->reflect_request_handlers());
        $router->delete($route, $rh);
        $this->assertEquals($expected, $router->reflect_request_handlers());
    }
}
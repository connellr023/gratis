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

    public function tearDown(): void
    {
        unset($_SERVER);
        unset($_REQUEST);
        unset($_GET);
        unset($_POST);
        unset($_SESSION);
        unset($_COOKIE);
    }

    public function test_all_handlers_triggered_in_process_middleware(): void
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

    public function test_map_request_handler_wrong_method(): void
    {
        $this->expectNotToPerformAssertions();

        $rh = new IRequestHandlerStub();

        $this->router->post("/", $rh);
        $this->router->map_request_handler("GET", $this->test_req, $this->test_res);

        if ($rh->is_triggered()) {
            throw new Error("Expected handler to not be triggered");
        }
    }

    public function test_map_request_handler_valid_route(): void
    {
        $rh = new IRequestHandlerStub();

        $this->router->get("/", $rh);
        $this->router->map_request_handler("GET", $this->test_req, $this->test_res);

        $this->assertTrue($rh->is_triggered());
    }

    public function test_exactly_one_handler_triggered_with_map_request_handler(): void
    {
        $rh1 = new IRequestHandlerStub();
        $rh2 = new IRequestHandlerStub();

        $this->router->get("/", $rh1);
        $this->router->get("/", $rh2);
        $this->router->map_request_handler("GET", $this->test_req, $this->test_res);

        $this->assertFalse($rh1->is_triggered());
        $this->assertTrue($rh2->is_triggered());
    }

    public function test_match_request_handler_invalid_method(): void
    {
        $this->expectNotToPerformAssertions();

        $rh = new IRequestHandlerStub();

        $this->router->post("< ~(.*)~ >", $rh); // Accept every route string
        $this->router->match_request_handler("GET", $this->test_req, $this->test_res);

        if ($rh->is_triggered()) {
            throw new Error("Expected handler to not be triggered");
        }
    }

    public function test_exactly_one_request_handler_triggered_with_match_request_handler(): void
    {
        $rh1 = new IRequestHandlerStub();
        $rh2 = new IRequestHandlerStub();

        $this->router->get("< ~(.*)~ >", $rh1);
        $this->router->get("< ~(.*)~ >", $rh2);
        $this->router->match_request_handler("GET", $this->test_req, $this->test_res);

        $this->assertFalse($rh1->is_triggered());
        $this->assertTrue($rh2->is_triggered());
    }

    public function test_match_request_handler_string_not_accepted(): void
    {
        $rh = new IRequestHandlerStub();

        $this->router->get("< ~^(.*a.*){2}[^a]*$~ >", $rh); // Accepts all strings that contain <i>at least 2</i> copies of "a"
        $this->router->match_request_handler("GET", $this->test_req, new Response("/ab")); // Only one copy of "a", so should reject

        $this->assertFalse($rh->is_triggered());
    }

    public function test_dispatch_unsuccessful_status(): void
    {
        $mw = new IMiddlewareHandlerStub(404);
        $rh = new IRequestHandlerStub();

        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/";

        $this->router->register_middleware($mw);
        $this->router->get("/", $rh);
        $this->router->dispatch();

        $this->assertFalse($rh->is_triggered());
    }

    public function test_dispatch_successful_status(): void
    {
        $mw = new IMiddlewareHandlerStub();
        $rh = new IRequestHandlerStub();

        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/";

        $this->router->register_middleware($mw);
        $this->router->get("/", $rh);
        $this->router->dispatch();

        $this->assertTrue($rh->is_triggered());
    }

    public function test_match_request_handler_not_executed(): void
    {
        $mw = new IMiddlewareHandlerStub();
        $rh1 = new IRequestHandlerStub();
        $rh2 = new IRequestHandlerStub();

        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/";

        $this->router->register_middleware($mw);
        $this->router->get("/", $rh1);
        $this->router->get("< ~(.*)~ >", $rh2);
        $this->router->dispatch();

        $this->assertTrue($rh1->is_triggered());
        $this->assertFalse($rh2->is_triggered());
    }

    public function test_match_request_handler_is_executed(): void
    {
        $mw = new IMiddlewareHandlerStub();
        $rh1 = new IRequestHandlerStub();
        $rh2 = new IRequestHandlerStub();

        $_SERVER["REQUEST_METHOD"] = "GET";
        $_SERVER["REQUEST_URI"] = "/";

        $this->router->register_middleware($mw);
        $this->router->post("/", $rh1);
        $this->router->get("< ~(.*)~ >", $rh2);
        $this->router->dispatch();

        $this->assertFalse($rh1->is_triggered());
        $this->assertTrue($rh2->is_triggered());
    }
}
<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\HTTP\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private Response $res;

    private string $route = "/";

    public function setUp(): void
    {
        $this->res = new Response($this->route);
    }

    public function test_get_final_route(): void
    {
        $this->assertSame($this->route, $this->res->get_final_route());
    }

    public function test_redirect_final_route(): void
    {
        $this->res->redirect_final_route("/test");
        $this->assertSame("/test", $this->res->get_final_route());
    }

    public function test_delete_cookie(): void
    {
        $_COOKIE["key"] = "value";

        $this->assertArrayHasKey("key", $_COOKIE);
        $this->res->delete_cookie("key");
        $this->assertArrayNotHasKey("key", $_COOKIE);
    }

    public function test_update_session(): void
    {
        $_SESSION = [];

        $this->assertArrayNotHasKey("key", $_SESSION);
        $this->res->update_session("key", 0);
        $this->assertArrayHasKey("key", $_SESSION);
    }

    public function test_set_content(): void
    {
        $this->res->set_content("test");
        $this->assertSame("test", $this->res->get_content());
    }

    public function test_append_content(): void
    {
        $this->res->set_content("test");
        $this->res->append_content("1");

        $this->assertSame("test1", $this->res->get_content());
    }

    public function test_send_content_default(): void
    {
        $this->res->set_content("test");
        $this->res->send_content();

        $this->expectOutputRegex("/test/");
        $this->assertEquals(200, $this->res->get_status_code());
    }

    public function test_send_content_append_false(): void
    {
        $this->res->set_content("test");
        $this->res->send_content("new", false);

        $this->expectOutputRegex("/new/");
        $this->assertEquals(200, $this->res->get_status_code());
    }

    public function test_send_encoded(): void
    {
        $this->res->send_encoded(["test" => "value"]);

        $this->expectOutputRegex('{"test":"value}');
        $this->assertEquals(200, $this->res->get_status_code());
    }

    public function test_send_static_file_readable(): void
    {
        $this->res->send_static(__DIR__ . "/src/index.html");

        $this->expectOutputRegex("/Message/");
        $this->assertEquals(200, $this->res->get_status_code());
    }

    public function test_send_static_file_not_readable(): void
    {
        $this->res->send_static(__DIR__ . "/not_existent.txt");

        $this->expectOutputRegex("/not readable/");
        $this->assertEquals(404, $this->res->get_status_code());
    }
}
<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\HTTP\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private Request $req;

    private string $route_accessed = "/";
    private array $input_body = ["input_param" => "value"];
    private array $url_body = ["url_param" => "value"];
    private array $cookies = ["cookie_name" => "test"];
    private array $session = ["session_var" => "test"];

    public function setUp(): void
    {
        $this->req = new Request(
            $this->route_accessed,
            $this->input_body,
            $this->url_body,
            $this->cookies,
            $this->session
        );
    }

    public function test_getters(): void
    {
        $this->assertEquals($this->route_accessed, $this->req->get_route_accessed());
        $this->assertEquals($this->input_body, $this->req->get_input_body());
        $this->assertEquals($this->url_body, $this->req->get_url_body());
    }

    public function test_get_cookie(): void
    {
        $this->assertSame($this->cookies["cookie_name"], $this->req->get_cookie("cookie_name"));
        $this->assertSame(false, $this->req->get_cookie("sdgf"));
    }

    public function test_get_from_session(): void
    {
        $this->assertSame($this->session["session_var"], $this->req->get_from_session("session_var"));
        $this->assertSame(null, $this->req->get_from_session("dfg"));
    }

    public function test_get_from_input_body(): void
    {
        $this->assertSame($this->input_body["input_param"], $this->req->get_from_input_body("input_param"));
        $this->assertSame(false, $this->req->get_from_input_body("dfg"));
    }

    public function test_get_from_url_body(): void
    {
        $this->assertSame($this->url_body["url_param"], $this->req->get_from_url_body("url_param"));
        $this->assertSame(false, $this->req->get_from_url_body("gfd"));
    }

    public function test_get_from_header_non_existent(): void
    {
        $this->assertSame(false, $this->req->get_from_header(""));
    }
}
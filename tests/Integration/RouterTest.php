<?php
declare(strict_types = 1);

namespace Gratis\Tests\Integration;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\GuzzleException;

class RouterTest extends AbstractIntegrationTestCase
{
    private const array ACCEPTED_HEADER = [
        "headers" => [
            "X-Validation-Header" => "test",
        ],
    ];

    /* @throws GuzzleException */
    public function test_get_request_correct_header(): void
    {
        $res = self::$http_client->get("/", self::ACCEPTED_HEADER);

        $this->assertStringContainsString("Integration Test Static File", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
    }

    /* @throws GuzzleException */
    public function test_get_request_wrong_header(): void
    {
        $res = self::$http_client->get("/", [
            "headers" => [
                "X-Wrong-Header" => "bad",
            ],
            "http_errors" => false
        ]);

        $this->assertStringContainsString("Forbidden", $res->getBody()->getContents());
        $this->assertEquals(403, $res->getStatusCode());
    }

    /* @throws GuzzleException */
    public function test_request_registered_route_wrong_method()
    {
        $res = self::$http_client->get("/hello-world-patch", self::ACCEPTED_HEADER);

        $this->assertStringContainsString("Integration Test Static File", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
    }

    /* @throws GuzzleException */
    public function test_request_unregistered_route_with_serve_app()
    {
        $res = self::$http_client->get("/blank", self::ACCEPTED_HEADER);
        $content_type_header = $res->getHeader("Content-Type");

        $this->assertStringContainsString("Integration Test Static File", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertStringContainsString("text/html", $content_type_header[0]);
    }

    /* @throws GuzzleException */
    public function test_get_styles_css()
    {
        $res = self::$http_client->get("/styles/styles.css", self::ACCEPTED_HEADER);
        $content_type_header = $res->getHeader("Content-Type");

        $this->assertStringContainsString("body", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertStringContainsString("text/css", $content_type_header[0]);
    }

    /* @throws GuzzleException */
    public function test_get_script_js()
    {
        $res = self::$http_client->get("/scripts/script.js", self::ACCEPTED_HEADER);
        $content_type_header = $res->getHeader("Content-Type");

        $this->assertStringContainsString("window.onload", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertStringContainsString("application/javascript", $content_type_header[0]);
    }

    /* @throws GuzzleException */
    public function test_hello_world_get_route()
    {
        $res = self::$http_client->get("/hello-world-get", self::ACCEPTED_HEADER);

        $this->assertStringContainsString("Hello World", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
    }

    /* @throws GuzzleException */
    public function test_hello_world_post_route()
    {
        $res = self::$http_client->post("/hello-world-post", self::ACCEPTED_HEADER);

        $this->assertStringContainsString("Hello World", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
    }

    /* @throws GuzzleException */
    public function test_hello_world_put_route()
    {
        $res = self::$http_client->put("/hello-world-put", self::ACCEPTED_HEADER);

        $this->assertStringContainsString("Hello World", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
    }

    /* @throws GuzzleException */
    public function test_hello_world_delete_route()
    {
        $res = self::$http_client->delete("/hello-world-delete", self::ACCEPTED_HEADER);

        $this->assertStringContainsString("Hello World", $res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
    }
}
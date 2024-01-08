<?php
declare(strict_types = 1);

namespace Gratis\Tests\Integration;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\GuzzleException;

class RouterTest extends AbstractIntegrationTestCase
{
    /* @throws GuzzleException */
    public function test_get_request_success(): void
    {
        $res = self::$http_client->get("/", [
            "headers" => [
                "X-Validation-Header" => "test",
            ],
        ]);

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
}
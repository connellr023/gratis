<?php
declare(strict_types = 1);

namespace Gratis\Tests\Integration;

use GuzzleHttp\Exception\GuzzleException;

class RouterTest extends AbstractIntegrationTestCase
{
    /* @throws GuzzleException */
    public function test_get_request(): void
    {
        $res = self::$http_client->get("/");

        $this->assertEquals(200, $res->getStatusCode());
    }
}
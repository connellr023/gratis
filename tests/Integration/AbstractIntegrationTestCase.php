<?php
declare(strict_types = 1);

namespace Gratis\Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Override;

/**
 * @testdox Integration test base
 */
abstract class AbstractIntegrationTestCase extends TestCase
{
    protected const string HOST = "localhost:8000";

    protected static Client $http_client;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$http_client = new Client([
            "base_uri" => "http://" . self::HOST
        ]);
    }
}
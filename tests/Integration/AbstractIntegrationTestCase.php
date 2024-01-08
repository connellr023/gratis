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
    private const string HOST = "localhost:8000";

    protected static $server_process;
    protected static bool $server_started = false;

    protected static Client $http_client;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$http_client = new Client([
            "base_uri" => "http://" . self::HOST
        ]);

        // Start the server before the first test in the class
        if (!self::$server_started) {
            $command = "php -S " . self::HOST . " " . __DIR__ . "/src/test.php";
            $descriptor_spec = array(
                0 => array("pipe", "r"),
                1 => array("pipe", "w")
            );

            self::$server_process = proc_open($command, $descriptor_spec, $pipes);
            self::$server_started = true;
        }
    }

    #[Override]
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        // Stop the server after all tests in the class
        if (self::$server_started) {
            proc_terminate(self::$server_process);
            self::$server_started = false;
        }
    }
}
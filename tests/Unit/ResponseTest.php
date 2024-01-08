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
}
<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\Utility;
use PHPUnit\Framework\TestCase;

class UtilityTest extends TestCase
{
    public function test_get_mime_type_by_extension_type_exists(): void
    {
        $extension = "CSS";
        $expected = "text/css";

        $this->assertSame(Utility::get_mime_type_by_extension($extension), $expected);
    }

    public function test_get_mime_type_by_extension_type_does_not_exists(): void
    {
        $extension = "kolidfg";
        $expected = "plain/text";

        $this->assertSame(Utility::get_mime_type_by_extension($extension), $expected);
    }

    public function test_add_mime_type_extension_map(): void
    {
        $extension = "ts";
        $mime_type = "text/javascript";

        $this->assertSame(Utility::get_mime_type_by_extension($extension), "plain/text");

        Utility::add_mime_type_extension_map($extension, $mime_type);

        $this->assertSame(Utility::get_mime_type_by_extension($extension), $mime_type);
    }

    public function test_sanitize_route_string_not_root(): void
    {
        $route = "/test//";
        $expected = "/test";

        $this->assertSame(Utility::sanitize_route_string($route), $expected);
    }

    public function test_sanitize_route_string_is_root(): void
    {
        $route = "///";
        $expected = "/";

        $this->assertSame(Utility::sanitize_route_string($route), $expected);
    }

    public function test_sanitize_route_string_is_root_empty_string(): void
    {
        $route = "";
        $expected = "/";

        $this->assertSame(Utility::sanitize_route_string($route), $expected);
    }
}
<?php
declare(strict_types = 1);

namespace Gratis\Framework;

/**
 * Class for re-usable static utility functions
 * @author Connell Reffo
 */
abstract class Utility
{
    private static array $mime_types = [
        "html" => "text/html",
        "css" => "text/css",
        "js"  => "application/javascript",
        "json" => "application/json",
        "jpg"  => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png"  => "image/png",
        "gif"  => "image/gif",
        "ico" => "image/vnd.microsoft.icon"
    ];

    /**
     * Utility function for adding a mime-type by extensions that may not be present
     * @param string $extension The file extension
     * @param string $mime_type The corresponding mime-type
     * @return bool True if the mapping was added, false if it already exists
     */
    public static function add_mime_type_extension_map(string $extension, string $mime_type): bool
    {
        $extension = strtolower($extension);

        if (!isset(self::$mime_types[$extension])) {
            self::$mime_types[$extension] = $mime_type;
            return true;
        }

        return false;
    }

    /**
     * Utility function for mapping file extensions (case-insensitive) to their
     * corresponding mime-type for setting content headers
     * @param string $extension The file extension to get the corresponding mime-type of
     * @return string The mime-type or `plain/text` if no mapping available
     */
    public static function get_mime_type_by_extension(string $extension): string
    {
        return self::$mime_types[strtolower($extension)] ?? "plain/text";
    }

    /**
     * Static utility method for ensuring routes do not end with "/"
     * @param string $route The route to be sanitized
     * @return string The sanitized route string
     */
    public static function sanitize_route_string(string $route): string
    {
        $new = rtrim(preg_replace("#/+#", "/", $route), "/");

        return strlen($new) > 0 ? $new : "/";
    }
}
<?php
declare(strict_types = 1);

namespace Gratis\Framework\HTTP;

use Gratis\Framework\Utility;

/**
 * Responsible for sending HTTP responses back to the client
 * @author Connell Reffo
 */
class Response
{
    private string $final_route;
    private string $content;
    private int $status_code;

    /**
     * Constructor for an HTTP response object
     * @param string $current_route Is the initial response route
     */
    public function __construct(string $current_route)
    {
        $this->final_route = $current_route;
        $this->content = "";
        $this->status_code = 200;
    }

    /**
     * Sets the HTTP response code
     * Uses the built-in `http_response_code` PHP function
     * @param int $status The status code to set
     * @return void
     */
    public function set_status_code(int $status): void
    {
        http_response_code($status);
        $this->status_code = $status;
    }

    /**
     * Gets the current HTTP response code
     * Uses the built-in `http_response_code` PHP function
     * @return int
     */
    public function get_status_code(): int
    {
        if (is_int(http_response_code())) {
            $this->status_code = http_response_code();

            return $this->status_code;
        }

        return $this->status_code;
    }

    /**
     * Checks if the HTTP status code of this response object is "successful" <br />
     * Simply asserts that the code is between 200 and 299 inclusive
     * @return bool
     */
    public function is_successful_status(): bool
    {
        $status = $this->get_status_code();
        return $status >= 200 && $status <= 299;
    }

    /**
     * Sets HTTP response headers <br />
     * Uses the built-in `header` PHP function
     * @param string ...$headers A sequence of headers to be set
     * @return void
     */
    public function set_headers(string ...$headers): void
    {
        foreach ($headers as $header) {
            header($header);
        }
    }

    /**
     * Sets the destination route <br />
     * Should only be used by middleware handlers <br />
     * Does not set `Location` headers
     * @param string $route
     * @return void
     */
    public function redirect_final_route(string $route): void
    {
        $this->final_route = $route;
    }

    /**
     * Gets the final route of this response object
     * @return string
     */
    public function get_final_route(): string
    {
        return $this->final_route;
    }

    /**
     * Sets a cookie <br />
     * Uses the built-in `setcookie` PHP function
     * @param string $name The name of the cookie
     * @param string $value The value associated with the cookies
     * @param int $expiry The time in seconds relative to the current time
     *                    for when the cookie should expire
     * @param string $path The path that dictates where the cookie will be available
     * @param string $domain The domain the cookie is available to
     * @param bool $secure Should be true if cookie should only be transferred over HTTPS
     * @param bool $http_only True if cookie should be accessible only via HTTP
     * @param string $same_site Attribute that is "None", "Lax", or "Strict"
     * @return void
     * @codeCoverageIgnore
     */
    public function set_cookie(
        string $name,
        string $value,
        int $expiry,
        string $path = "/",
        string $domain = "",
        bool $secure = false,
        bool $http_only = false,
        string $same_site = "None"|"Lax"|"Strict"
    ): void
    {
        setcookie($name, $value, [
            "expires" => time() + $expiry,
            "path" => $path,
            "domain" => $domain,
            "secure" => $secure,
            "httponly" => $http_only,
            "samesite" => $same_site
        ]);
    }

    /**
     * Removes a cookie
     * Uses the built-in `setcookie` PHP function
     * @param string $name The name of the cookie to remove
     * @return void
     */
    public function delete_cookie(string $name): void
    {
        unset($_COOKIE[$name]);
        setcookie($name, "", -1, "/");
    }

    /**
     * Updates the current session
     * @param string $session_key The session key to update
     * @param mixed $value The value to set it to
     * @return void
     */
    public function update_session(string $session_key, mixed $value): void
    {
        $_SESSION[$session_key] = $value;
    }

    /**
     * Strictly sets the content string to be sent
     * @param string $content The content to be set
     * @return void
     */
    public function set_content(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Concatenates onto the current content string
     * @param string $to_append The content to be appended
     * @return void
     */
    public function append_content(string $to_append): void
    {
        $this->content = $this->content . $to_append;
    }

    /**
     * Getter for the response content string
     * @return string
     */
    public function get_content(): string
    {
        return $this->content;
    }

    /**
     * Sends the content <br />
     * Terminates the script
     * @param string $content Additional content to be sent
     * @param bool $append If the additional content should be appended or reset
     * @return void
     */
    public function send_content(string $content = "", bool $append = true): void
    {
        if ($append) {
            $this->append_content($content);
        }
        else {
            $this->set_content($content);
        }

        echo $this->content;
    }

    /**
     * JSON encodes an array and sends it to the client
     * @param array $data The array to be encoded and sent
     * @return void
     */
    public function send_encoded(array $data): void
    {
        echo json_encode($data);
    }

    /**
     * Sends a static file to the client <br />
     * If the file is not found or readable, then
     * a `404` status code header will be attached to the response
     * @param string $path The full path to the file to be sent
     * @param bool $detect_content If mime-type of the file should attempt to be detected
     * @return void
     */
    public function send_static(string $path, bool $detect_content = true): void
    {
        if (!file_exists($path) || !is_readable($path)) {
            $this->set_status_code(404);

            echo "File not found or not readable";
            return;
        }

        if ($detect_content) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mime_type = Utility::get_mime_type_by_extension($extension);

            $this->set_headers("Content-Type: $mime_type");
        }

        readfile($path);
    }
}
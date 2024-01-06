<?php

namespace Gratis\Framework\HTTP;

use JetBrains\PhpStorm\NoReturn;

/**
 * Responsible for sending HTTP responses back to the client
 * @author Connell Reffo
 */
class Response
{
    private string $final_route;
    private string $content;

    public function __construct(string $current_route)
    {
        $this->final_route = $current_route;
        $this->content = "";
    }

    public function set_status_code(Status|int $status): void
    {
        http_response_code($status->value ?? $status);
    }

    public function set_headers(string ...$headers): void
    {
        foreach ($headers as $header) {
            header($header);
        }
    }

    public function redirect(string $route): void
    {
        $this->final_route = $route;
    }

    public function get_final_route(): string
    {
        return $this->final_route;
    }

    /**
     * Sets a cookie
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

    public function delete_cookie(string $name): void
    {
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

    public function set_content(string $content): void
    {
        $this->content = $content;
    }

    public function append_content(string $to_append): void
    {
        $this->content = $this->content . $to_append;
    }

    public function get_content(): string
    {
        return $this->content;
    }

    #[NoReturn]
    public function send_content(string $content = "", bool $append = true): void
    {
        if ($append) {
            $this->append_content($content);
        }
        else {
            $this->set_content($content);
        }

        die($this->content);
    }

    #[NoReturn]
    public function send_encoded(array $data): void
    {
        die(json_encode($data));
    }
}
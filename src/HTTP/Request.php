<?php
declare(strict_types = 1);

namespace Gratis\Framework\HTTP;

/**
 * Responsible for containing information regarding the client request
 * @author Connell Reffo
 */
class Request
{
    private string $route_accessed;
    private array $input_body;
    private array $url_body;
    private array $cookies;
    private array $session;

    /**
     * Request constructor
     * @param string $route_accessed Is the route that was accessed in the request
     * @param array $input_body The data from the PHP input file stream
     * @param array $url_body The data from request/url parameters
     * @param array $cookies Is an associative array of cookies names to their values
     * @param array $session Is an associative array that represents the client session
     */
    public function __construct(string $route_accessed, array $input_body, array $url_body, array $cookies, array $session)
    {
        $this->route_accessed = $route_accessed;
        $this->input_body = $input_body;
        $this->url_body = $url_body;
        $this->cookies = $cookies;
        $this->session = $session;
    }

    /**
     * Getter for the accessed route
     * @return string
     */
    public function get_route_accessed(): string
    {
        return $this->route_accessed;
    }

    /**
     * Getter for the associate array that represents the input body
     * @return array
     */
    public function get_input_body(): array
    {
        return $this->input_body;
    }

    /**
     * Gets the corresponding value from a key in the request input body
     * @param string $key The key to get the corresponding value of
     * @return string The value or empty string if nothing found
     */
    public function get_from_input_body(string $key): string
    {
        return $this->get_input_body()[$key] ?? "";
    }

    /**
     * Getter for the associate array that represents the url body
     * @return array
     */
    public function get_url_body(): array
    {
        return $this->url_body;
    }

    /**
     * Gets the corresponding value from a key in the url body
     * @param string $key The key to get the corresponding value of
     * @return string The value or empty string if nothing found
     */
    public function get_from_url_body(string $key): string
    {
        return $this->get_url_body()[$key] ?? "";
    }

    /**
     * Gets the value associated with a cookie
     * @param string $cookie_key The name of the cookie
     * @return string The associated value or empty string if nothing found
     */
    public function get_cookie(string $cookie_key): string
    {
        return $this->cookies[$cookie_key] ?? "";
    }

    /**
     * Gets a value associated with a session key
     * @param string $session_key The session key to get the corresponding value of
     * @return mixed The key's value or `null` if nothing was found
     */
    public function get_from_session(string $session_key): mixed
    {
        return $this->session[$session_key] ?? null;
    }
}
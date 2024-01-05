<?php

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

    /**
     * Request constructor
     * @param string $route_accessed Is the route that was accessed in the request
     * @param array $input_body The data from the PHP input file stream
     * @param array $url_body The data from request/url parameters
     */
    public function __construct(string $route_accessed, array $input_body, array $url_body)
    {
        $this->route_accessed = $route_accessed;
        $this->input_body = $input_body;
        $this->url_body = $url_body;
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
}
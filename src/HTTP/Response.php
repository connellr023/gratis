<?php

namespace Gratis\Framework\HTTP;

/**
 * Responsible for sending HTTP responses back to the client
 * @author Connell Reffo
 */
class Response
{
    private string $final_route;

    public function __construct(string $final_route)
    {
        $this->final_route = $final_route;
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
}
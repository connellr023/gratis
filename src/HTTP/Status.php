<?php
declare(strict_types = 1);

namespace Gratis\Framework\HTTP;

/**
 * Enumeration of HTTP status codes that can be used in responses
 * @author Connell Reffo
 */
enum Status: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case INTERNAL_SERVER_ERROR = 500;
}
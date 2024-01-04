<?php
declare(strict_types = 1);

namespace Gratis\Framework\exceptions;

use Throwable;
use RuntimeException;

/**
 * Runtime exception used by Gratis
 * @author Connell Reffo
 */
class GratisException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
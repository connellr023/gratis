<?php
declare(strict_types = 1);

namespace Gratis\Tests\Integration\src\Controllers;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use Override;

class EchoController implements IRequestHandler
{
    private string $echo;

    public function __construct(string $echo)
    {
        $this->echo = $echo;
    }

    #[Override]
    public function handle_request(Request $req, Response $res): void
    {
        echo $this->echo;
    }
}
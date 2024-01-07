<?php
declare(strict_types = 1);

namespace Gratis\Framework\Controllers;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use JetBrains\PhpStorm\NoReturn;
use Override;

/**
 * Controller for handling static file serving
 * @author Connell Reffo
 */
class ServeAppController implements IRequestHandler
{
    private string $app_build_path;
    private string $default_file_path;

    public function __construct(string $app_build_path, string $default_file_path)
    {
        $this->app_build_path = $app_build_path;
        $this->default_file_path = $default_file_path;
    }

    #[NoReturn] #[Override]
    public function handle_request(Request $req, Response $res): void
    {
        $accessed_path = $this->app_build_path . $req->get_route_accessed();
        $path = is_file($accessed_path) ? $accessed_path : $this->default_file_path;

        $res->send_static($path);
    }
}
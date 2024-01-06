<?php
declare(strict_types = 1);

namespace Gratis\Framework\Controllers;

use Gratis\Framework\HTTP\Request;
use Gratis\Framework\HTTP\Response;
use Gratis\Framework\Router\IRequestHandler;
use JetBrains\PhpStorm\NoReturn;
use Override;

/**
 * Controller for handling static webpage serving
 * @author Connell Reffo
 */
class ServeStaticController implements IRequestHandler
{
    private string $serve_path;
    private string $entry_file_name;

    public function __construct(string $serve_path, string $entry_file_name = "")
    {
        $this->serve_path = $serve_path;
        $this->entry_file_name = $entry_file_name;
    }

    #[NoReturn] #[Override]
    public function handle_request(Request $req, Response $res): void
    {
        $file_name = $req->get_file_accessed_name();
        $file_name = strlen($file_name) > 0 ? $file_name : $this->entry_file_name;

        $res->send_static("$this->serve_path/$file_name");
    }
}
<?php
declare(strict_types = 1);

namespace Gratis\Tests\Stubs;

use Gratis\Framework\Database\Database;
use Gratis\Framework\Exceptions\GratisException;
use PDO;
use PDOStatement;

class DatabaseStub extends Database
{
    public function __construct(PDO $instance)
    {
        try {
            parent::__construct("", "", "", "", "");
        }
        catch (GratisException) {}

        // Inject PDO instance
        $this->pdo = $instance;
    }

    public function reflect_last_statement(): PDOStatement
    {
        return $this->last_statement;
    }
}
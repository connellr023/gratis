<?php
declare(strict_types = 1);

namespace Gratis\Framework\database;

use Gratis\Framework\exceptions\GratisException;
use PDOStatement;

/**
 * Defines a contract every PDO database should include
 * @author Connell Reffo
 */
interface IDatabase
{
    /**
     * Executes an SQL query
     * @param string $sql The SQL instruction to be executed
     * @return PDOStatement An object that represents the successful result of the query
     * @throws GratisException If the query fails to execute
     */
    public function execute_query(string $sql): PDOStatement;

    public function execute_prepared_statement(string $sql, array $params): PDOStatement;

    public function fetch_assoc(PDOStatement $statement): array;
}
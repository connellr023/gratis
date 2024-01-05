<?php
declare(strict_types = 1);

namespace Gratis\Framework\Database;

use Gratis\Framework\Exceptions\GratisException;

/**
 * Defines a contract every SQL database should include
 * @author Connell Reffo
 */
interface IDatabase
{
    /**
     * Executes an SQL query
     * @param string $sql The SQL instruction to be executed
     * @return void
     * @throws GratisException If the query fails to execute
     */
    public function execute_query(string $sql): void;

    /**
     * Prepares an SQL query and then inserts a sequence of parameters into their
     * respective positions denoted by "?"
     * @param string $sql
     * @param string ...$params
     * @return void
     * @throws GratisException If the query fails to prepare and execute
     */
    public function execute_prepared_statement(string $sql, string ...$params): void;

    /**
     * Fetches an associative array of values based on the `SELECT` query just made
     * @return array
     * @throws GratisException If the values fail to be retrieved
     */
    public function fetch_assoc(): array;
}
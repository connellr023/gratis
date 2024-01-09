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
     * respective positions denoted by "?" or ":param"
     * @param string $sql The SQL command to be prepared
     * @param array $params The parameters to be inserted
     * @return void
     * @throws GratisException If the query fails to prepare or execute
     */
    public function execute_prepared_statement(string $sql, array $params): void;

    /**
     * Fetches an associative array of values based on the `SELECT` query just made
     * @return array
     * @throws GratisException If the values fail to be retrieved
     */
    public function fetch_assoc(): array;

    /**
     * Gets the ID of the last row inserted into a table
     * @param string|null $field_name
     * @return string
     * @throws GratisException If reading the last insert ID fails
     */
    public function fetch_last_insert_id(?string $field_name = null): string;
}
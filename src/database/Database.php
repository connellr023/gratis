<?php
declare(strict_types = 1);

namespace Gratis\Framework\database;

use Gratis\Framework\exceptions\GratisException;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class that encapsulates MySQL database functionality
 * @author Connell Reffo
 */
class Database
{
    /**
     * @var PDO Is the `PHP Data Object` instance to encapsulate
     */
    private PDO $pdo;

    /**
     * Database constructor
     * @param string $hostname The hostname of the database
     * @param string $db_name The name of the database
     * @param string $username The username to interact with the database under
     * @param string $password The user's password
     * @param string $db_variant Is the variant of this database (`mysql` by default)
     * @throws GratisException If connection fails or configuration of PDO fails
     */
    public function __construct(string $hostname, string $db_name, string $username, string $password, string $db_variant = "mysql")
    {
        try {
            $this->pdo = new PDO("$db_variant:host=$hostname;dbname=$db_name", $username, $password);

            if (!(
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ||
                $this->pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING)
            )) {
                throw new GratisException("Failed to configure PDO");
            }
        }
        catch (PDOException $e) {
            throw new GratisException("Failed to connect to database: " . $e->getMessage());
        }
    }

    /**
     * Executes an SQL query
     * @param string $sql The SQL instruction to be executed
     * @return PDOStatement An object that represents the successful result of the query
     * @throws GratisException If the query fails to execute
     */
    public function executeQuery(string $sql): PDOStatement
    {
        if ($statement = $this->pdo->query($sql, PDO::FETCH_ASSOC)) {
            return $statement;
        }

        throw new GratisException("Failed to execute query");
    }

    public function executePreparedStatement(string $sql, array $params): PDOStatement
    {
        if ($statement = $this->pdo->prepare($sql)) {
            try {
                if ($statement->execute($params)) {
                    return $statement;
                }
            }
            catch (PDOException $e) {
                throw new GratisException("Failed to execute prepared statement: " . $e->getMessage());
            }
        }

        throw new GratisException("Failed to prepare statement");
    }

    public function fetchAssoc(PDOStatement $statement): array
    {
        if (is_array($result = $statement->fetchAll(PDO::FETCH_ASSOC))) {
            return $result;
        }

        throw new GratisException("Failed to read result from statement");
    }
}
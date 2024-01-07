<?php
declare(strict_types = 1);

namespace Gratis\Framework\Database;

use Gratis\Framework\Exceptions\GratisException;
use PDO;
use PDOException;
use PDOStatement;
use Override;

/**
 * Class that encapsulates SQL database functionality <br />
 * Uses `PDO`
 * @author Connell Reffo
 */
class Database implements IDatabase
{
    /**
     * @var PDO Is the `PHP Data Object` instance to encapsulate
     */
    protected PDO $pdo;

    /**
     * @var PDOStatement The last `PDO` statement generated by an SQL query
     */
    protected PDOStatement $last_statement;

    /**
     * Database constructor <br />
     * This class encapsulates a `PDO` instance - For more information see: https://www.php.net/manual/en/book.pdo.php
     * @param string $hostname The hostname of the database
     * @param string $db_name The name of the database
     * @param string $username The username to interact with the database under
     * @param string $password The user's password
     * @param string $driver Is the driver to be used by this database instance
     * @param int $port Is the port that the database is running on
     * @throws GratisException If connection fails or configuration of PDO fails
     * @codeCoverageIgnore
     */
    public function __construct(
        string $hostname,
        string $db_name,
        string $username,
        string $password,
        string $driver = "mysql"|"cubrid"|"mssql"|"sybase"|"dblib"|"firebird"|"ibm"|"informix"|"oci"|"odbc"|"pgsql"|"sqlite"|"sqlsrv",
        int $port = 3306
    )
    {
        try {
            $this->pdo = new PDO("$driver:host=$hostname;dbname=$db_name;port=$port", $username, $password);

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

    #[Override]
    public function execute_query(string $sql): void
    {
        if ($statement = $this->pdo->query($sql, PDO::FETCH_ASSOC)) {
            $this->last_statement = $statement;
            return;
        }

        throw new GratisException("Failed to execute query");
    }

    #[Override]
    public function execute_prepared_statement(string $sql, array $params): void
    {
        if ($statement = $this->pdo->prepare($sql)) {
            try {
                if ($statement->execute($params)) {
                    $this->last_statement = $statement;
                    return;
                }
            }
            catch (PDOException $e) {
                throw new GratisException("Failed to execute prepared statement: " . $e->getMessage());
            }
        }

        throw new GratisException("Failed to prepare statement");
    }

    #[Override]
    public function fetch_assoc(): array
    {
        try {
            return $this->last_statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            throw new GratisException("Failed to read result from last statement: " . $e->getMessage());
        }
    }
}
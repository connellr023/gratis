<?php
declare(strict_types = 1);

namespace Gratis\Framework;

use Gratis\Framework\Database\IDatabase;
use Gratis\Framework\Exceptions\GratisException;

/**
 * Abstract representation of a class that is used to model an element of a database
 * @author Connell Reffo
 */
abstract class AbstractModel
{
    /**
     * @var IDatabase Is a reference to a database instance that
     *                all model classes will have access to
     */
    private static IDatabase $db;

    /**
     * Sets the global model-accessible database instance
     * @param IDatabase $database The instance to use
     * @return void
     */
    public static function configure_db_instance(IDatabase $database): void
    {
        self::$db = $database;
    }

    /**
     * Getter for the model-accessible database instance
     * @return IDatabase
     */
    protected static function get_db(): IDatabase
    {
        return self::$db;
    }

    /**
     * Base constructor
     * @throws GratisException If the database reference is not set
     */
    protected function __construct()
    {
        if (!isset(self::$db)) {
            throw new GratisException("Database reference not set");
        }
    }
}
<?php

namespace Gratis\Framework\lib;

use Gratis\Framework\database\IDatabase;
use Gratis\Framework\exceptions\GratisException;

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

    public static function configure_database_instance(IDatabase $database): void
    {
        self::$db = $database;
    }

    protected function __construct()
    {
        if (!isset(self::$db)) {
            throw new GratisException("Database reference not set");
        }
    }
}
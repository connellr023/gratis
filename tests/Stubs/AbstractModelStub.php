<?php
declare(strict_types = 1);

namespace Gratis\Tests\Stubs;

use Gratis\Framework\AbstractModel;
use Gratis\Framework\Database\IDatabase;

class AbstractModelStub extends AbstractModel {

    public static function reflect_db_instance(): IDatabase
    {
        return self::get_db();
    }
}
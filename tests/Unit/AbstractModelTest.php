<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\AbstractModel;
use Gratis\Framework\Database\IDatabase;
use Gratis\Tests\Unit\Stubs\AbstractModelStub;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class AbstractModelTest extends TestCase
{
    /* @throws Exception */
    public function test_database_configuration(): void
    {
        $db_instance = $this->createMock(IDatabase::class);

        AbstractModel::configure_db_instance($db_instance);

        $this->assertEquals(AbstractModelStub::reflect_db_instance(), $db_instance);
    }
}
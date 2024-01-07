<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit;

use Gratis\Framework\Exceptions\GratisException;
use Gratis\Tests\Stubs\DatabaseStub;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use PDOException;

class DatabaseTest extends TestCase
{
    /* @throws Exception */
    public function test_execute_query_success(): void
    {
        $sql = "TEST QUERY";

        $pdo_mock = $this->createMock(PDO::class);
        $pdo_statement_mock = $this->createMock(PDOStatement::class);

        $pdo_mock->expects($this->once())
            ->method("query")
            ->with($sql, PDO::FETCH_ASSOC)
            ->willReturn($pdo_statement_mock);

        $db = new DatabaseStub($pdo_mock);
        $db->execute_query($sql);

        $this->assertEquals($db->reflect_last_statement(), $pdo_statement_mock);
    }

    /* @throws Exception */
    public function test_execute_query_fail(): void
    {
        $this->expectException(GratisException::class);

        $sql = "TEST QUERY";

        $pdo_mock = $this->createMock(PDO::class);

        $pdo_mock->expects($this->once())
            ->method("query")
            ->with($sql, PDO::FETCH_ASSOC)
            ->willReturn(false);

        $db = new DatabaseStub($pdo_mock);
        $db->execute_query($sql);
    }

    /* @throws Exception */
    public function test_execute_prepared_statement_success(): void
    {
        $sql = "TEST QUERY";
        $params = ["1", "2"];

        $pdo_mock = $this->createMock(PDO::class);
        $pdo_statement_mock = $this->createMock(PDOStatement::class);

        $pdo_mock->expects($this->once())
            ->method("prepare")
            ->with($sql)
            ->willReturn($pdo_statement_mock);

        $pdo_statement_mock->expects($this->once())
            ->method("execute")
            ->with($params)
            ->willReturn(true);

        $db = new DatabaseStub($pdo_mock);
        $db->execute_prepared_statement($sql, $params);

        $this->assertEquals($db->reflect_last_statement(), $pdo_statement_mock);
    }

    /* @throws Exception */
    public function test_execute_prepared_statement_failed_to_prepare(): void
    {
        $this->expectException(GratisException::class);

        $sql = "TEST QUERY";
        $params = ["1", "2"];

        $pdo_mock = $this->createMock(PDO::class);

        $pdo_mock->expects($this->once())
            ->method("prepare")
            ->with($sql)
            ->willReturn(false);

        $db = new DatabaseStub($pdo_mock);
        $db->execute_prepared_statement($sql, $params);
    }

    /* @throws Exception */
    public function test_execute_prepared_failed_to_execute(): void
    {
        $this->expectException(GratisException::class);

        $sql = "TEST QUERY";
        $params = ["1", "2"];

        $pdo_mock = $this->createMock(PDO::class);
        $pdo_statement_mock = $this->createMock(PDOStatement::class);

        $pdo_mock->expects($this->once())
            ->method("prepare")
            ->with($sql)
            ->willReturn($pdo_statement_mock);

        $pdo_statement_mock->expects($this->once())
            ->method("execute")
            ->with($params)
            ->willReturn(false);

        $db = new DatabaseStub($pdo_mock);
        $db->execute_prepared_statement($sql, $params);
    }

    /* @throws Exception */
    public function test_fetch_assoc_success(): void
    {
        $sql = "TEST QUERY";
        $expected_name = "phinger";

        $pdo_mock = $this->createMock(PDO::class);
        $pdo_statement_mock = $this->createMock(PDOStatement::class);

        $pdo_mock->expects($this->once())
            ->method("query")
            ->willReturn($pdo_statement_mock);

        $pdo_statement_mock->expects($this->once())
            ->method("fetchAll")
            ->with(PDO::FETCH_ASSOC)
            ->willReturn(["name" => $expected_name]);

        $db = new DatabaseStub($pdo_mock);
        $db->execute_query($sql);
        $result = $db->fetch_assoc();

        $this->assertSame($result["name"], $expected_name);
    }

    /* @throws Exception */
    public function test_fetch_assoc_fail(): void
    {
        $this->expectException(GratisException::class);

        $sql = "TEST QUERY";

        $pdo_mock = $this->createMock(PDO::class);
        $pdo_statement_mock = $this->createMock(PDOStatement::class);

        $pdo_mock->expects($this->once())
            ->method("query")
            ->willReturn($pdo_statement_mock);

        $pdo_statement_mock->expects($this->once())
            ->method("fetchAll")
            ->willThrowException(new PDOException());

        $db = new DatabaseStub($pdo_mock);
        $db->execute_query($sql);
        $db->fetch_assoc();
    }
}
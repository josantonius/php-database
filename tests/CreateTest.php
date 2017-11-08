<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.1.6
 */
namespace Josantonius\Database;

use PHPUnit\Framework\TestCase;

/**
 * Test class for "CREATE" query
 *
 * @since 1.1.6
 */
final class CreateTest extends TestCase
{
    /**
     * Database instance.
     *
     * @since 1.1.7
     *
     * @var object
     */
    private $db;

    /**
     * Setup.
     *
     * @since 1.1.7
     */
    public function setUp()
    {
        parent::setUp();

        $this->db = Database::getConnection(
            'identifier',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );
    }

    /**
     * [QUERY] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     */
    public function testCreateTableQuery()
    {
        $result = $this->db->query(
            'CREATE TABLE IF NOT EXISTS test_table (
                id       INT(6)      UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name     VARCHAR(30) NOT NULL,
                email    VARCHAR(50),
                reg_date TIMESTAMP
            )'
        );

        $this->assertTrue($result);
    }

    /**
     * [QUERY] [CREATE TABLE] [EXCEPTION] [SINTAX ERROR]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (error|syntax|Syntax)
     */
    public function testCreateTableQueryError()
    {
        $result = $this->db->query(
            'CREATE TABLE IF NOT EXISTS test_table (
                id       INT(6)      UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name     VARCHAR(30) NOT NULL,
                email    VARCHAR(50),
                reg_date TIMESTAMP
            '
        );
    }

    /**
     * [METHOD] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     */
    public function testCreateTableMethod()
    {
        $params = [
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(30) NOT NULL',
            'email' => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP',
        ];

        $this->assertTrue(
            $this->db->create($params)
                     ->table('test_table')
                     ->execute()
        );
    }

    /**
     * [METHOD] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     */
    public function testCreateTableMethodExtra()
    {
        $params = [
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(30) NOT NULL',
            'email' => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP',
        ];

        $this->assertTrue(
            $this->db->create($params)
                     ->table('test_table_three')
                     ->execute()
        );
    }

    /**
     * [METHOD] [CREATE TABLE] [EXCEPTION] [SINTAX ERROR]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (error|syntax|Syntax)
     */
    public function testCreateTableMethodError()
    {
        $params = [
            'id' => 'INT(6 UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(30) NOT NULL',
            'email' => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP',
        ];

        $this->db->create($params)
                 ->table('test_table')
                 ->execute();
    }

    /**
     * [METHOD] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     */
    public function testCreateTableAdvancedMethod()
    {
        $params = [
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(30) NOT NULL',
            'email' => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP',
        ];

        $query = $this->db->create($params)
                          ->table('test_table_two')
                          ->foreing('id')
                          ->reference('id')
                          ->on('test_table')
                          ->actions('ON DELETE CASCADE ON UPDATE CASCADE')
                          ->engine('innodb')
                          ->charset('utf8');

        $this->assertTrue($query->execute());
    }

    /**
     * [METHOD] [CREATE TABLE] [EXCEPTION] [SINTAX ERROR]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (error|syntax|Syntax)
     */
    public function testCreateTableAdvancedMethodError()
    {
        $params = [
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(30) NOT NULL',
            'email' => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP',
        ];

        $query = $this->db->create($params)
                          ->table('test_table_two')
                          ->foreing('id')
                          ->reference('id')
                          ->on('test_table')
                          ->actions('ONDELETE CASCADE ON UPDATE CASCADE')
                          ->engine('innodb')
                          ->charset('utf8');

        $query->execute();
    }
}

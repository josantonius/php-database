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
 * Test class for "TRUNCATE" query.
 *
 * @since 1.1.6
 */
final class TruncateTest extends TestCase
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
     *
     * @return void
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
            array('charset' => 'utf8')
        );
    }

    /**
     * [QUERY] [TRUNCATE TABLE]
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testTruncateTableQuery()
    {
        $result = $this->db->query(
            'INSERT INTO test_table_three (name, email)
             VALUES ("Isis", "isis@email.com")'
        );

        $this->assertEquals(1, $result);

        $result = $this->db->query('TRUNCATE TABLE `test_table_three`');

        $this->assertTrue($result);
    }

    /**
     * [QUERY] [TRUNCATE TABLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|not|found|Table|exists)
     *
     * @return void
     */
    public function testTruncateTableQueryTableNameError()
    {
        $result = $this->db->query('TRUNCATE TABLE `xxxx`');
    }

    /**
     * [METHOD] [TRUNCATE TABLE]
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testTruncateTableMethod()
    {
        $data = [
            "name"  => "Isis",
            "email" => "isis@email.com",
        ];

        $query = $this->db->insert($data)
                          ->in('test_table_three');

        $result = $query->execute();

        $this->assertEquals(1, $result);

        $query = $this->db->truncate()
                          ->table('test_table_three');

        $result = $query->execute();

        $this->assertTrue($result);
    }

    /**
     * [METHOD] [TRUNCATE TABLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|not|found|Table|exists)
     *
     * @return void
     */
    public function testTruncateTableMethodTableNameError()
    {
        $query = $this->db->truncate()
                          ->table('xxxx');

        $result = $query->execute();
    }
}

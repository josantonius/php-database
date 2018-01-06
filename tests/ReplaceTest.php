<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.1.6
 */
namespace Josantonius\Database;

use PHPUnit\Framework\TestCase;

/**
 * Test class for "REPLACE" query.
 */
final class ReplaceTest extends TestCase
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
     * [METHOD] [ROWS AFFECTED NUMBER]
     */
    public function testMethodReturnRows()
    {
        $data = [
            'id' => 3008,
            'name' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $query = $this->db->replace($data)
                          ->from('test_table');

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [LAST INSERT ID]
     */
    public function testMethodStatementsAdvancedReturnID()
    {
        $data = [
            'id' => 4889,
            'name' => ':name',
            'email' => ':email',
        ];

        $statements[] = [':name', 'Manny'];
        $statements[] = [':email', 'manny@email.com'];

        $query = $this->db->replace($data, $statements)
                          ->from('test_table');

        $result = $query->execute('id');

        $this->assertSame(4889, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED]
     */
    public function testMethodStatementsDataTypeAvancedReturnRows()
    {
        $data = [
            'id' => 1,
            'name' => ':name',
            'email' => ':email',
        ];

        $statements[] = [':name', 'Manny', 'str'];
        $statements[] = [':email', 'manny@email.com', 'str'];

        $query = $this->db->replace($data, $statements)
                          ->from('test_table');

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     */
    public function testMethodMarksStatementsWhereAdvanceReturnRows()
    {
        $data = [
            'id' => 2,
            'name' => '?',
            'email' => '?',
        ];

        $statements[] = [1, 'Manny'];
        $statements[] = [2, 'manny@email.com'];

        $query = $this->db->replace($data, $statements)
                          ->from('test_table');

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATATYPE] [WHEREADVANCED] [LAST INSERT ID]
     */
    public function testMethodMarksStatementsDataTypeWhereReturnID()
    {
        $data = [
            'id' => 4890,
            'name' => '?',
            'email' => '?',
        ];

        $statements[] = [1, 'Manny', 'str'];
        $statements[] = [2, 'manny@email.com', 'str'];

        $query = $this->db->replace($data, $statements)
                          ->from('test_table');

        $result = $query->execute('id');

        $this->assertSame(4890, $result);
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testMethodTableNameErrorException()
    {
        $data = [
            'id' => 1,
            'name' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $query = $this->db->replace($data)
                          ->from('xxxx');

        $result = $query->execute();
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     */
    public function testMethodColumnNameErrorException()
    {
        $data = [
            'id' => 1,
            'xxxx' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $query = $this->db->replace($data)
                          ->from('test_table');

        $result = $query->execute();
    }
}

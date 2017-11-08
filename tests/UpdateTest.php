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
final class UpdateTest extends TestCase
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
     * [QUERY] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testQueryReturnRows()
    {
        $result = $this->db->query(
            'UPDATE test_table
             SET    name  = "Manny",
                    email = "manny@email.com"'
        );

        $this->assertSame(8, $result);
    }

    /**
     * [QUERY] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testQueryWhereReturnRows()
    {
        $result = $this->db->query(
            "UPDATE test_table
             SET    name  = 'Isis',
                    email = 'isis@email.com'
             WHERE  name  = 'Manny'"
        );

        $this->assertSame(13, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testQueryStatementsWhereReturnRows()
    {
        $statements[] = [':name', 'Manny'];
        $statements[] = [':email', 'manny@email.com'];

        $result = $this->db->query(
            'UPDATE test_table
             SET    name  = :name,
                    email = :email
             WHERE  id    = 3008',
            $statements
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [DATA TYPE] [WHERE MULTIPLE] [ROWS AFFECTED]
     *
     * @since 1.1.6
     */
    public function testQueryStatementsDataTypeWhereMultiple()
    {
        $statements[] = [':name', 'Manny', 'str'];
        $statements[] = [':email', 'manny@email.com', 'str'];

        $result = $this->db->query(
            "UPDATE test_table
             SET    name  = :name,
                    email = :email
             WHERE  id    = 4883 OR name = 'Isis'",
            $statements
        );

        $this->assertSame(12, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testQueryMarksStatementsWhereReturnRows()
    {
        $statements[] = [1, 'Isis'];
        $statements[] = [2, 'isis@email.com'];

        $result = $this->db->query(
            'UPDATE test_table
             SET    name  = ?,
                    email = ?',
            $statements
        );

        $this->assertSame(13, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [DATA TYPE] [WHERE SIMPLE] [ROWS AFFECTED]
     *
     * @since 1.1.6
     */
    public function testQueryMarksStatementsDataTypeWhereReturnRows()
    {
        $statements[] = [1, 'Manny', 'str'];
        $statements[] = [2, 'manny@email.com', 'str'];

        $result = $this->db->query(
            'UPDATE test_table
             SET    name  = ?,
                    email = ?
             WHERE  id    = 1',
            $statements
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testQueryTableNameErrorException()
    {
        $result = $this->db->query(
            'UPDATE xxxx
             SET    name  = "Manny",
                    email = "manny@email.com"'
        );
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     */
    public function testQueryColumnNameErrorException()
    {
        $result = $this->db->query(
            'UPDATE test_table
             SET    xxxx  = "Manny",
                    email = "manny@email.com"'
        );
    }

    /**
     * [METHOD] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testMethodReturnRows()
    {
        $data = [
            'name' => 'Isis',
            'email' => 'isis@email.com',
        ];

        $query = $this->db->update($data)
                          ->in('test_table');

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testMethodWhereReturnRows()
    {
        $data = [
            'name' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $query = $this->db->update($data)
                          ->in('test_table')
                          ->where('id = 3008');

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testMethodWhereMultipleReturnRows()
    {
        $data = [
            'name' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $clauses = [
            'name  = "isis"',
            'email = "isis@email.com"'
        ];

        $query = $this->db->update($data)
                          ->in('test_table')
                          ->where($clauses);

        $result = $query->execute();

        $this->assertSame(12, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testMethodStatementsWhereAdvancedReturnRows()
    {
        $data = [
            'name' => ':new_name',
            'email' => ':new_email',
        ];

        $statements['data'][] = [':new_name', 'Isis'];
        $statements['data'][] = [':new_email', 'isis@email.com'];

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements['clauses'][] = [':id', 3008];
        $statements['clauses'][] = [':name1', 'Isis'];
        $statements['clauses'][] = [':name2', 'Manny'];

        $query = $this->db->update($data, $statements['data'])
                          ->in('test_table')
                          ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertSame(13, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED]
     *
     * @since 1.1.6
     */
    public function testMethodStatementsDataTypeAdvancedReturnRows()
    {
        $data = [
            'name' => ':new_name',
            'email' => ':new_email',
        ];

        $statements['data'][] = [':new_name', 'Manny', 'str'];
        $statements['data'][] = [':new_email', 'manny@email.com', 'str'];

        $clauses = 'name = :name1 OR name = :name2';

        $statements['clauses'][] = [':name1', 'Isis', 'str'];
        $statements['clauses'][] = [':name2', 'Manny', 'str'];

        $query = $this->db->update($data, $statements['data'])
                          ->in('test_table')
                          ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertSame(13, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     */
    public function testMethodMarksStatementsWhereAdvanceReturnRows()
    {
        $data = [
            'name' => '?',
            'email' => '?',
        ];

        $statements['data'][] = [1, 'Isis'];
        $statements['data'][] = [2, 'isis@email.com'];

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements['clauses'][] = [3, 4883];
        $statements['clauses'][] = [4, 'Isis'];
        $statements['clauses'][] = [5, 'Manny'];

        $query = $this->db->update($data, $statements['data'])
                          ->in('test_table')
                          ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertSame(13, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATATYPE] [WHERE ADVANCED] [RETURN ZERO]
     *
     * @since 1.1.6
     */
    public function testMethodMarksStatementsDataTypeReturnZero()
    {
        $data = [
            'name' => '?',
            'email' => '?',
        ];

        $statements['data'][] = [1, 'Manny', 'str'];
        $statements['data'][] = [2, 'manny@email.com', 'str'];

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements['clauses'][] = [3, 8888, 'int'];
        $statements['clauses'][] = [4, 'Isis', 'str'];
        $statements['clauses'][] = [5, 'Manny', 'str'];

        $query = $this->db->update($data, $statements['data'])
                          ->in('test_table')
                          ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertSame(0, $result);
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testMethodTableNameErrorException()
    {
        $data = [
            'name' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $query = $this->db->update($data)
                          ->in('xxxx');

        $result = $query->execute();
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     */
    public function testMethodColumnNameErrorException()
    {
        $data = [
            'xxxx' => 'Manny',
            'email' => 'manny@email.com',
        ];

        $query = $this->db->update($data)
                          ->in('test_table');

        $result = $query->execute();
    }
}

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
 * Test class for "SELECT" query.
 */
final class SelectTest extends TestCase
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
     * [QUERY] [MULTIPLE] [RETURN OBJECT]
     */
    public function testQueryMultipleReturnObject()
    {
        $result = $this->db->query(
            'SELECT id, name, email, reg_date
             FROM test_table'
        );

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [QUERY] [ALL] [LIMIT] [RETURN ARRAY NUMERIC]
     */
    public function testQuerySelectAllLimitReturnArrayNumeric()
    {
        $result = $this->db->query(
            'SELECT *
             FROM test_table
             LIMIT 1',
            false,
            'array_num'
        );

        $this->assertContains('Isis', $result[0][1]);
    }

    /**
     * [QUERY] [MULTIPLE] [WHERE] [ORDER] [RETURN ARRAY ASSOC]
     */
    public function testQueryMultipleWhereOrderReturnArrayAssoc()
    {
        $result = $this->db->query(
            'SELECT id, name, email, reg_date
             FROM test_table
             WHERE id = 3008
             ORDER BY id DESC',
            false,
            'array_assoc'
        );

        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [QUERY] [MULTIPLE] [RETURN ROWS NUMBER]
     */
    public function testQueryMultipleReturnRows()
    {
        $result = $this->db->query(
            'SELECT id, name, email, reg_date
             FROM test_table',
            false,
            'rows'
        );

        $this->assertSame(11, $result);
    }

    /**
     * [QUERY] [MULTIPLE] [STATEMENTS] [WHERE] [RETURN OBJECT]
     */
    public function testQueryMultipleStatementsWhereReturnObject()
    {
        $statements[] = [':id', 4883];

        $result = $this->db->query(
            'SELECT id, name, email, reg_date
             FROM test_table
             WHERE  id = :id',
            $statements
        );

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [QUERY] [MULTIPLE] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testQueryTableNamErrorException()
    {
        $result = $this->db->query(
            'SELECT id, name, email, reg_date
             FROM xxxx'
        );
    }

    /**
     * [QUERY] [MULTIPLE] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     */
    public function testQueryColumnNamErrorException()
    {
        $result = $this->db->query(
            'SELECT xxxx, name, email, reg_date
             FROM test_table'
        );
    }

    /**
     * [METHOD] [ALL] [RETURN OBJECT]
     */
    public function testMethodSelectAllReturnObject()
    {
        $query = $this->db->select()
                          ->from('test_table');

        $result = $query->execute();

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [ALL] [RETURN ARRAY NUMERIC]
     */
    public function testMethodSelectAllNumeric()
    {
        $query = $this->db->select()
                          ->from('test_table');

        $result = $query->execute('array_num');

        $this->assertContains('Isis', $result[0][1]);
    }

    /**
     * [METHOD] [ALL] [RETURN ARRAY ASSOC]
     */
    public function testMethodSelectAllReturnArrayAssoc()
    {
        $query = $this->db->select()
                          ->from('test_table');

        $result = $query->execute('array_assoc');

        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [METHOD] [LIMIT] [RETURN OBJECT]
     */
    public function testMethodLimitReturnObject()
    {
        $query = $this->db->select('name')
                          ->from('test_table')
                          ->limit(1);

        $result = $query->execute();

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [MULTIPLE] [WHERE MULTIPLE] [RETURN ARRAY ASSOC]
     */
    public function testMethodMultipleWhereReturnArrayAssoc()
    {
        $query = $this->db->select(['id', 'name'])
                          ->from('test_table')
                          ->where('id = 3008');

        $result = $query->execute('array_assoc');

        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [METHOD] [SELECT-WHERE MULTIPLE] [ORDER SIMPLE] [LIMIT] [OBJECT]
     */
    public function testMethodMultipleWhereOrderLimitReturnObject()
    {
        $query = $this->db->select(['id', 'name'])
                          ->from('test_table')
                          ->where(['id = 4888', 'name = "Isis"'])
                          ->order('id DESC')
                          ->limit(1);

        $result = $query->execute();

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [SELECT-ORDER-WHERE MULTIPLE] [LIMIT] [RETURN OBJECT]
     */
    public function testMethodOrderWhereMultipleLimitReturnObject()
    {
        $query = $this->db->select(['id', 'name'])
                          ->from('test_table')
                          ->where(['id = 4885', 'name = "Isis"'])
                          ->order(['id DESC', 'name ASC'])
                          ->limit(1);

        $result = $query->execute('obj');

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE MULTIPLE] [RETURN OBJECT]
     */
    public function testMethodStatementsWhereMultipleReturnObject()
    {
        $statements[] = [':id', 3008];
        $statements[] = [':name', 'Isis'];

        $query = $this->db->select('name')
                          ->from('test_table')
                          ->where(['id = :id', 'name = :name'], $statements);

        $result = $query->execute();

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [RETURN ARRAY ASSOC]
     */
    public function testMethodStatementsWhereAdvancedReturnAssoc()
    {
        $id = $GLOBALS['ID'];

        $statements[] = [':id', 4883];
        $statements[] = [':name', 'Isis'];

        $query = $this->db->select('name')
                          ->from('test_table')
                          ->where('id = :id OR name = :name', $statements);

        $result = $query->execute('array_assoc');

        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE MULTIPLE] [RETURN EMPTY ARRAY]
     */
    public function testMethodWhenThereAreNoResults()
    {
        $statements[] = [':id', 8, 'int'];
        $statements[] = [':name', 'Isis', 'str'];
        $statements[] = [':email', null, 'null'];
        $statements[] = [':reg_date', true, 'bool'];

        $clauses = [
            'id       = :id',
            'name     = :name',
            'email    = :email',
            'reg_date = :reg_date',
        ];

        $query = $this->db->select('name')
                          ->from('test_table')
                          ->where($clauses, $statements);

        $result = $query->execute('obj');

        $this->assertCount(0, $result);
    }

    /**
     * [METHOD] [WHERE SIMPLE] [RETURN ROWS NUMBER]
     */
    public function testMethodWhereReturnRows()
    {
        $query = $this->db->select('name')
                          ->from('test_table')
                          ->where('name = "Isis"');

        $result = $query->execute('rows');

        $this->assertSame(11, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [RETURN ROWS NUMBER]
     */
    public function testMethodMarksStatementsAdvancedReturnRows()
    {
        $statements[] = [1, 3008];
        $statements[] = [2, 'Manny'];

        $query = $this->db->select('name')
                          ->from('test_table')
                          ->where('id = ? OR name = ?', $statements);

        $result = $query->execute('rows');

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATATYPE] [WHERE ADVANCED] [RETURN ROWS]
     */
    public function testMethodMarksDataTypeWhereAdvancedReturnRows()
    {
        $statements[] = [1, 4883, 'int'];
        $statements[] = [2, null, 'null'];
        $statements[] = [3, 'Isis', 'str'];
        $statements[] = [4, true, 'bool'];

        $clauses = 'id = ? OR email = ? AND name = ? OR id = ?';

        $query = $this->db->select('name')
                          ->from('test_table')
                          ->where($clauses, $statements);

        $result = $query->execute('rows');

        $this->assertSame(2, $result);
    }

    /**
     * [METHOD] [ALL] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testMethodTableNameErrorException()
    {
        $query = $this->db->select()
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
        $query = $this->db->select('xxxx')
                          ->from('test_table');

        $result = $query->execute();
    }
}

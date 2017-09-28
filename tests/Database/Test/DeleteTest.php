<?php
/**
 * Test class for Database library.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      1.1.6
 */

namespace Josantonius\Database\Test;

use Josantonius\Database\Database,
    PHPUnit\Framework\TestCase;

/**
 * Test class for "DELETE" query.
 *
 * @since 1.1.6
 */
final class DeleteTest extends TestCase {

    /**
     * Get connection test.
     *
     * @since 1.1.6
     *
     * @return object → database connection
     */
    public function testGetConnection() {

        $db = Database::getConnection('identifier');

        $this->assertContains('identifier', $db::$id);

        return $db;
    }

    /**
     * [QUERY] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_ReturnRows($db) {

        $result = $db->query(

            'DELETE 
             FROM  test_table
             WHERE id = 1'
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_Statements_Where_ReturnRows($db) {

        $statements[] = [":id", 2];

        $result = $db->query(

            'DELETE 
             FROM  test_table
             WHERE id = :id',
             $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_Statements_WhereMultiple_ReturnRows($db) {

        $statements[] = [":id",   3];
        $statements[] = [":name", 'isis'];

        $result = $db->query(

            'DELETE 
            FROM  test_table
            WHERE id = :id AND name = :name',
            $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_MarksStatements_Where_ReturnRows($db) {

        $statements[] = [1, 3008];
        $statements[] = [2, 'isis'];

        $result = $db->query(

            'DELETE 
             FROM  test_table
             WHERE id = ? AND name = ?',
             $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [WHERE SIMPLE] [DATA TYPE] [ROWS]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_MarksStatements_Where_DataType_ReturnRows($db) {

        $statements[] = [1, 3009,   'int'];
        $statements[] = [2, 'isis', 'str'];

        $result = $db->query(

            'DELETE 
             FROM  test_table
             WHERE id = ? AND name = ?',
             $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     * 
     * @return void
     */
    public function testQueryTableNameErrorException($db) {

        $result = $db->query('DELETE FROM xxxx');
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     * 
     * @return void
     */
    public function testQueryColumnNameErrorException($db) {

        $result = $db->query(

            'DELETE 
             FROM  test_table
             WHERE xxx = 1'
        );
    }

    /**
     * [METHOD] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_Where_ReturnRows($db) {

        $query = $db->delete()
                    ->from('test_table')
                    ->where('id = 4883');

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_Where_ReturnsRows($db) {

        $clauses = [
            'id = 4884',
            'name  = "isis"',
            'email = "isis@email.com"'
        ];

        $query = $db->delete()
                    ->from('test_table')
                    ->where($clauses);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_Statements_WhereAdvanced_ReturnRows($db) {

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements[] = [':id',    4885];
        $statements[] = [':name1', 'Isis'];
        $statements[] = [':name2', 'Manny'];

        $query = $db->delete()
                    ->from('test_table')
                    ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_Statements_DataType_WhereAdvanced_Rows($db) {

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements[] = [':id',    4886,    'int'];
        $statements[] = [':name1', 'Isis',  'src'];
        $statements[] = [':name2', 'Manny', 'src'];

        $query = $db->delete()
                    ->from('test_table')
                    ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_MarksStatements_WhereAdvanced_ReturnRows($db) {

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements[] = [1, 4887];
        $statements[] = [2, 'Isis'];
        $statements[] = [3, 'Manny'];

        $query = $db->delete()
                    ->from('test_table')
                    ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_MarksStatements_DataType_WhereAdvanced($db) {

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements[] = [1, 4888,    'int'];
        $statements[] = [2, 'Isis',  'str'];
        $statements[] = [3, 'Manny', 'str'];

        $query = $db->delete()
                    ->from('test_table')
                    ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     * 
     * @return void
     */
    public function testMethodTableNameErrorException($db) {

        $query = $db->delete()
                    ->from('xxxx');

        $result = $query->execute();
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     * 
     * @return void
     */
    public function testMethodColumnNameErrorException($db) {

        $query = $db->delete()
                    ->from('test_table')
                    ->where('xxx = 1');

        $result = $query->execute();
    }

    /**
     * [METHOD] [ALL ROWS] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testDeleteAllMethod_ReturnRows($db) {

        $query = $db->delete()
                    ->from('test_table');

        $result = $query->execute();

        $this->assertEquals(2, $result);
    }

    /**
     * [QUERY] [ALL ROWS] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testDeleteAllQuery_ReturnRows($db) {

        $result = $db->query('DELETE FROM test_table');

        $this->assertEquals(0, $result);
    }
}

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
 * Test class for "TRUNCATE" query.
 *
 * @since 1.1.6
 */
final class DatabaseUpdateTest extends TestCase {

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
     * [QUERY] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_ReturnRows($db) {

        $result = $db->query(

            'UPDATE test_table
             SET    name  = "Manny",
                    email = "manny@email.com"'
        );

        $this->assertEquals(8, $result);
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
    public function testQuery_Where_ReturnRows($db) {

        $result = $db->query(

            "UPDATE test_table
             SET    name  = 'Isis',
                    email = 'isis@email.com'
             WHERE  name  = 'Manny'"
        );

        $this->assertEquals(13, $result);
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

        $statements[] = [":name",  "Manny"];
        $statements[] = [":email", "manny@email.com"];

        $result = $db->query(

            "UPDATE test_table
             SET    name  = :name,
                    email = :email
             WHERE  id    = 3008",
            $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [DATA TYPE] [WHERE MULTIPLE] [ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_Statements_DataType_WhereMultiple($db) {

        $statements[] = [":name",  "Manny",           "str"];
        $statements[] = [":email", "manny@email.com", "str"];

        $result = $db->query(

            "UPDATE test_table
             SET    name  = :name,
                    email = :email
             WHERE  id    = 4883 OR name = 'Isis'",
             $statements
        );

        $this->assertEquals(12, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_MarksStatements_Where_ReturnRows($db) {

        $statements[] = [1, "Isis"];
        $statements[] = [2, "isis@email.com"];

        $result = $db->query(

            'UPDATE test_table
             SET    name  = ?,
                    email = ?',
             $statements
        );

        $this->assertEquals(13, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [DATA TYPE] [WHERE SIMPLE] [ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testQuery_MarksStatements_DataType_Where_ReturnRows($db) {

        $statements[] = [1, "Manny",           "str"];
        $statements[] = [2, "manny@email.com", "str"];

        $result = $db->query(

            "UPDATE test_table
             SET    name  = ?,
                    email = ?
             WHERE  id    = 1",
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

        $result = $db->query(

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

            'UPDATE test_table
             SET    xxxx  = "Manny",
                    email = "manny@email.com"'
        );
    }

    /**
     * [METHOD] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_ReturnRows($db) {

        $data = [
            'name'  => 'Isis', 
            'email' => 'isis@email.com'
        ];

        $query = $db->update($data)
                    ->in('test_table');

        $result = $query->execute();

        $this->assertEquals(1, $result);
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

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->update($data)
                    ->in('test_table')
                    ->where('id = 3008');

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
    public function testMethod_WhereMultiple_ReturnRows($db) {

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $clauses = [
            'name  = "isis"',
            'email = "isis@email.com"'];


        $query = $db->update($data)
                    ->in('test_table')
                    ->where($clauses);

        $result = $query->execute();

        $this->assertEquals(12, $result);
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

        $data = [
            'name'  => ':new_name', 
            'email' => ':new_email'
        ];

        $statements['data'][] = [':new_name',  'Isis'];
        $statements['data'][] = [':new_email', 'isis@email.com'];

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements['clauses'][] = [':id',    3008];
        $statements['clauses'][] = [':name1', 'Isis'];
        $statements['clauses'][] = [':name2', 'Manny'];


        $query = $db->update($data, $statements['data'])
                    ->in('test_table')
                    ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertEquals(13, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_Statements_DataType_Advanced_ReturnRows($db) {

        $data = [
            'name'  => ':new_name', 
            'email' => ':new_email'
        ];

        $statements['data'][] = [':new_name',  'Manny',           'str'];
        $statements['data'][] = [':new_email', 'manny@email.com', 'str'];

        $clauses = 'name = :name1 OR name = :name2';

        $statements['clauses'][] = [':name1', 'Isis',  'str'];
        $statements['clauses'][] = [':name2', 'Manny', 'str'];


        $query = $db->update($data, $statements['data'])
                    ->in('test_table')
                    ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_MarksStatements_WhereAdvance_ReturnRows($db) {

        $id = $GLOBALS['ID'];

        $data = [
            'name'  => '?', 
            'email' => '?'
        ];

        $statements['data'][] = [1, 'Isis'];
        $statements['data'][] = [2, 'isis@email.com'];

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements['clauses'][] = [3, $id];
        $statements['clauses'][] = [4, 'Isis'];
        $statements['clauses'][] = [5, 'Manny'];


        $query = $db->update($data, $statements['data'])
                    ->in('test_table')
                    ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATATYPE] [WHERE ADVANCED] [ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_MarksStatements_DataType_ReturnRows($db) {

        $id = $GLOBALS['ID'];

        $data = [
            'name'  => '?', 
            'email' => '?'
        ];

        $statements['data'][] = [1, 'Manny',           'str'];
        $statements['data'][] = [2, 'manny@email.com', 'str'];

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements['clauses'][] = [3, $id,     'int'];
        $statements['clauses'][] = [4, 'Isis',  'str'];
        $statements['clauses'][] = [5, 'Manny', 'str'];


        $query = $db->update($data, $statements['data'])
                    ->in('test_table')
                    ->where($clauses, $statements['clauses']);

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

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->update($data)
                    ->in('xxxx');

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

        $data = [
            'xxxx'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->update($data)
                    ->in('test_table');

        $result = $query->execute();
    }
}

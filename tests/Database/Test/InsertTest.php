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
 * Test class for "INSERT" query.
 *
 * @since 1.1.6
 */
final class InsertTest extends TestCase {

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
     * [QUERY] [RETURN ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertQuery_Rows($db) {

        $result = $db->query(

            'INSERT INTO test_table (name, email)
             VALUES ("Isis", "isis@email.com")'
        );

        $this->assertEquals(1, $result);
    }

   /**
     * [QUERY] [RETURN LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertQuery_ID($db) {

        $result = $db->query(

            'INSERT INTO test_table (name, email)
             VALUES ("Isis", "isis@email.com")', 
             false,
             'id'
         );

        $this->assertInternalType('int', $result);
    }

    /**
     * [QUERY] [STATEMENTS] [RETURN ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertQuery_Statements_Rows($db) {

        $statements[] = [":name",  "Isis"];
        $statements[] = [":email", "isis@email.com"];

        $result = $db->query(

            'INSERT INTO test_table (name, email)
             VALUES (:name, :email)',
             $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [DATA-TYPE] [RETURN ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertQuery_Statements_DataType_Rows($db) {

        $statements[] = [":id",    100,              "int"];
        $statements[] = [":name",  "Isis",           "str"];
        $statements[] = [":email", "isis@email.com", "str"];

        $result = $db->query(

            'INSERT INTO test_table (id, name, email)
             VALUES (:id, :name, :email)',
             $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [DATA-TYPE] [RETURN ROWS AFFECTED] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage Duplicate entry
     * 
     * @return void
     */
    public function testInsertQuery_Duplicate_Statements_DataType_Rows($db) {

        $statements[] = [":id",    100,              "int"];
        $statements[] = [":name",  "Isis",           "str"];
        $statements[] = [":email", "isis@email.com", "str"];

        $result = $db->query(

            'INSERT INTO test_table (id, name, email)
             VALUES (:id, :name, :email)',
             $statements
        );

        $this->assertEquals(1, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [RETURN LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertQuery_Statements_ID($db) {

        $statements[] = [1, "Isis"];
        $statements[] = [2, "isis@email.com"];

        $result = $db->query(

            'INSERT INTO test_table (name, email)
             VALUES (?, ?)',
             $statements,
             'id'
        );

        $this->assertInternalType('int', $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [DATA-TYPE] [RETURN LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertQuery_Statements_DataType_ID($db) {

        $statements[] = [1, 200,              "int"];
        $statements[] = [2, "Isis",           "str"];
        $statements[] = [3, "isis@email.com", "str"];

        $result = $db->query(

            'INSERT INTO test_table (id, name, email)
             VALUES (?, ?, ?)',
             $statements,
             'id'
        );

        $this->assertEquals(200, $result);
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
    public function testInsertQueryTableNameError($db) {

        $result = $db->query(

            'INSERT INTO xxxx (name, email)
             VALUES ("Isis", "isis@email.com")'
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
    public function testInsertQueryColumnNameError($db) {

        $result = $db->query(

            'INSERT INTO test_table (xxxx, email)
             VALUES ("Isis", "isis@email.com")'
        );
    }

    /**
     * [METHOD] [RETURN ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertMethod_Rows($db) {

        $data = [
            "name"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = $db->insert($data)
                    ->in('test_table');

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [RETURN LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertMethod_Statements_ID($db) {

        $statements[] = [":name",  "Isis",           "str"];
        $statements[] = [":email", "isis@email.com", "str"];

        $data = [
            "name"  => ":name", 
            "email" => ":email"
        ];

        $query = $db->insert($data, $statements)
                    ->in('test_table');

        $result = $query->execute('id');

        $this->assertInternalType('int', $result);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [RETURN LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertMethod_Statements_DataType_ID($db) {

        $statements[] = [":name",  "Isis"];
        $statements[] = [":email", "isis@email.com"];

        $data = [
            "name"  => ":name", 
            "email" => ":email"
        ];

        $query = $db->insert($data, $statements)
                    ->in('test_table');

        $result = $query->execute('id');

        $this->assertInternalType('int', $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [RETURN LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertMethod_Marks_Statements_ID($db) {

        $statements[] = [1, "Isis"];
        $statements[] = [2, "isis@email.com"];

        $data = [
            "name"  => "?", 
            "email" => "?"
        ];

        $query = $db->insert($data, $statements)
                    ->in('test_table');

        $result = $query->execute('id');

        $this->assertInternalType('int', $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATA-TYPE] [RETURN ROWS AFFECTED]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testInsertMethod_Marks_DataType_Rows($db) {

        $statements[] = [1, "Isis",           "str"];
        $statements[] = [2, "isis@email.com", "str"];

        $data = [
            "name"  => "?", 
            "email" => "?"
        ];

        $query = $db->insert($data, $statements)
                    ->in('test_table');

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
    public function testInsertMethodTableNameError($db) {

        $data = [
            "name"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = $db->insert($data)
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
    public function testInsertMethodColumnNameError($db) {

        $data = [
            "xxxx"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = $db->insert($data)
                    ->in('test_table');

        $result = $query->execute();
    }
}

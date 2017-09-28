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
 * Test class for "REPLACE" query.
 *
 * @since 1.1.6
 */
final class ReplaceTest extends TestCase {

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
            'id'    => 3008,
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->replace($data)
                    ->from('test_table');
 
        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_Statements_Advanced_ReturnID($db) {

        $data = [
            'id'    => 4889,
            'name'  => ':name', 
            'email' => ':email'
        ];

        $statements[] = [':name',  'Manny'];
        $statements[] = [':email', 'manny@email.com'];

        $query = $db->replace($data, $statements)
                    ->from('test_table');

        $result = $query->execute('id');

        $this->assertEquals(4889, $result);
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
    public function testMethod_Statements_DataType_Avanced_ReturnRows($db) {

        $data = [
            'id'    => 1,
            'name'  => ':name', 
            'email' => ':email'
        ];

        $statements[] = [':name',  'Manny',           'str'];
        $statements[] = [':email', 'manny@email.com', 'str'];

        $query = $db->replace($data, $statements)
                    ->from('test_table');

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

        $data = [
            'id'    => 2,
            'name'  => '?', 
            'email' => '?'
        ];

        $statements[] = [1, 'Manny'];
        $statements[] = [2, 'manny@email.com'];

        $query = $db->replace($data, $statements)
                    ->from('test_table');

        $result = $query->execute();

        $this->assertEquals(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATATYPE] [WHEREADVANCED] [LAST INSERT ID]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testMethod_MarksStatements_DataType_Where_ReturnID($db) {

        $data = [
            'id'    => 4890,
            'name'  => '?', 
            'email' => '?'
        ];

        $statements[] = [1, 'Manny',           'str'];
        $statements[] = [2, 'manny@email.com', 'str'];

        $query = $db->replace($data, $statements)
                    ->from('test_table');

        $result = $query->execute('id');

        $this->assertEquals(4890, $result);
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
            'id'    => 1,
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->replace($data)
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

        $data = [
            'id'    => 1,
            'xxxx'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->replace($data)
                    ->from('test_table');

        $result = $query->execute();
    }
}

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
class DatabaseReplaceTest extends TestCase {

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
     * [METHOD] [ALL ROWS] [ROWS AFFECTED NUMBER]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testReplaceMethod_AllRows_RowsAffected($db) {

        $data = [
            'id'    => $GLOBALS['ID'],
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = $db->replace($data)
                    ->from('test_table');
 
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
    public function testReplaceMethod_Statements_Where_Advanced_Rows($db) {

        $data = [
            'id'    => $GLOBALS['ID'],
            'name'  => ':name', 
            'email' => ':email'
        ];

        $statements[] = [':name',  'Isis'];
        $statements[] = [':email', 'isis@email.com'];

        $query = $db->replace($data, $statements)
                    ->from('test_table');

        $result = $query->execute();

        $this->assertEquals(1, $result);
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
    public function testReplaceMethod_Statements_DataType_WhereAvanced($db) {

        $GLOBALS['ID'] = rand(1, 999999);

        $data = [
            'id'    => $GLOBALS['ID'],
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
    public function testReplaceMethod_MarksStatements_WhereAdvance_Rows($db) {

        $data = [
            'id'    => $GLOBALS['ID'],
            'name'  => '?', 
            'email' => '?'
        ];

        $statements[] = [1, 'Isis'];
        $statements[] = [2, 'isis@email.com'];

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
    public function testReplaceMethod_MarksStatements_DataType_Where($db) {

        $data = [
            'id'    => $GLOBALS['ID'],
            'name'  => '?', 
            'email' => '?'
        ];

        $statements[] = [1, 'Isis',           'str'];
        $statements[] = [2, 'isis@email.com', 'str'];

        $query = $db->replace($data, $statements)
                    ->from('test_table');

        $result = $query->execute('id');

        $this->assertInternalType('int', $result);
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
    public function testReplaceMethodTableNameError($db) {

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
    public function testReplaceMethodColumnNameError($db) {

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

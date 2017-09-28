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
class TruncateTest extends TestCase {

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
     * [QUERY] [TRUNCATE TABLE] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testTruncateTableQuery($db) {

        $result = $db->query(

            'INSERT INTO test_table_three (name, email)
             VALUES ("Isis", "isis@email.com")'
        );

        $this->assertEquals(1, $result);
        
        $result = $db->query('TRUNCATE TABLE `test_table_three`');

        $this->assertTrue($result);
    }

    /**
     * [QUERY] [TRUNCATE TABLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|not|found|Table|exists)
     * 
     * @return void
     */
    public function testTruncateTableQueryTableNameError($db) {

        $result = $db->query('TRUNCATE TABLE `xxxx`');
    }

    /**
     * [METHOD] [TRUNCATE TABLE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testTruncateTableMethod($db) {

        $data = [
            "name"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = $db->insert($data)
                    ->in('test_table_three');

        $result = $query->execute();

        $this->assertEquals(1, $result);

        $query = $db->truncate()
                    ->table('test_table_three');

        $result = $query->execute();

        $this->assertTrue($result);
    }

    /**
     * [METHOD] [TRUNCATE TABLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|not|found|Table|exists)
     * 
     * @return void
     */
    public function testTruncateTableMethodTableNameError($db) {

        $query = $db->truncate()
                    ->table('xxxx');

        $result = $query->execute();
    }
}

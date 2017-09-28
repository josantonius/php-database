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
 * Test class for "DROP TABLE" query.
 *
 * @since 1.1.6
 */
class DropTest extends TestCase {
    
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
     * [QUERY] [DROP TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testDropTableQuery($db) {

        $result = $db->query('DROP TABLE `test_table_two`');

        $this->assertTrue($result);
    }

    /**
     * [METHOD] [PDO-METHOD] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testDropTableMethod($db) {

        $query = $db->drop()->table('test_table');

        $result = $query->execute();
        
        $this->assertTrue($result);
    }

    /**
     * [METHOD] [PDO-METHOD] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testDropTableMethodExtra($db) {

        $query = $db->drop()->table('test_table_three');

        $result = $query->execute();
        
        $this->assertTrue($result);
    }
}

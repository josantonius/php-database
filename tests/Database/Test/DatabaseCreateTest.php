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


final class DatabaseCreateTest extends TestCase {

    /**
     * Get connection test.
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testGetConnection() {

        $db = Database::getConnection('identifier');

        $this->assertContains('identifier', $db::$id);

        return $db;
    }

    /**
     * [QUERY] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @return void
     */
    public function testCreateTableQuery($db) {

        $result = $db->query(

            'CREATE TABLE IF NOT EXISTS test (

                id       INT(6)      UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                name     VARCHAR(30) NOT NULL,
                email    VARCHAR(50),
                reg_date TIMESTAMP
            )'
        );

        $this->assertTrue($result);
    }

}

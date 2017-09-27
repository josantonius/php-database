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

    private $db;

    /**
     * Get connection test.
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testGetConnection() {

        $this->db = Database::getConnection('identifier');

        $database = $this->db;

        $this->assertContains('identifier', $database::$id);
    }

    /**
     * [QUERY] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     */
    public static function testCreateTableQuery() {


        $result = $this->db->query(

            'CREATE TABLE IF NOT EXISTS test (

                id       INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                name     VARCHAR(30) NOT NULL,
                email    VARCHAR(50),
                reg_date TIMESTAMP
            )'
        );

        $this->assertContains('identifier', $result);
    }

}

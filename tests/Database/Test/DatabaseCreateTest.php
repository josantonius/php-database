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


class DatabaseCreateTest extends TestCase {

    protected $db;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function testGetConnection() {

        $this->db = Database::getConnection(

            'identifier',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );

        $this->assertContains(

            'Josantonius\Database\Database', 
            get_class($this->db)
        );
    }
}

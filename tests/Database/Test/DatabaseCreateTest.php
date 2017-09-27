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

    public static $db;

    /**
     * Get connection test.
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testGetConnection() {

        self::$db = Database::getConnection('identifier');

        $this->assertContains('identifier', self::$db::$id);
    }


   
}

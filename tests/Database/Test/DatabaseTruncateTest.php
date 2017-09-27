<?php
/**
 * Test class for Database library.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      1.0.0
 */

namespace Josantonius\Database\Tests;

use Josantonius\Database\Database;

/**
 * Test class for "TRUNCATE" query.
 *
 * @since 1.0.0
 */
class DatabaseTruncateTest {

    /**
     * Object with connection.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $db;

    /**
     * Connection to the PDO database provider.
     * 
     * @return object
     *
     * @since 1.0.0
     */
    public static function testGetConnectionPDOProvider() {

        if (is_null(static::$db)) {

            static::$db = Database::getConnection(
                                        'identifier-PDO',
                                        'PDOprovider',
                                        'localhost',
                                        'db-user',
                                        'db-name',
                                        'password',
                                        array('charset' => 'utf8'));
        }

        return static::$db;
    }

    /**
     * Connection to the MSSQL database provider.
     * 
     * @return object
     *
     * @since 1.0.0
     */
    public static function testGetConnectionMSSQLProvider() {

        if (is_null(static::$db)) {

            static::$db = Database::getConnection(
                                        'identifier-MSSQL',
                                        'MSSQLprovider',
                                        'localhost',
                                        'db-user',
                                        'db-name',
                                        'password',
                                        array('port' => '4437'));
        }

        return static::$db;
    }

    /**
     * [QUERY] [TRUNCATE TABLE] 
     *
     * @since 1.0.0
     */
    public static function testTruncateTableQuery() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('TRUNCATE TABLE `test`');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [TRUNCATE TABLE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testTruncateTableQueryTableNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('TRUNCATE TABLE `xxxx`');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [TRUNCATE TABLE]
     *
     * @since 1.0.0
     */
    public static function testTruncateTableMethod() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->truncate()
                            ->table('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [TRUNCATE TABLE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testTruncateTableMethodTableNameError() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->truncate()
                            ->table('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

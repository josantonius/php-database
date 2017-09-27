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
 * Test class for "DROP TABLE" query.
 *
 * @since 1.0.0
 */
class DatabaseDropTest {

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
     * [QUERY] [DROP TABLE] [RETURN TRUE]
     *
     * @since 1.0.0
     */
    public static function testDropTableQuery() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('DROP TABLE `test`');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [PDO-METHOD] [RETURN TRUE]
     *
     * @since 1.0.0
     */
    public static function testDropTableMethod() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->drop()
                            ->table('test');

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

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
 * Test class for "CREATE TABLE" query.
 *
 * @since 1.0.0
 */
class DatabaseCreateTest {

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
     * [QUERY] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.0.0
     */
    public static function testCreateTableQuery() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('CREATE TABLE IF NOT EXISTS test (
                                      id       INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                      name     VARCHAR(30) NOT NULL,
                                      email    VARCHAR(50),
                                      reg_date TIMESTAMP)');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.0.0
     */
    public static function testCreateTableMethod() {

        static::testGetConnectionPDOProvider();

        $params = [
            'id'       => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', 
            'name'     => 'VARCHAR(30) NOT NULL',
            'email'    => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP'
        ];

        $query = static::$db->create($params)
                            ->table('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

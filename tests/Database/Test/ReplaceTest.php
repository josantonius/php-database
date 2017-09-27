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
 * Test class for "REPLACE" query.
 *
 * @since 1.0.0
 */
class DatabaseReplaceTest {

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
     * [METHOD] [REPLACE] [ALL ROWS] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethod1() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->replace($data)
                            ->from('test');
 
        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [REPLACE] [STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethod2() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'name'  => ':name', 
            'email' => ':email'
        ];

        $statements[] = [':name',  'Isis'];
        $statements[] = [':email', 'isis@email.com'];

        $query = static::$db->replace($data, $statements)
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [REPLACE] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethod3() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'name'  => ':name', 
            'email' => ':email'
        ];

        $statements[] = [':name',  'Manny',           'str'];
        $statements[] = [':email', 'manny@email.com', 'str'];

        $query = static::$db->replace($data, $statements)
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [REPLACE] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethod4() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'name'  => '?', 
            'email' => '?'
        ];

        $statements[] = [1, 'Isis'];
        $statements[] = [2, 'isis@email.com'];

        $query = static::$db->replace($data, $statements)
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [REPLACE] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethod5() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'name'  => '?', 
            'email' => '?'
        ];

        $statements[] = [1, 'Isis',           'str'];
        $statements[] = [2, 'isis@email.com', 'str'];

        $query = static::$db->replace($data, $statements)
                            ->from('test');

        $result = $query->execute('id');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [REPLACE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethodTableNameError() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->replace($data)
                            ->from('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [REPLACE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testReplaceMethodColumnNameError() {

        static::testGetConnectionPDOProvider();

        $data = [
            'id'    => 1,
            'xxxx'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->replace($data)
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

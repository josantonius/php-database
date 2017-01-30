<?php 
/**
 * Test class for Database library.
 * 
 * @category   JST
 * @package    Database
 * @subpackage Tests\DatabaseInsertTest
 * @author     Josantonius - info@josantonius.com
 * @copyright  Copyright (c) 2017 JST PHP Framework
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @version    1.1.0
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      File available since 1.0.0 - Update: 2017-01-30
 */

namespace Josantonius\Database\Tests;

use Josantonius\Database\Database;

/**
 * Test class for "INSERT" query.
 *
 * @since 1.0.0
 */
class DatabaseInsertTest {

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
     * [QUERY] [RETURN ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testInsertQuery1() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('INSERT INTO test (name, email)
                                      VALUES ("Isis", "isis@email.com")');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [RETURN LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testInsertQuery2() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('INSERT INTO test (name, email)
                                      VALUES ("Isis", "isis@email.com")', 
                                      false,
                                      'id');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [STATEMENTS] [RETURN ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testInsertQuery3() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":name",  "Isis"];
        $statements[] = [":email", "isis@email.com"];

        $result = static::$db->query('INSERT INTO test (name, email)
                                      VALUES (:name, :email)',
                                      $statements);


        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [STATEMENTS] [DATA-TYPE] [RETURN ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testInsertQuery4() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":id",    100,              "int"];
        $statements[] = [":name",  "Isis",           "str"];
        $statements[] = [":email", "isis@email.com", "str"];

        $result = static::$db->query('INSERT INTO test (id, name, email)
                                      VALUES (:id, :name, :email)',
                                      $statements);


        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [RETURN LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testInsertQuery5() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, "Isis"];
        $statements[] = [2, "isis@email.com"];

        $result = static::$db->query('INSERT INTO test (name, email)
                                      VALUES (?, ?)',
                                      $statements,
                                      'id');


        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [DATA-TYPE] [RETURN LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testInsertQuery6() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, 200,              "int"];
        $statements[] = [2, "Isis",           "str"];
        $statements[] = [3, "isis@email.com", "str"];

        $result = static::$db->query('INSERT INTO test (id, name, email)
                                      VALUES (?, ?, ?)',
                                      $statements,
                                      'id');


        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testInsertQueryTableNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('INSERT INTO xxxx (name, email)
                                      VALUES ("Isis", "isis@email.com")');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testInsertQueryColumnNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('INSERT INTO test (xxxx, email)
                                      VALUES ("Isis", "isis@email.com")');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [RETURN ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testInsertMethod1() {

        static::testGetConnectionPDOProvider();

        $data = [
            "name"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = static::$db->insert($data)
                            ->in('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [RETURN LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testInsertMethod2() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":name",  "Isis"];
        $statements[] = [":email", "isis@email.com"];

        $data = [
            "name"  => ":name", 
            "email" => ":email"
        ];

        $query = static::$db->insert($data, $statements)
                            ->in('test');

        $result = $query->execute('id');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [STATEMENTS] [RETURN LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testInsertMethod3() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":name",  "Isis",           "str"];
        $statements[] = [":email", "isis@email.com", "str"];

        $data = [
            "name"  => ":name", 
            "email" => ":email"
        ];

        $query = static::$db->insert($data, $statements)
                            ->in('test');

        $result = $query->execute('id');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [RETURN LAST INSERT ID]
     *
     * @since 1.0.0
     */
    public static function testInsertMethod4() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, "Isis"];
        $statements[] = [2, "isis@email.com"];

        $data = [
            "name"  => "?", 
            "email" => "?"
        ];

        $query = static::$db->insert($data, $statements)
                            ->in('test');

        $result = $query->execute('id');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATA-TYPE] [RETURN ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testInsertMethod5() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, "Isis",           "str"];
        $statements[] = [2, "isis@email.com", "str"];

        $data = [
            "name"  => "?", 
            "email" => "?"
        ];

        $query = static::$db->insert($data, $statements)
                            ->in('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testInsertMethodTableNameError() {

        static::testGetConnectionPDOProvider();

        $data = [
            "name"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = static::$db->insert($data)
                            ->in('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testInsertMethodColumnNameError() {

        static::testGetConnectionPDOProvider();

        $data = [
            "xxxx"  => "Isis", 
            "email" => "isis@email.com"
        ];

        $query = static::$db->insert($data)
                            ->in('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}
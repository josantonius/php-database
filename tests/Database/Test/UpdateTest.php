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
class DatabaseUpdateTest {

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
     * [QUERY] [UPDATE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateQuery1() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('UPDATE test
                                      SET    name  = "Manny",
                                             email = "manny@email.com"');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateQuery2() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('UPDATE test
                                      SET    name  = "Manny",
                                             email = "manny@email.com"
                                      WHERE  id = 1');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateQuery3() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":name",  "Manny"];
        $statements[] = [":email", "manny@email.com"];

        $result = static::$db->query('UPDATE test
                                      SET    name  = :name,
                                             email = :email
                                      WHERE  id = 1',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [STATEMENTS] [DATA TYPE] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateQuery4() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":name",  "Manny",           "str"];
        $statements[] = [":email", "manny@email.com", "str"];

        $result = static::$db->query('UPDATE test
                                      SET    name  = :name,
                                             email = :email
                                      WHERE  id = 1 OR name = "Manny"',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [MARKS STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateQuery5() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, "Manny"];
        $statements[] = [2, "manny@email.com"];

        $result = static::$db->query('UPDATE test
                                      SET    name  = ?,
                                             email = ?
                                      WHERE  id = 1',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [MARKS STATEMENTS] [DATA TYPE] [WHERE SIMPLE] [ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testUpdateQuery6() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, "Manny",           "str"];
        $statements[] = [2, "manny@email.com", "str"];

        $result = static::$db->query('UPDATE test
                                      SET    name  = ?,
                                             email = ?
                                      WHERE  id = 1',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testUpdateQueryTableNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('UPDATE xxxx
                                      SET    name  = "Manny",
                                             email = "manny@email.com"');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [UPDATE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testUpdateQueryColumnNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('UPDATE test
                                      SET    xxxx  = "Manny",
                                             email = "manny@email.com"');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod1() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->update($data)
                            ->in('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod2() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->update($data)
                            ->in('test')
                            ->where('id = 1');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod3() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $clauses = [
            'id = 1',
            'name  = "isis"',
            'email = "isis@email.com"'];


        $query = static::$db->update($data)
                            ->in('test')
                            ->where($clauses);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod4() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => ':new_name', 
            'email' => ':new_email'
        ];

        $statements['data'][] = [':new_name',  'Manny'];
        $statements['data'][] = [':new_email', 'manny@email.com'];

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements['clauses'][] = [':id',         1];
        $statements['clauses'][] = [':name1',     'Isis'];
        $statements['clauses'][] = [':name2',     'Manny'];


        $query = static::$db->update($data, $statements['data'])
                            ->in('test')
                            ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod5() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => ':new_name', 
            'email' => ':new_email'
        ];

        $statements['data'][] = [':new_name',  'Manny',           'str'];
        $statements['data'][] = [':new_email', 'manny@email.com', 'str'];

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements['clauses'][] = [':id',         1,      'int'];
        $statements['clauses'][] = [':name1',     'Isis',  'str'];
        $statements['clauses'][] = [':name2',     'Manny', 'str'];


        $query = static::$db->update($data, $statements['data'])
                            ->in('test')
                            ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod6() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => '?', 
            'email' => '?'
        ];

        $statements['data'][] = [1,  'Manny'];
        $statements['data'][] = [2, 'manny@email.com'];

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements['clauses'][] = [3, 1];
        $statements['clauses'][] = [4, 'Isis'];
        $statements['clauses'][] = [5, 'Manny'];


        $query = static::$db->update($data, $statements['data'])
                            ->in('test')
                            ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethod7() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => '?', 
            'email' => '?'
        ];

        $statements['data'][] = [1, 'Manny',           'str'];
        $statements['data'][] = [2, 'manny@email.com', 'str'];

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements['clauses'][] = [3, 1,       'int'];
        $statements['clauses'][] = [4, 'Isis',  'str'];
        $statements['clauses'][] = [5, 'Manny', 'str'];


        $query = static::$db->update($data, $statements['data'])
                            ->in('test')
                            ->where($clauses, $statements['clauses']);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethodTableNameError() {

        static::testGetConnectionPDOProvider();

        $data = [
            'name'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->update($data)
                            ->in('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [UPDATE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testUpdateMethodColumnNameError() {

        static::testGetConnectionPDOProvider();

        $data = [
            'xxxx'  => 'Manny', 
            'email' => 'manny@email.com'
        ];

        $query = static::$db->update($data)
                            ->in('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

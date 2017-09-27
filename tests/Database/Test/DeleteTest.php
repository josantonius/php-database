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
 * Test class for "DELETE" query.
 *
 * @since 1.0.0
 */
class DatabaseDeleteTest {

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
     * [QUERY] [DELETE] [ALL ROWS] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteQuery1() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('DELETE FROM test');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteQuery2() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('DELETE 
                                      FROM  test
                                      WHERE id = 1');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteQuery3() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":id", 1];

        $result = static::$db->query('DELETE 
                                      FROM  test
                                      WHERE id = :id',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [STATEMENTS] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteQuery4() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":id",   1];
        $statements[] = [":name", 'isis'];

        $result = static::$db->query('DELETE 
                                      FROM  test
                                      WHERE id = :id AND name = :name',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [MARKS STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteQuery5() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, 1];
        $statements[] = [2, 'isis'];

        $result = static::$db->query('DELETE 
                                      FROM  test
                                      WHERE id = ? AND name = ?',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [MARKS STATEMENTS] [WHERE SIMPLE] [DATA TYPE] [ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testDeleteQuery6() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, 1,      'int'];
        $statements[] = [2, 'isis', 'str'];

        $result = static::$db->query('DELETE 
                                      FROM  test
                                      WHERE id = ? AND name = ?',
                                      $statements);

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testDeleteQueryTableNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('DELETE FROM xxxx');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [DELETE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testDeleteQueryColumnNameError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('DELETE 
                                      FROM  test
                                      WHERE xxx = 1');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [ALL ROWS] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod1() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->delete()
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod2() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->delete()
                            ->from('test')
                            ->where('id = 1');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod3() {

        static::testGetConnectionPDOProvider();

        $clauses = [
            'id = 1',
            'name  = "isis"',
            'email = "isis@email.com"'];


        $query = static::$db->delete()
                            ->from('test')
                            ->where($clauses);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod4() {

        static::testGetConnectionPDOProvider();

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements[] = [':id',    1];
        $statements[] = [':name1', 'Isis'];
        $statements[] = [':name2', 'Manny'];

        $query = static::$db->delete()
                            ->from('test')
                            ->where($clauses, $statements);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod5() {

        static::testGetConnectionPDOProvider();

        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements[] = [':id',    1,       'int'];
        $statements[] = [':name1', 'Isis',  'src'];
        $statements[] = [':name2', 'Manny', 'src'];

        $query = static::$db->delete()
                            ->from('test')
                            ->where($clauses, $statements);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod6() {

        static::testGetConnectionPDOProvider();

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements[] = [1, 1];
        $statements[] = [2, 'Isis'];
        $statements[] = [3, 'Manny'];

        $query = static::$db->delete()
                            ->from('test')
                            ->where($clauses, $statements);

        $result = $query->execute('id');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS AFFECTED]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethod7() {

        static::testGetConnectionPDOProvider();

        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements[] = [1, 1,       'int'];
        $statements[] = [2, 'Isis',  'str'];
        $statements[] = [3, 'Manny', 'str'];

        $query = static::$db->delete()
                            ->from('test')
                            ->where($clauses, $statements);

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethodTableNameError() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->delete()
                            ->from('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [DELETE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testDeleteMethodColumnNameError() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->delete()
                            ->from('test')
                            ->where('xxx = 1');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

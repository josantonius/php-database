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
 * Test class for "SELECT" query.
 *
 * @since 1.0.0
 */
class DatabaseSelectTest {

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
     * [QUERY] [SELECT MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.0.0
     */
    public static function testSelectQuery1() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('SELECT id, name, email, reg_date
                                      FROM test');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT ALL] [LIMIT] [RETURN ARRAY NUMERIC] 
     *
     * @since 1.0.0
     */
    public static function testSelectQuery2() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('SELECT *
                                      FROM test
                                      LIMIT 1',
                                      false,
                                      'array_num');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [WHERE] [ORDER] [RETURN ARRAY ASSOC]
     *
     * @since 1.0.0
     */
    public static function testSelectQuery3() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('SELECT id, name, email, reg_date
                                      FROM test
                                      WHERE id = 1
                                      ORDER BY id DESC',
                                      false,
                                      'array_assoc');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [RETURN ROWS NUMBER] 
     *
     * @since 1.0.0
     */
    public static function testSelectQuery4() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('SELECT id, name, email, reg_date
                                      FROM test',
                                      false,
                                      'rows');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [STATEMENTS] [WHERE] [RETURN OBJECT] 
     *
     * @since 1.0.0
     */
    public static function testSelectQuery5() {

        static::testGetConnectionPDOProvider();

        $statements[] = [":id",  1];

        $result = static::$db->query('SELECT id, name, email, reg_date
                                      FROM test
                                      WHERE  id = :id',
                                      $statements);


        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testSelectQueryTableNamError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('SELECT id, name, email, reg_date
                                      FROM xxxx');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [EXCEPTION]
     *
     * @since 1.0.0
     */
    public static function testSelectQueryColumnNamError() {

        static::testGetConnectionPDOProvider();

        $result = static::$db->query('SELECT xxxx, name, email, reg_date
                                      FROM test');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT ALL] [RETURN OBJECT] 
     *
     * @since 1.0.0
     */
    public static function testSelectMethod1() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select()
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT ALL] [RETURN ARRAY NUMERIC]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod2() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select()
                            ->from('test');

        $result = $query->execute('array_num');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }


    /**
     * [METHOD] [SELECT ALL] [RETURN ARRAY ASSOC]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod3() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select()
                            ->from('test');

        $result = $query->execute('array_assoc');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [LIMIT] [RETURN OBJECT]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod4() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select('name')
                            ->from('test')
                            ->limit(1);

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT MULTIPLE] [WHERE MULTIPLE] [RETURN ARRAY ASSOC]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod5() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select(['id', 'name'])
                            ->from('test')
                            ->where('id = 1');

        $result = $query->execute('array_assoc');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT MULTIPLE] [ORDER SIMPLE] [LIMIT] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod6() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select(['id', 'name'])
                            ->from('test')
                            ->where(['id = 1', 'name = "Isis"'])
                            ->order('id DESC')
                            ->limit(1);

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT MULTIPLE] [ORDER MULTIPLE] [LIMIT] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod7() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select(['id', 'name'])
                            ->from('test')
                            ->where(['id = 1', 'name = "isis"'])
                            ->order(['id DESC', 'name ASC'])
                            ->limit(1);

        $result = $query->execute('obj');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [STATEMENTS] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod8() {

        static::testGetConnectionPDOProvider();

        $statements[] = [':id', 1];
        $statements[] = [':name', 'Isis'];

        $query = static::$db->select('name')
                            ->from('test')
                            ->where(['id = :id', 'name = :name'], $statements);

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [STATEMENTS] [WHERE ADVANCED] [RETURN ARRAY ASSOC]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod9() {

        static::testGetConnectionPDOProvider();

        $statements[] = [':id', 1];
        $statements[] = [':name', 'Isis'];

        $query = static::$db->select('name')
                            ->from('test')
                            ->where('id = :id OR name = :name', $statements);

        $result = $query->execute('array_assoc');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [STATEMENTS] [DATA-TYPE] [WHERE MULTIPLE] [RETURN EMPTY ARRAY]
     *
     * @since 1.0.0
     */
    public static function testSelectMethod10() {

        static::testGetConnectionPDOProvider();

        $statements[] = [':id',          1, 'int'];
        $statements[] = [':name',  'Isis', 'str'];
        $statements[] = [':email',    null, 'null'];
        $statements[] = [':reg_date', true, 'bool'];

        $clauses = [
            'id       = :id',
            'name     = :name',
            'email    = :email',
            'reg_date = :reg_date'];

        $query = static::$db->select('name')
                            ->from('test')
                            ->where($clauses, $statements);

        $result = $query->execute('obj');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [WHERE SIMPLE] [RETURN ROWS NUMBER] 
     *
     * @since 1.0.0
     */
    public static function testSelectMethod11() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select('name')
                            ->from('test')
                            ->where('name = "Isis"');

        $result = $query->execute('rows');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [MARKS STATEMENTS] [WHERE ADVANCED] [RETURN ROWS NUMBER] 
     *
     * @since 1.0.0
     */
    public static function testSelectMethod12() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1, 1];
        $statements[] = [2, 'Isis'];

        $query = static::$db->select('name')
                            ->from('test')
                            ->where('id = ? OR name = ?', $statements);

        $result = $query->execute('rows');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [RETURN ROWS NUMBER]  
     *
     * @since 1.0.0
     */
    public static function testSelectMethod13() {

        static::testGetConnectionPDOProvider();

        $statements[] = [1,       1, 'int'];
        $statements[] = [2,    null, 'null'];
        $statements[] = [3, 'Isis', 'str'];
        $statements[] = [4,    true, 'bool'];

        $clauses = 'id = ? OR email = ? AND name = ? OR id = ?';

        $query = static::$db->select('name')
                            ->from('test')
                            ->where($clauses, $statements);

        $result = $query->execute('rows');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT ALL] [EXCEPTION] 
     *
     * @since 1.0.0
     */
    public static function testSelectMethodTableNameError() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select()
                            ->from('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [EXCEPTION] 
     *
     * @since 1.0.0
     */
    public static function testSelectMethodColumnNameError() {

        static::testGetConnectionPDOProvider();

        $query = static::$db->select('xxxx')
                            ->from('test');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

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

/**
 * Test class for "SELECT" query.
 *
 * @since 1.1.6
 */
final class SelectTest extends TestCase {

    /**
     * Get connection test.
     *
     * @since 1.1.6
     *
     * @return object → database connection
     */
    public function testGetConnection() {

        $db = Database::getConnection('identifier');

        $this->assertContains('identifier', $db::$id);

        return $db;
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectQuery_Multiple_Object($db) {

        $result = $db->query(

            'SELECT id, name, email, reg_date
             FROM test_table'
        );

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [QUERY] [SELECT ALL] [LIMIT] [RETURN ARRAY NUMERIC] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectQuery_SelectAll_Limit_Numeric($db) {

        $result = $db->query(

            'SELECT *
             FROM test_table
             LIMIT 1',
             false,
             'array_num'
        );

        $this->assertContains('s', $result[0]);
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [WHERE] [ORDER] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectQuery3($db) {

        $result = $db->query('SELECT id, name, email, reg_date
                                      FROM test_table
                                      WHERE id = 1
                                      ORDER BY id DESC',
                                      false,
                                      'array_assoc');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [RETURN ROWS NUMBER] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectQuery4($db) {

        $result = $db->query('SELECT id, name, email, reg_date
                                      FROM test_table',
                                      false,
                                      'rows');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [STATEMENTS] [WHERE] [RETURN OBJECT] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectQuery5($db) {

        $statements[] = [":id",  1];

        $result = $db->query('SELECT id, name, email, reg_date
                                      FROM test_table
                                      WHERE  id = :id',
                                      $statements);


        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectQueryTableNamError($db) {

        $result = $db->query('SELECT id, name, email, reg_date
                                      FROM xxxx');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [QUERY] [SELECT MULTIPLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectQueryColumnNamError($db) {

        $result = $db->query('SELECT xxxx, name, email, reg_date
                                      FROM test_table');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT ALL] [RETURN OBJECT] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod1($db) {

        $query = $db->select()
                            ->from('test_table');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT ALL] [RETURN ARRAY NUMERIC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod2($db) {

        $query = $db->select()
                            ->from('test_table');

        $result = $query->execute('array_num');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }


    /**
     * [METHOD] [SELECT ALL] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod3($db) {

        $query = $db->select()
                            ->from('test_table');

        $result = $query->execute('array_assoc');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [LIMIT] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod4($db) {

        $query = $db->select('name')
                            ->from('test_table')
                            ->limit(1);

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT MULTIPLE] [WHERE MULTIPLE] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod5($db) {

        $query = $db->select(['id', 'name'])
                            ->from('test_table')
                            ->where('id = 1');

        $result = $query->execute('array_assoc');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT MULTIPLE] [ORDER SIMPLE] [LIMIT] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod6($db) {

        $query = $db->select(['id', 'name'])
                            ->from('test_table')
                            ->where(['id = 1', 'name = "Isis"'])
                            ->order('id DESC')
                            ->limit(1);

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT MULTIPLE] [ORDER MULTIPLE] [LIMIT] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod7($db) {

        $query = $db->select(['id', 'name'])
                            ->from('test_table')
                            ->where(['id = 1', 'name = "isis"'])
                            ->order(['id DESC', 'name ASC'])
                            ->limit(1);

        $result = $query->execute('obj');

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [STATEMENTS] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod8($db) {

        $statements[] = [':id', 1];
        $statements[] = [':name', 'Isis'];

        $query = $db->select('name')
                            ->from('test_table')
                            ->where(['id = :id', 'name = :name'], $statements);

        $result = $query->execute();
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [STATEMENTS] [WHERE ADVANCED] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod9($db) {

        $statements[] = [':id', 1];
        $statements[] = [':name', 'Isis'];

        $query = $db->select('name')
                            ->from('test_table')
                            ->where('id = :id OR name = :name', $statements);

        $result = $query->execute('array_assoc');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [STATEMENTS] [DATA-TYPE] [WHERE MULTIPLE] [RETURN EMPTY ARRAY]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod10($db) {

        $statements[] = [':id',          1, 'int'];
        $statements[] = [':name',  'Isis', 'str'];
        $statements[] = [':email',    null, 'null'];
        $statements[] = [':reg_date', true, 'bool'];

        $clauses = [
            'id       = :id',
            'name     = :name',
            'email    = :email',
            'reg_date = :reg_date'];

        $query = $db->select('name')
                            ->from('test_table')
                            ->where($clauses, $statements);

        $result = $query->execute('obj');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [WHERE SIMPLE] [RETURN ROWS NUMBER] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod11($db) {

        $query = $db->select('name')
                            ->from('test_table')
                            ->where('name = "Isis"');

        $result = $query->execute('rows');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [MARKS STATEMENTS] [WHERE ADVANCED] [RETURN ROWS NUMBER] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod12($db) {

        $statements[] = [1, 1];
        $statements[] = [2, 'Isis'];

        $query = $db->select('name')
                            ->from('test_table')
                            ->where('id = ? OR name = ?', $statements);

        $result = $query->execute('rows');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [RETURN ROWS NUMBER]  
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethod13($db) {

        $statements[] = [1,       1, 'int'];
        $statements[] = [2,    null, 'null'];
        $statements[] = [3, 'Isis', 'str'];
        $statements[] = [4,    true, 'bool'];

        $clauses = 'id = ? OR email = ? AND name = ? OR id = ?';

        $query = $db->select('name')
                            ->from('test_table')
                            ->where($clauses, $statements);

        $result = $query->execute('rows');
        
        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT ALL] [EXCEPTION] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethodTableNameError($db) {

        $query = $db->select()
                            ->from('xxxx');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }

    /**
     * [METHOD] [SELECT] [EXCEPTION] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function dtestSelectMethodColumnNameError($db) {

        $query = $db->select('xxxx')
                            ->from('test_table');

        $result = $query->execute();

        echo '<pre>'; var_dump($result); echo '</pre>';
    }
}

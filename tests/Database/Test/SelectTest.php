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
     * [QUERY] [MULTIPLE] [RETURN OBJECT]
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
     * [QUERY] [ALL] [LIMIT] [RETURN ARRAY NUMERIC] 
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

        $this->assertContains('Isis', $result[0][1]);
    }

    /**
     * [QUERY] [MULTIPLE] [WHERE] [ORDER] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectQuery_Multiple_Where_Order_Assoc($db) {

        $id = $GLOBALS['ID'];

        $result = $db->query(

            "SELECT id, name, email, reg_date
             FROM test_table
             WHERE id = $id
             ORDER BY id DESC",
             false,
             'array_assoc'
        );

        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [QUERY] [MULTIPLE] [RETURN ROWS NUMBER] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectQuery_Multiple_Rows($db) {

        $result = $db->query(

            'SELECT id, name, email, reg_date
             FROM test_table',
             false,
             'rows'
        );

        $this->assertInternalType('int', $result);
    }

    /**
     * [QUERY] [MULTIPLE] [STATEMENTS] [WHERE] [RETURN OBJECT] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectQuery_Multiple_Statements_Where_Object($db) {

        $id = $GLOBALS['ID'];

        $statements[] = [":id", $id];

        $result = $db->query(

            'SELECT id, name, email, reg_date
             FROM test_table
             WHERE  id = :id',
             $statements
        );

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [QUERY] [MULTIPLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     * 
     * @return void
     */
    public function testSelectQueryTableNamError($db) {

        $result = $db->query(

            'SELECT id, name, email, reg_date
             FROM xxxx'
        );
    }

    /**
     * [QUERY] [MULTIPLE] [EXCEPTION]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     * 
     * @return void
     */
    public function testSelectQueryColumnNamError($db) {

        $result = $db->query(

            'SELECT xxxx, name, email, reg_date
             FROM test_table'
        );
    }

    /**
     * [METHOD] [ALL] [RETURN OBJECT] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_SelectAll_Object($db) {

        $query = $db->select()
                    ->from('test_table');

        $result = $query->execute();

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [ALL] [RETURN ARRAY NUMERIC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_SelectAll_Numeric($db) {

        $query = $db->select()
                    ->from('test_table');

        $result = $query->execute('array_num');

        $this->assertContains('Isis', $result[0][1]);
    }

    /**
     * [METHOD] [ALL] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_SelectAll_Assoc($db) {

        $query = $db->select()
                    ->from('test_table');

        $result = $query->execute('array_assoc');
        
        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [METHOD] [LIMIT] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Limit_Object($db) {

        $query = $db->select('name')
                    ->from('test_table')
                    ->limit(1);

        $result = $query->execute();
        
        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [MULTIPLE] [WHERE MULTIPLE] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Multiple_Where_Assoc($db) {

        $id = $GLOBALS['ID'];

        $query = $db->select(['id', 'name'])
                    ->from('test_table')
                    ->where("id = $id");

        $result = $query->execute('array_assoc');
        
        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [METHOD] [SELECT-WHERE MULTIPLE] [ORDER SIMPLE] [LIMIT] [OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Multiple_Where_Order_Limit_Object($db) {

        $id = $GLOBALS['ID'];

        $query = $db->select(['id', 'name'])
                    ->from('test_table')
                    ->where(["id = $id", 'name = "Isis"'])
                    ->order('id DESC')
                    ->limit(1);

        $result = $query->execute();
        
        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [SELECT-ORDER-WHERE MULTIPLE] [LIMIT] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Order_Where_Multiple_Limit_Object($db) {

        $id = $GLOBALS['ID'];

        $query = $db->select(['id', 'name'])
                    ->from('test_table')
                    ->where(["id = $id", 'name = "isis"'])
                    ->order(['id DESC', 'name ASC'])
                    ->limit(1);

        $result = $query->execute('obj');

        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE MULTIPLE] [RETURN OBJECT]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Statements_Where_Multiple_Object($db) {

        $id = $GLOBALS['ID'];

        $statements[] = [':id',    $id];
        $statements[] = [':name', 'Isis'];

        $query = $db->select('name')
                    ->from('test_table')
                    ->where(['id = :id', 'name = :name'], $statements);

        $result = $query->execute();
        
        $this->assertContains('Isis', $result[0]->name);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [RETURN ARRAY ASSOC]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Statements_Where_Advanced_Assoc($db) {

        $id = $GLOBALS['ID'];

        $statements[] = [':id',    $id];
        $statements[] = [':name', 'Isis'];

        $query = $db->select('name')
                    ->from('test_table')
                    ->where('id = :id OR name = :name', $statements);

        $result = $query->execute('array_assoc');
        
        $this->assertContains('Isis', $result[0]['name']);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE MULTIPLE] [RETURN EMPTY ARRAY]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethodWhenThereAreNoResults($db) {

        $id = $GLOBALS['ID'];

        $statements[] = [':id',          $id, 'int'];
        $statements[] = [':name',     'Isis', 'str'];
        $statements[] = [':email',      null, 'null'];
        $statements[] = [':reg_date',   true, 'bool'];

        $clauses = [

            'id       = :id',
            'name     = :name',
            'email    = :email',
            'reg_date = :reg_date'
        ];

        $query = $db->select('name')
                    ->from('test_table')
                    ->where($clauses, $statements);

        $result = $query->execute('obj');
        
        $this->assertCount(0, $result);
    }

    /**
     * [METHOD] [WHERE SIMPLE] [RETURN ROWS NUMBER] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Where_Rows($db) {

        $query = $db->select('name')
                    ->from('test_table')
                    ->where('name = "Isis"');

        $result = $query->execute('rows');
        
        $this->assertInternalType('int', $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [RETURN ROWS NUMBER] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_MarksStatements_Where_Advanced($db) {

        $id = $GLOBALS['ID'];

        $statements[] = [1, $id];
        $statements[] = [2, 'Isis'];

        $query = $db->select('name')
                    ->from('test_table')
                    ->where('id = ? OR name = ?', $statements);

        $result = $query->execute('rows');
        
        $this->assertInternalType('int', $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATATYPE] [WHERE ADVANCED] [RETURN ROWS]  
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     * 
     * @return void
     */
    public function testSelectMethod_Marks_DataType_Where_Advanced($db) {

        $id = $GLOBALS['ID'];

        $statements[] = [1,  $id,    'int'];
        $statements[] = [2,  null,   'null'];
        $statements[] = [3,  'Isis', 'str'];
        $statements[] = [4,  true,   'bool'];

        $clauses = 'id = ? OR email = ? AND name = ? OR id = ?';

        $query = $db->select('name')
                    ->from('test_table')
                    ->where($clauses, $statements);

        $result = $query->execute('rows');
        
        $this->assertInternalType('int', $result);
    }

    /**
     * [METHOD] [ALL] [EXCEPTION] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     * 
     * @return void
     */
    public function testSelectMethodTableNameError($db) {

        $query = $db->select()
                    ->from('xxxx');

        $result = $query->execute();
    }

    /**
     * [METHOD] [EXCEPTION] 
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     * 
     * @return void
     */
    public function testSelectMethodColumnNameError($db) {

        $query = $db->select('xxxx')
                    ->from('test_table');

        $result = $query->execute();
    }
}

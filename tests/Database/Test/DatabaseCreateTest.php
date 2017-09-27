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


final class DatabaseCreateTest extends TestCase {

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
     * [QUERY] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @return void
     */
    public function testCreateTableQuery($db) {

        $result = $db->query(

            'CREATE TABLE IF NOT EXISTS test_table (

                id       INT(6)      UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                name     VARCHAR(30) NOT NULL,
                email    VARCHAR(50),
                reg_date TIMESTAMP
            )'
        );

        $this->assertTrue($result);
    }

    /**
     * [QUERY] [CREATE TABLE] [EXCEPTION] [SINTAX ERROR]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage Syntax error or access violation
     *
     * @return void
     */
    public function testCreateTableQueryError($db) {

        $result = $db->query(

            'CREATE TABLE IF NOT EXISTS test_table (

                id       INT(6)      UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                name     VARCHAR(30) NOT NULL,
                email    VARCHAR(50),
                reg_date TIMESTAMP
            '
        );
    }

    /**
     * [METHOD] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @return void
     */
    public function testCreateTableMethod($db) {

        $params = [

            'id'       => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', 
            'name'     => 'VARCHAR(30) NOT NULL',
            'email'    => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP'
        ];

        $this->assertTrue(

            $db->create($params)->table('test_table')->execute()
        );
    }

    /**
     * [METHOD] [CREATE TABLE] [EXCEPTION] [SINTAX ERROR]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage Syntax error or access violation
     *
     * @return void
     */
    public function testCreateTableMethodError($db) {

        $params = [

            'id'       => 'INT(6 UNSIGNED AUTO_INCREMENT PRIMARY KEY', 
            'name'     => 'VARCHAR(30) NOT NULL',
            'email'    => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP'
        ];

        $db->create($params)->table('test_table')->execute();
    }

    /**
     * [METHOD] [CREATE TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @return void
     */
    public function testCreateTableMethod2($db) {

        $params = [

            'id'       => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', 
            'name'     => 'VARCHAR(30) NOT NULL',
            'email'    => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP'
        ];

        $query = $db->create($params)
                    ->table('test_table_two')
                    ->foreing('id')
                    ->reference('id')
                    ->on('test_table')
                    ->actions('ON DELETE CASCADE ON UPDATE CASCADE')
                    ->engine('innodb')
                    ->charset('utf8');

        $this->assertTrue($query->execute());
    }

    /**
     * [METHOD] [CREATE TABLE] [EXCEPTION] [SINTAX ERROR]
     *
     * @since 1.1.6
     *
     * @depends testGetConnection
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage Syntax error or access violation
     *
     * @return void
     */
    public function testCreateTableMethod2Error($db) {

        $params = [

            'id'       => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', 
            'name'     => 'VARCHAR(30) NOT NULL',
            'email'    => 'VARCHAR(50)',
            'reg_date' => 'TIMESTAMP'
        ];

        $query = $db->create($params)
                    ->table('test_table_two')
                    ->foreing('id')
                    ->reference('id')
                    ->on('test_table')
                    ->actions('ONDELETE CASCADE ON UPDATE CASCADE')
                    ->engine('innodb')
                    ->charset('utf8');

        $query->execute();
    }
}

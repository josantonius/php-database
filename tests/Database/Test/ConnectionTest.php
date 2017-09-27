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
    PHPUnit\Framework\TestCase,
    Eliasis\App\App;

/**
 * Database connection tests.
 *
 * @since 1.1.6
 */
final class ConnectionTest extends TestCase {

    /**
     * Get connection test.
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testGetConnection() {

        $db = Database::getConnection(

            'identifier',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );

        $this->assertContains('identifier', $db::$id);

        $this->assertContains(

            'Josantonius\Database\Database', 
            get_class($db)
        );

        return $db;
    }

    /**
     * Get connection test when using config from the Eliasis Framework.
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testGetConnectionFromEliasis() {

        App::run(dirname(__DIR__));

        App::set('db', [

            'Eliasis' => [
                'id'       => 'Eliasis',
                'provider' => 'PDOprovider',
                'host'     => $GLOBALS['DB_HOST'],
                'user'     => $GLOBALS['DB_USER'],
                'name'     => $GLOBALS['DB_NAME'],
                'password' => $GLOBALS['DB_PASSWORD'],
                'settings' => ['charset' => 'utf8'],
                'charset'  => 'utf8',
                'engine'   => 'innodb',
            ]
        ]);

        $db = Database::getConnection('Eliasis');

        $this->assertContains('Eliasis', $db::$id);

        $this->assertContains(

            'Josantonius\Database\Provider\PDOprovider\PDOprovider', 
            get_class($db->_provider)
        );
    }

    /**
     * Test when provider not exists.
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage The provider doesn't exist: Josantonius\
     *
     * @return void
     */
    public function testExceptionWhenProviderNotExists() {

        $db = Database::getConnection(

            'provider-exception',
            '?',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );
    }

    /**
     * Test for exception: Name or service not known.
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage [200
     *
     * @return void
     */
    public function testExceptionNameOrServiceNotKnown() {
        
        $db = Database::getConnection(

            'connection-exception',
            'PDOprovider',
            '?',
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );
    }

    /**
     * Test for exception: Access denied for user.
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage [104
     *
     * @return void
     */
    public function testExceptionAccessDeniedForUser() {
        
        $db = Database::getConnection(

            'user-exception',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            '?',
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );
    }

    /**
     * Test for exception: Access denied for user (password).
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage [104
     *
     * @return void
     */
    public function testExceptionAccessDeniedForUserPassword() {
        
        $db = Database::getConnection(

            'password-exception',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            '?',
            array('charset' => 'utf8')
        );
    }

    /**
     * Test for exception: Access denied for user (name).
     *
     * @since 1.1.6
     *
     * @expectedException Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage [104
     *
     * @return void
     */
    public function testExceptionAccessDeniedForUserName() {
        
        $db = Database::getConnection(

            'name-exception',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            '?',
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );
    }
}

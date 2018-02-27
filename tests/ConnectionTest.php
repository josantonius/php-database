<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.1.6
 */
namespace Josantonius\Database;

use PHPUnit\Framework\TestCase;

/**
 * Database connection tests.
 */
final class ConnectionTest extends TestCase
{
    /**
     * Get connection test.
     */
    public function testGetConnection()
    {
        $db = Database::getConnection(
            'identifier',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );

        $this->assertContains('identifier', $db::$id);

        $this->assertContains(
            'Josantonius\Database\Database',
            get_class($db)
        );

        $db = Database::getConnection(
            'api',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );

        $this->assertContains('api', $db::$id);

        $this->assertContains(
            'Josantonius\Database\Database',
            get_class($db)
        );
    }

    /**
     * Move between multiple connections.
     *
     * @since 1.1.7
     */
    public function testMoveBetweenMultipleConnections()
    {
        $db = Database::getConnection('identifier');

        $this->assertContains('identifier', $db::$id);

        $db = Database::getConnection('api');

        $this->assertContains('api', $db::$id);
    }

    /**
     * Test when provider not exists.
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage The provider doesn't exist: Josantonius\
     */
    public function testExceptionWhenProviderNotExists()
    {
        $db = Database::getConnection(
            'provider-exception',
            '?',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );
    }

    /**
     * Test for exception: Name or service not known.
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Unknown|MySQL|service|not|known)
     */
    public function testExceptionNameOrServiceNotKnown()
    {
        $db = Database::getConnection(
            'connection-exception',
            'PDOprovider',
            '?',
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );
    }

    /**
     * Test for exception: Access denied for user.
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage Access denied for user
     */
    public function testExceptionAccessDeniedForUser()
    {
        $db = Database::getConnection(
            'user-exception',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            '?',
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );
    }

    /**
     * Test for exception: Access denied for user (password).
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessage Access denied for user
     */
    public function testExceptionAccessDeniedForUserPassword()
    {
        $db = Database::getConnection(
            'password-exception',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            '?',
            ['charset' => 'utf8']
        );
    }

    /**
     * Test for exception: Access denied for user (name).
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Unknown|database|Access|denied|user)
     */
    public function testExceptionAccessDeniedForUserName()
    {
        $db = Database::getConnection(
            'name-exception',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            '?',
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );
    }
}

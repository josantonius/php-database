<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.1.6
 */

namespace Josantonius\Database;

use PHPUnit\Framework\TestCase;

/**
 * Test class for "DROP TABLE" query.
 *
 * @since 1.1.6
 */
class DropTest extends TestCase
{
    /**
     * Database instance.
     *
     * @since 1.1.7
     *
     * @var object
     */
    private $db;

    /**
     * Setup.
     *
     * @since 1.1.7
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->db = Database::getConnection(
            'identifier',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            array('charset' => 'utf8')
        );
    }

    /**
     * [QUERY] [DROP TABLE] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testDropTableQuery()
    {
        $result = $this->db->query('DROP TABLE `test_table_two`');

        $this->assertTrue($result);
    }

    /**
     * [METHOD] [PDO-METHOD] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testDropTableMethod()
    {
        $query = $this->db->drop()
                          ->table('test_table');

        $result = $query->execute();

        $this->assertTrue($result);
    }

    /**
     * [METHOD] [PDO-METHOD] [RETURN TRUE]
     *
     * @since 1.1.6
     *
     * @return void
     */
    public function testDropTableMethodExtra()
    {
        $query = $this->db->drop()
                          ->table('test_table_three');

        $result = $query->execute();

        $this->assertTrue($result);
    }
}

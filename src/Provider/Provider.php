<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.0.0
 */
namespace Josantonius\Database\Provider;

/**
 * Provider handler.
 */
abstract class Provider
{
    /**
     * Internally store the connection object.
     *
     * @var object
     */
    protected $conn;

    /**
     * Error messages.
     *
     * @var string
     */
    protected $error = '';

    /**
     * Database connection.
     */
    abstract public function connect($host, $dbUser, $dbName, $pass, $settings = []);

    /**
     * Run database queries.
     */
    abstract public function query($query, $type);

    /**
     * Execute prepared queries.
     */
    abstract public function statements($query, $statements);

    /**
     * Create table statement.
     */
    abstract public function create($table, $data, $foreing, $reference, $on, $actions, $engine, $charset);

    /**
     * Select into statement.
     */
    abstract public function select($columns, $from, $where, $order, $limit, $statements);

    /**
     * Insert into statement.
     */
    abstract public function insert($table, $data, $statements);

    /**
     * Update statement.
     */
    abstract public function update($table, $data, $statements, $where);

    /**
     * Delete statement.
     */
    abstract public function delete($table, $statements, $where);

    /**
     * Truncate table statement.
     */
    abstract public function truncate($table);

    /**
     * Drop table statement.
     */
    abstract public function drop($table);

    /**
     * Process query as object or numeric or associative array.
     */
    abstract public function fetchResponse($response, $result);

    /**
     * Get the last id of the query object.
     */
    abstract public function lastInsertId();

    /**
     * Get rows number.
     */
    abstract public function rowCount($response);

    /**
     * Get errors.
     */
    abstract public function getError();

    /**
     * Check database connection state.
     */
    abstract public function isConnected();

    /**
     * Close/delete database connection.
     */
    abstract public function kill();
}

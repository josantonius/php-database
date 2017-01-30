<?php
/**
 * Library for SQL database management to be used by several providers at the same time.
 * 
 * @category   JST
 * @package    Database
 * @subpackage Provider
 * @author     Josantonius - info@josantonius.com
 * @copyright  Copyright (c) 2017 JST PHP Framework
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @version    1.1.0
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      File available since 1.0.0 - Update: 2017-01-30
 */

namespace Josantonius\Database\Provider;

use Josantonius\Database\Exception\DBException;

/**
 * Provider handler.
 *
 * @since 1.0.0
 */
abstract class Provider {

    /**
     * Internally store the connection object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected $conn;

    /**
     * Error messages.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $error = '';

    /**
     * Database connection.
     *
     * @since 1.0.0
     */
    public abstract function connect($host, $dbUser, $dbName, $pass, $settings = []);
    /**
     * Run database queries.
     *
     * @since 1.0.0
     */
    public abstract function query($query, $type);

    /**
     * Execute prepared queries.
     *
     * @since 1.0.0
     */
    public abstract function statements($query, $statements);

    /**
     * Create table statement.
     *
     * @since 1.0.0
     */
    public abstract function create($table, $data);

    /**
     * Select into statement.
     *
     * @since 1.0.0
     */
    public abstract function select($columns, $from, $where, $order, $limit, $statements);

    /**
     * Insert into statement.
     *
     * @since 1.0.0
     */
    public abstract function insert($table, $data, $statements);

    /**
     * Update statement.
     *
     * @since 1.0.0
     */
    public abstract function update($table, $data, $statements, $where);

    /**
     * Delete statement.
     *
     * @since 1.0.0
     */
    public abstract function delete($table, $statements, $where);

    /**
     * Truncate table statement.
     *
     * @since 1.0.0
     */
    public abstract function truncate($table);

    /**
     * Drop table statement.
     *
     * @since 1.0.0
     */
    public abstract function drop($table);

    /**
     * Process query as object or numeric or associative array.
     *
     * @since 1.0.0
     */
    public abstract function fetchResponse($response, $result);

    /**
     * Get the last id of the query object.
     *
     * @since 1.0.0
     */
    public abstract function lastInsertId();

    /**
     * Get rows number.
     *
     * @since 1.0.0
     */
    public abstract function rowCount($response);

    /**
     * Get errors.
     *
     * @since 1.0.0
     */
    public abstract function getError();

    /**
     * Check database connection state.
     *
     * @since 1.0.0
     */
    public abstract function isConnected();

    /**
     * Close/delete database connection.
     *
     * @since 1.0.0
     */
    public abstract function kill();
}
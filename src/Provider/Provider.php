<?php declare(strict_types=1);
/**
 * Library for SQL database management to be used by several providers at the same time.
 * 
 * @category   JST
 * @package    Database
 * @subpackage Provider
 * @author     Josantonius - info@josantonius.com
 * @copyright  Copyright (c) 2017 JST PHP Framework
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @version    1.0.0
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      File available since 1.0.0 - Update: 2017-01-09
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
    public abstract function connect(string $host, string $dbUser, string $dbName, 
    								 string $pass, array $settings = []);
    /**
     * Run database queries.
     *
     * @since 1.0.0
     */
    public abstract function query(string $query, string $type);

    /**
     * Execute prepared queries.
     *
     * @since 1.0.0
     */
    public abstract function statements(string $query, array $statements);

    /**
     * Create table statement.
     *
     * @since 1.0.0
     */
    public abstract function create(string $table, array $data);

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
    public abstract function insert(string $table, array $data, $statements);

    /**
     * Update statement.
     *
     * @since 1.0.0
     */
    public abstract function update(string $table, array $data, $statements, $where);

    /**
     * Delete statement.
     *
     * @since 1.0.0
     */
    public abstract function delete(string $table, $statements, $where);

    /**
     * Truncate table statement.
     *
     * @since 1.0.0
     */
    public abstract function truncate(string $table);

    /**
     * Drop table statement.
     *
     * @since 1.0.0
     */
    public abstract function drop(string $table);

    /**
     * Process query as object or numeric or associative array.
     *
     * @since 1.0.0
     */
    public abstract function fetchResponse($response, string $result);

    /**
     * Get the last id of the query object.
     *
     * @since 1.0.0
     */
    public abstract function lastInsertId(): int;

    /**
     * Get rows number.
     *
     * @since 1.0.0
     */
    public abstract function rowCount($response): int;

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
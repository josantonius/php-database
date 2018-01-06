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
namespace Josantonius\Database\Exception;

/**
 * Exception class for Database library.
 *
 * You can use an exception and error handler with this library.
 *
 * @link https://github.com/Josantonius/PHP-ErrorHandler
 */
class DBException extends \Exception
{
    /**
     * Exception handler.
     *
     * @param string $msg    → message error (Optional)
     * @param int    $status → HTTP response status code (Optional)
     */
    public function __construct($msg = '', $status = 0)
    {
        $this->message = $msg;
        $this->statusCode = $status;
    }
}

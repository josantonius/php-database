<?php
/**
 * Eliasis PHP Framework
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Eliasis
 * @since      1.0.2
 */

namespace Eliasis\Model\Exception;

/**
 * Exception class.
 *
 * You can use an exception and error handler with this library.
 *
 * @since 1.0.2
 *
 * @link https://github.com/Josantonius/PHP-ErrorHandler
 */
class ModelException extends \Exception { 

    /**
     * Exception handler.
     *
     * @since 1.0.2
     *
     * @param string $msg    → message error (Optional)
     * @param int    $error  → error code (Optional)
     * @param int    $status → HTTP response status code (Optional)
     */
    public function __construct($msg = '', $error = 0, $status = 0) {

        $this->message    = $msg;
        $this->code       = $error;
        $this->statusCode = $status;
    }
}

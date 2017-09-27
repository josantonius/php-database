<?php
/**
 * Eliasis PHP Framework
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Eliasis
 * @since      1.0.0
 */

namespace Eliasis\View;

class View {

    /**
     * View instance.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected static $instance;

    /**
     * HTTP headers.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private static $headers = [];

    /**
     * View content.
     *
     * @since 1.0.0
     *
     * @var array
     */
    public static $data = null;

    /**
     * Get controller instance.
     *
     * @since 1.0.0
     *
     * @param string $controller → controller namespace
     *
     * @return object → controller instance
     */
    public static function getInstance() {

        NULL === self::$instance and self::$instance = new self;

        return static::$instance;
    }

    /**
     * Render screen view.
     *
     * @since 1.0.0
     *
     * @param string $path → filepath
     * @param string $file → filename
     * @param array  $data → view content
     */
    public function renderizate($path, $file, $data = null) {

        $file = $path . $file . '.php';

        if ($data) {

            self::$data[sha1($file)] = $data;
        }

        require_once $file;
    }

    /**
     * Get options saved.
     *
     * @since 1.0.9
     *
     * @param array  $params → parameters
     * @param string $file   → filepath
     *
     * @return mixed
     */
    public static function get(...$params) {

        $trace = debug_backtrace(2, 1);
          
        $id = (isset($trace[0]['file'])) ? sha1($trace[0]['file']) : 0;

        $key = array_shift($params);

        $col[] = isset(self::$data[$id][$key]) ? self::$data[$id][$key] : 0;

        if (!count($params)) {

            return ($col[0]) ? $col[0] : self::$data[$id];
        }

        foreach ($params as $param) {

            $col = array_column($col, $param);
        }
        
        return (isset($col[0])) ? $col[0] : '';
    }

    /**
     * Add HTTP header to headers array.
     *
     * @since 1.0.0
     *
     * @param  string $header → HTTP header text
     */
    public function addHeader($header) {

        self::$headers[] = $header;
    }

    /**
     * Add an array with headers to the view.
     *
     * @since 1.0.0
     *
     * @param array $headers
     */
    public function addHeaders($headers = []) {

        self::$headers = array_merge(self::$headers, $headers);
    }

    /**
     * Send headers
     *
     * @since 1.0.0
     */
    public static function sendHeaders() {

        if (!headers_sent()) {

            foreach (self::$headers as $header) {

                header($header, true);
            }
        }
    }
}

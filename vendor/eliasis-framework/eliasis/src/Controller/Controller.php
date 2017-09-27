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

namespace Eliasis\Controller;

use Eliasis\View\View,
    Eliasis\Controller\Exception\ControllerException;

/**
 * Controller class.
 *
 * @since 1.0.0
 */
abstract class Controller {

    /**
     * Controller instances.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected static $instance;

    /**
     * Model instance.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected $model;

    /**
     * View instance.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected $view;
    
    /**
     * Prevent creating a new controller instance.
     *
     * @since 1.0.0
     */
    protected function __construct() { }

    /**
     * Get controller instance.
     *
     * @since 1.0.0
     *
     * @return object → controller instance
     */
    public static function getInstance() {

        $controller = get_called_class();

        if (!isset(self::$instance[$controller])) { 

            self::$instance[$controller] = new $controller;
        }

        if (is_null(self::$instance[$controller]->view)) {

            self::getViewInstance(self::$instance[$controller]);
        }

        self::getModelInstance(self::$instance[$controller], $controller);

        return self::$instance[$controller];
    }

    /**
     * Get view instance.
     *
     * @since 1.0.0
     *
     * @param object $instance → this
     */
    protected static function getViewInstance($instance) {

        $instance->view = View::getInstance();
    }

    /**
     * Get model instance.
     *
     * @since 1.0.2
     *
     * @param object $instance   → this
     * @param string $controller → controller namespace
     *
     * @return object → controller instance
     */
    protected static function getModelInstance($instance, $controller='') {

        $controller = empty($controller) ? $controller : get_called_class();

        $model = str_replace('Controller', 'Model', $controller);

        if (class_exists($model)) {

            $instance->model = call_user_func($model . '::getInstance');
        }
    }

    /**
     * Prevents the object from being cloned.
     *
     * @since 1.0.0
     *
     * @throws ControllerException → clone is not allowed
     */
    public function __clone() {

        $message = 'Clone is not allowed in';

        throw new ControllerException($message . ': ' . __CLASS__, 800);
    }

    /**
     * Prevent unserializing.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function __wakeup() { }
}

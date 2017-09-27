<?php
/**
 * Library for SQL database management.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      1.0.0
 */

namespace Josantonius\Database;

use Josantonius\Database\Exception\DBException;
/**
 * Database handler.
 *
 * @since 1.0.0
 */
class Database {

    /**
     * Database identifier.
     *
     * @since 1.1.6
     *
     * @var mixed
     */
    public static $id;

    /**
     * Database provider.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public $_provider;

    /**
     * Database connection.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private static $_conn;     

    /**
     * Query.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $_query;

    /**
     * Query response.
     *
     * @since 1.0.0
     *
     * @var object
     */
    private $_response;  

    /**
     * Last insert id of the last query.
     *
     * @since 1.0.0
     *
     * @var int
     */
    public $lastInsertId;   

    /**
     * Get number of rows affected of the last query.
     *
     * @since 1.0.0
     *
     * @var int
     */
    public $rowCount;   

    /**
     * Configurations for queries.
     *
     * @since 1.0.0
     *
     * @var null|array 
     */
    protected $settings = [

        'on'         => null, // array  → db reference table (foreing)
        'type'       => null, // string → type of query
        'data'       => null, // array  → columns and values
        'table'      => null, // string → database table name
        'order'      => null, // mixed  → order clause
        'limit'      => null, // int    → limit clause
        'where'      => null, // mixed  → where clause
        'engine'     => null, // string → database engine
        'result'     => null, // string → result datatype: array|object|rows
        'columns'    => null, // mixed  → columns
        'foreing'    => null, // array  → foreing
        'actions'    => null, // array  → action when delete/update (foreing)
        'reference'  => null, // array  → references for foreing
        'statements' => null, // array  → prepared statements
    ];

    /**
     * Database provider constructor.
     *
     * @since 1.0.0
     * 
     * @param string $provider            → name of provider class
     * @param string $host                → database host
     * @param string $user                → database user
     * @param string $name                → database name
     * @param string $password            → database password
     * @param array  $settings            → database options
     * @param array  $settings['port']    → database port
     * @param array  $settings['charset'] → database charset
     *
     * @throws DBException → if the provider class specified does not exist
     * @throws DBException → if could not connect to provider
     *
     * @return void
     */
    private function __construct($provider, $host, $user, $name, $password, $settings) {

        $provider = "Josantonius\\Database\\Provider\\$provider\\$provider";
        
        if (!class_exists($provider)) {

            throw new DBException("The provider doesn't exist: $provider");
        }
        
        $this->_provider = new $provider;

        $this->_provider->connect($host, $user, $name, $password, $settings);

        if (!$this->_provider->isConnected()) {

            $message = 'Could not connect to provider: ' . $provider . '. ';

            throw new DBException($message . $this->_provider->getError());
        }
    }

    /**
     * Get connection. 
     *
     * Create a new if it doesn't exist or another provider is used.
     *
     * @since 1.0.0
     *
     * @param string $id                  → identifying name for the database
     * @param string $provider            → name of provider class
     * @param string $host                → database host
     * @param string $user                → database user
     * @param string $name                → database name
     * @param string $password            → database password
     * @param array  $settings            → database options
     * @param array  $settings['port']    → database port
     * @param array  $settings['charset'] → database charset
     * 
     * @return object → object with the connection
     */
    public static function getConnection($id, $provider = null, $host = null, $user = null, $name = null, $password = null, $settings = null) {

        if (isset(self::$_conn[self::$id = $id])) { 

            return self::$_conn[$id];
        }

        if (class_exists($App = 'Eliasis\\App\\App')) {

            $provider = $provider ?: $App::get('db', $id, 'provider');
            $host     = $host     ?: $App::get('db', $id, 'host'); 
            $user     = $user     ?: $App::get('db', $id, 'user');
            $name     = $name     ?: $App::get('db', $id, 'name');
            $password = $password ?: $App::get('db', $id, 'password');
            $settings = $settings ?: $App::get('db', $id, 'settings');
        }

        return self::$_conn[$id] = new Database(

            $provider, 
            $host, 
            $user, 
            $name,
            $password,
            $settings
        );
    }

    /**
     * Process query and prepare it for the provider.
     *
     * @since 1.0.0
     *
     * @param string $query      → query
     * @param array  $statements → null by default or array for statements
     *        
     * @param string $result → 'obj'         → result as object
     *                       → 'array_num'   → result as numeric array
     *                       → 'array_assoc' → result as associative array
     *                       → 'rows'        → affected rows number
     *                       → 'id'          → last insert id
     * 
     * @throws DBException → invalid query type
     *
     * @return mixed → result as object, array, int...
     */
    public function query($query, $statements = null, $result = 'obj') {

        $this->settings['type'] = explode(' ', $query)[0];

        $this->_query = $query;

        $this->settings['result']     = $result;
        $this->settings['statements'] = $statements;

        $types = '|SELECT|INSERT|UPDATE|DELETE|CREATE|TRUNCATE|DROP';

        if (!strpos($types, $this->settings['type'])) {

            throw new DBException('Unknown query type');
        }

        $this->_implement();

        return $this->_getResponse();
    }

    /**
     * Create table statement.
     *
     * @since 1.0.0
     * 
     * @param array $data → column name and configuration for data types
     * 
     * @return object
     */
    public function create($data) {

        $this->settings['type'] = 'CREATE';

        $this->settings['data'] = $data;
        
        return $this;
    }

    /**
     * Set foreing key.
     *
     * @since 1.1.2
     * 
     * @param string $id → column id
     * 
     * @return object
     */
    public function foreing($id) {

        $this->settings['foreing'][] = $id;

        return $this;
    }

    /**
     * Set reference for foreing keys.
     *
     * @since 1.1.2
     * 
     * @param array $data → table and id
     * 
     * @return object
     */
    public function reference($data) {

        $this->settings['reference'][] = $data;

        return $this;
    }

    /**
     * Set database table name.
     *
     * @since 1.1.2
     * 
     * @return object
     */
    public function on($table) {

        $this->settings['on'][] = $table;

        return $this;
    }

    /**
     * Set actions when delete or update for foreing key.
     *
     * @since 1.1.2
     * 
     * @return object
     */
    public function actions($action) {

        $this->settings['actions'][] = $action;

        return $this;
    }

    /**
     * Set engine.
     *
     * @since 1.1.2
     * 
     * @return object
     */
    public function engine($type) {

        $this->settings['engine'] = $type;

        return $this;
    }

    /**
     * Set charset.
     *
     * @since 1.1.2
     * 
     * @return object
     */
    public function charset($type) {

        $this->settings['charset'] = $type;

        return $this;
    }

    /**
     * Select statement.
     *
     * @since 1.0.0
     * 
     * @param mixed $columns → column/s name
     * 
     * @return object
     */
    public function select($columns = '*') {

        $this->settings['type'] = 'SELECT';

        $this->settings['columns'] = $columns;

        return $this;
    }

    /**
     * Insert into statement.
     *
     * @since 1.0.0
     * 
     * @param array $data       → column name and value
     * @param array $statements → null by default or array for statements
     * 
     * @return object
     */
    public function insert($data, $statements = null) {

        $this->settings['type'] = 'INSERT';

        $this->settings['data'] = $data;

        $this->settings['statements'] = $statements;

        return $this;
    }

    /**
     * Update statement.
     *
     * @since 1.0.0
     * 
     * @param array $data       → column name and value
     * @param array $statements → null by default or array for statements
     * 
     * @return object
     */
    public function update($data, $statements = null) {

        $this->settings['type'] = 'UPDATE';

        $this->settings['data'] = $data;

        $this->settings['statements'] = $statements;
        
        return $this;
    }

    /**
     * Replace a row in a table if it exists or insert a new row if not exist.
     *
     * @since 1.0.0
     * 
     * @param array $data       → column name and value
     * @param array $statements → null by default or array for statements
     * 
     * @return object
     */
    public function replace($data, $statements = null) {

        $this->settings['type'] = 'REPLACE';

        $this->settings['data'] = $data;

        $this->settings['statements'] = $statements;

        return $this;
    }

    /**
     * Delete statement.
     *
     * @since 1.0.0
     * 
     * @return object
     */
    public function delete() {

        $this->settings['type'] = 'DELETE';
        
        return $this;
    }

    /**
     * Truncate table statement.
     *
     * @since 1.0.0
     * 
     * @return object
     */
    public function truncate() {

        $this->settings['type'] = 'TRUNCATE';

        return $this;
    }

    /**
     * Drop table statement.
     *
     * @since 1.0.0
     * 
     * @return object
     */
    public function drop() {

        $this->settings['type'] = 'DROP';
        
        return $this;
    }

    /**
     * Set database table name.
     *
     * @since 1.0.0
     * 
     * @param string $table → table name
     * 
     * @return object
     */
    public function in($table) {

        $this->settings['table'] = $table;

        return $this;
    }

    /**
     * Set database table name.
     *
     * @since 1.0.0
     * 
     * @param string $table → table name
     * 
     * @return object
     */
    public function table($table) {

        $this->settings['table'] = $table;

        return $this;
    }

    /**
     * Set database table name.
     *
     * @since 1.0.0
     * 
     * @param string $table → table name
     * 
     * @return object
     */
    public function from($table) {

        $this->settings['table'] = $table;

        return $this;
    }

    /**
     * Where clauses.
     *
     * @since 1.0.0
     * 
     * @param mixed $clauses    → column name and value
     * @param array $statements → null by default or array for statements
     * 
     * @return object
     */
    public function where($clauses, $statements = null) {

        $this->settings['where'] = $clauses;

        if (is_array($this->settings['statements'])) {

            $this->settings['statements'] = array_merge(

                $this->settings['statements'], $statements
            );
        
        } else {

            $this->settings['statements'] = $statements;
        }

        return $this;
    }

    /**
     * Set SELECT order.
     *
     * @since 1.0.0
     * 
     * @param string $params → query sort parameters
     * 
     * @return object
     */
    public function order($params) {

        $this->settings['order'] = $params;

        return $this;
    }

    /**
     * Set SELECT limit.
     *
     * @since 1.0.0
     * 
     * @param string $params → query limiting parameters
     * 
     * @return object
     */
    public function limit($params) {

        $this->settings['limit'] = $params;

        return $this;
    }

    /**
     * Execute query.
     *
     * @since 1.0.0
     * 
     * @param string $result → 'obj'         → result as object
     *                       → 'array_num'   → result as numeric array
     *                       → 'array_assoc' → result as associative array
     *                       → 'rows'        → affected rows number
     *                       → 'id'          → last insert id
     * 
     * @return int → number of lines updated or 0 if not updated
     */
    public function execute($result = 'obj') {

        $this->settings['result'] = $result;

        $type = strtolower($this->settings['type']);

        switch ($this->settings['type']) {

            case 'SELECT':

                $params = [

                    $this->settings['columns'], 
                    $this->settings['table'], 
                    $this->settings['where'], 
                    $this->settings['order'], 
                    $this->settings['limit'], 
                    $this->settings['statements'], 
                    $this->settings['result']
                ];
                break;

            case 'INSERT':

                $params = [

                    $this->settings['table'], 
                    $this->settings['data'], 
                    $this->settings['statements']
                ];
                break;

            case 'UPDATE':

                $params = [

                    $this->settings['table'], 
                    $this->settings['data'], 
                    $this->settings['statements'], 
                    $this->settings['where']
                ];
                break;

            case 'REPLACE':

                $params = [

                    $this->settings['table'], 
                    $this->settings['data'], 
                    $this->settings['statements']
                ];
                break;

            case 'DELETE':

                $params = [

                    $this->settings['table'], 
                    $this->settings['statements'], 
                    $this->settings['where']
                ];
                break;

            case 'CREATE':

                $params = [

                    $this->settings['table'],
                    $this->settings['data'],
                    $this->settings['foreing'],
                    $this->settings['reference'],
                    $this->settings['on'],
                    $this->settings['actions'],
                    $this->settings['engine'],
                    $this->settings['charset'],
                ];
                break;

            case 'TRUNCATE':

                $params = [

                    $this->settings['table']
                ];
                break;

            case 'DROP':

                $params = [

                    $this->settings['table']
                ];
                break;
        }

        $provider = [$this->_provider, $type];

        $this->_response = call_user_func_array($provider, $params);

        $this->_reset();

        return $this->_getResponse();
    }

    /**
     * Query handler.
     *
     * @since 1.0.0
     * 
     * @return object → returns query to be executed by provider class
     */
    private function _implement() {

        if (is_array($this->settings['statements'])) {

            return $this->_implementPrepareStatements();
        }

        return $this->_implementQuery();
    }

    /**
     * Run query with prepared statements.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function _implementPrepareStatements() {

        $this->_response = $this->_provider->statements(

            $this->_query, 
            $this->settings['statements']
        );
    }

    /**
     * Run query without prepared statements.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function _implementQuery() {

        $this->_response = $this->_provider->query(

            $this->_query, 
            $this->settings['type']
        );
    }

    /**
     * Get response after executing the query.
     *
     * @since 1.0.0
     * 
     * @throws DBException → error executing query
     *
     * @return mixed → result as object, array, int...
     */
    private function _getResponse() {

        $this->lastInsertId = $this->_provider->lastInsertId();

        $this->rowCount = $this->_provider->rowCount($this->_response);

        if (is_null($this->_response)) {

            throw new DBException(

                'Error executing the query ' . $this->_provider->getError()
            );
        }

        return $this->_fetchResponse();
    }

    /**
     * Process query as object or numeric or associative array.
     *
     * @since 1.0.0
     * 
     * @return mixed|bool → results
     */
    private function _fetchResponse() {

        $type = $this->settings['type'];

         if (strpos('|INSERT|UPDATE|DELETE|REPLACE|', $type)) {

            if ($this->settings['result'] === 'id') {

                return $this->lastInsertId;
            }

            return $this->rowCount;

        } else if ($type === 'SELECT') {

            if ($this->settings['result'] !== 'rows') {

                return $this->_provider->fetchResponse(

                    $this->_response, 
                    $this->settings['result']
                );
            }
                
            if (is_object($this->_response)) {

                return $this->_provider->rowCount($this->_response);
            }
        }

        return true;
    }

    /**
     * Reset query parameters.
     *
     * @since 1.0.0
     * 
     * @return void
     */
    private function _reset() {

        $this->settings['columns']    = null;
        $this->settings['table']      = null;
        $this->settings['where']      = null;
        $this->settings['order']      = null;
        $this->settings['limit']      = null;
        $this->settings['statements'] = null;
        $this->settings['foreing']    = null;
        $this->settings['reference']  = null;
        $this->settings['on']         = null;
        $this->settings['actions']    = null;
        $this->settings['engine']     = null;
        $this->settings['charset']    = null;
    }

    /**
     * Close connection to database.
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function __destruct() {

        $this->_provider->kill();
    }
}

<?php
/**
 * Library for SQL database management to be used by several providers at the same time.
 * 
 * @category   JST
 * @package    Database
 * @subpackage Database
 * @author     Josantonius - info@josantonius.com
 * @copyright  Copyright (c) 2017 JST PHP Framework
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @version    1.1.0
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      File available since 1.0.0 - Update: 2017-01-30
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
     * Identifying name for the database.
     *
     * @since 1.0.0
     *
     * @var object
     */
    private static $_databaseID = null;

    /**
     * Database provider.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected $_provider;

    /**
     * Database connection.
     *
     * @since 1.0.0
     *
     * @var object
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
     * Prepared statements.
     *
     * @since 1.0.0
     *
     * @var null|array 
     */
    private $_statements;

    /**
     * Columns and values.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private $_data;

    /**
     * Columns.
     *
     * @since 1.0.0
     *
     * @var mixed
     */
    private $_columns;

    /**
     * Database table name.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $_table;

    /**
     * Order clause.
     *
     * @since 1.0.0
     *
     * @var mixed
     */
    private $_order;  

    /**
     * Limit clause.
     *
     * @since 1.0.0
     *
     * @var int
     */
    private $_limit;  

    /**
     * Where clause.
     *
     * @since 1.0.0
     *
     * @var mixed
     */
    private $_where;  

    /**
     * Type of query.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $_type; 

    /**
     * Result display parameters (array, object, rows ...)
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $_result;    

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
     * Database provider constructor.
     *
     * @since 1.0.0
     *
     * @param string $provider            → name of provider class
     * @param string $host                → database host
     * @param string $dbUser              → database user
     * @param string $dbName              → database name
     * @param string $pass                → database password
     * @param array  $settings            → database options
     * @param array  $settings['port']    → database port
     * @param array  $settings['charset'] → database charset
     *
     * @throws DBException → if the provider class specified does not exist
     * @throws DBException → if there has been no successful connection to the database
     */
    private function __construct($provider, $host, $dbUser, $dbName, $pass, $settings) {

        $providerClass = 'Josantonius\\Database\\Provider\\' . $provider;
        
        if (!class_exists($providerClass)) {

            $message = 'There is no exist the provider: ' . $provider;

            throw new DBException($message, 700);
        }
        
        $this->_provider = new $providerClass;

        $this->_provider->connect($host, $dbUser, $dbName, $pass, $settings);

        if (!$this->_provider->isConnected()) {

            $message = 'Could not connect to provider: ' . $provider . '. ';

            throw new DBException($message . $this->_provider->getError(), 701);
        } 
    }

    /**
     * Check connection or create a new if it doesn't exist or another provider is used.
     *
     * @since 1.0.0
     *
     * @param string $databaseID          → identifying name for the database
     * @param string $provider            → name of provider class
     * @param string $host                → database host
     * @param string $dbUser              → database user
     * @param string $dbName              → database name
     * @param string $pass                → database password
     * @param array  $settings            → database options
     * @param array  $settings['port']    → database port
     * @param array  $settings['charset'] → database charset
     * 
     * @return object → object with the connection
     */
    public static function getConnection($databaseID, $provider, $host, $dbUser, 
                                                      $dbName,   $pass, $settings) {

        if (static::$_databaseID !== $databaseID) {

            static::$_conn = false;
        }

        static::$_databaseID = $databaseID;

        if (!static::$_conn) {

            static::$_conn = new Database($provider, $host, $dbUser, 
                                          $dbName,   $pass, $settings);
        } 
                    
        return static::$_conn;
    }

    /**
     * Process query and prepare it for the provider.
     *
     * @since 1.0.0
     *
     * @param string $query      → query
     * @param array  $statements → null by default or array with prepared query
     *        
     * @param string $result → 'obj'         → result as object
     *                       → 'array_num'   → result as numeric array
     *                       → 'array_assoc' → result as associative array
     *                       → 'rows'        → number of rows affected in the query
     *                       → 'id'          → last insert id
     * 
     * @throws DBException → invalid query type
     * @return mixed       → result as object, array, int...
     */
    public function query($query, $statements = null, $result = 'obj') {

        $this->_type = explode(" ", $query)[0];

        $this->_query      = $query;
        $this->_result     = $result;
        $this->_statements = $statements;

        if (!strpos('|SELECT|INSERT|UPDATE|DELETE|CREATE|TRUNCATE|DROP', $this->_type)) {

            throw new DBException('Unknown query type', 702);
        }

        $this->_implement();

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

        if (is_array($this->_statements)) {

            return $this->_implementPrepareStatements();
        }

        return $this->_implementQuery();
    }

    /**
     * Run query with prepared statements.
     *
     * @since 1.0.0
     */
    private function _implementPrepareStatements() {

        $this->_response = $this->_provider->statements($this->_query, $this->_statements);
    }

    /**
     * Run query without prepared statements.
     *
     * @since 1.0.0
     */
    private function _implementQuery() {

        $this->_response = $this->_provider->query($this->_query, $this->_type);
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

        $this->_type = 'CREATE';

        $this->_data = $data;
        
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

        $this->_type = 'SELECT';

        $this->_columns = $columns;

        return $this;
    }

    /**
     * Insert into statement.
     *
     * @since 1.0.0
     * 
     * @param array  $data       → column name and value
     * @param array  $statements → null by default or array with prepared query
     * 
     * @return object
     */
    public function insert($data, $statements = null) {

        $this->_type = 'INSERT';

        $this->_data = $data;

        $this->_statements = $statements;

        return $this;
    }

    /**
     * Update statement.
     *
     * @since 1.0.0
     * 
     * @param array  $data       → column name and value
     * @param array  $statements → null by default or array with prepared query
     * 
     * @return object
     */
    public function update($data, $statements = null) {

        $this->_type = 'UPDATE';

        $this->_data = $data;

        $this->_statements = $statements;
        
        return $this;
    }

    /**
     * Replace a row in a table if it exists or insert a new row in a table if not exist.
     *
     * @since 1.0.0
     * 
     * @param array  $data       → column name and value
     * @param array  $statements → null by default or array with prepared query
     * 
     * @return object
     */
    public function replace($data, $statements = null) {

        $this->_type = 'REPLACE';

        $this->_data = $data;

        $this->_statements = $statements;

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

        $this->_type = 'DELETE';
        
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

        $this->_type = 'TRUNCATE';

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

        $this->_type = 'DROP';
        
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

        $this->_table = $table;

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

        $this->_table = $table;

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

        $this->_table = $table;

        return $this;
    }

    /**
     * Where clauses.
     *
     * @since 1.0.0
     * 
     * @param mixed $clauses     → column name and value
     * @param array  $statements → null by default or array with prepared query
     * 
     * @return object
     */
    public function where($clauses, $statements = null) {

        $this->_where = $clauses;

        if (is_array($this->_statements)) {

            $this->_statements = array_merge($this->_statements, $statements);
        
        } else {

            $this->_statements = $statements;
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

        $this->_order = $params;

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

        $this->_limit = $params;

        return $this;
    }

    /**
     * Reset query parameters.
     *
     * @since 1.0.0
     */
    private function _reset() {

        $this->_columns    = null;
        $this->_table      = null;
        $this->_where      = null;
        $this->_order      = null;
        $this->_limit      = null;
        $this->_statements = null;
    }

    /**
     * Execute query.
     *
     * @since 1.0.0
     * 
     * @param string $result → 'obj'         → result as object
     *                       → 'array_num'   → result as numeric array
     *                       → 'array_assoc' → result as associative array
     *                       → 'rows'        → number of rows affected in the query
     *                       → 'id'          → last insert id
     * 
     * @return int → number of lines updated or 0 if not updated
     */
    public function execute($result = 'obj') {

        $this->_result = $result;

        $type = strtolower($this->_type);

        switch ($this->_type) {

            case 'SELECT':
                $params = [
                    $this->_columns, 
                    $this->_table, 
                    $this->_where, 
                    $this->_order, 
                    $this->_limit, 
                    $this->_statements, 
                    $this->_result
                ];
                break;

            case 'INSERT':
                $params = [
                    $this->_table, 
                    $this->_data, 
                    $this->_statements
                ];
                break;

            case 'UPDATE':
                $params = [
                    $this->_table, 
                    $this->_data, 
                    $this->_statements, 
                    $this->_where
                ];
                break;

            case 'REPLACE':
                $params = [
                    $this->_table, 
                    $this->_data, 
                    $this->_statements
                ];
                break;

            case 'DELETE':
                $params = [
                    $this->_table, 
                    $this->_statements, 
                    $this->_where
                ];
                break;

            case 'CREATE':
                $params = [
                    $this->_table,
                    $this->_data
                ];
                break;

            case 'TRUNCATE':
                $params = [
                    $this->_table
                ];
                break;

            case 'DROP':
                $params = [
                    $this->_table
                ];
                break;
        }

        $this->_response = call_user_func_array([$this->_provider, $type], $params);

        $this->_reset();

        return $this->_getResponse();
    }

    /**
     * Get response after executing the query.
     *
     * @since 1.0.0
     * 
     * @throws DBException → error executing query
     * @return mixed       → result as object, array, int...
     */
    private function _getResponse() {

        $this->lastInsertId = $this->_provider->lastInsertId();

        $this->rowCount = $this->_provider->rowCount($this->_response);

        if (is_null($this->_response)) {

            $message = 'Error executing the query';

            throw new DBException($message . $this->_provider->getError(), 703);
        }

        return $this->_fetchResponse();
    }

    /**
     * Process query as object or numeric or associative array.
     *
     * @since 1.0.0
     * 
     * @return mixed →  results
     */
    private function _fetchResponse() {

         if (strpos('|INSERT|UPDATE|DELETE|REPLACE|', $this->_type)) {

            if ($this->_result === 'id') { # Display last insert Id

                return $this->lastInsertId;
            }

            return $this->rowCount;

        } else if ($this->_type === 'SELECT') {

            if ($this->_result !== 'rows') { // Return response as array or object

                return $this->_provider->fetchResponse($this->_response, $this->_result);
            }
                
            if (is_object($this->_response)) { // Return number of rows of matches

                return $this->_provider->rowCount($this->_response);
            }
        }

        return true;
    }

    /**
     * Close connection to database.
     *
     * @since 1.0.0
     */
    public function __destruct() {

        $this->_provider->kill();
    }
}
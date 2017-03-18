<?php
/**
 * Library for SQL database management to be used by several providers at the same time.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Database
 * @since      1.0.0
 */

namespace Josantonius\Database\Provider;

use Josantonius\Database\Exception\DBException,
    Josantonius\Database\Provider\Provider;

/**
 * PDO database provider.
 *
 * @since 1.0.0
 */
class PDOprovider extends Provider {

    /**
     * Database connection.
     *
     * @since 1.0.0
     * 
     * @param string $host                → database host
     * @param string $dbUser              → database user
     * @param string $dbName              → database name
     * @param string $pass                → database password
     * @param array  $settings            → database options
     * @param array  $settings['charset'] → database charset
     * 
     * @return object|null → returns the object with the connection or null
     */
    public function connect($host, $dbUser, $dbName, $pass, $settings = []) {

        try {

            $charset = (!isset($settings['charset']) ? $settings['charset'] : 'utf8';

            $this->conn = new \PDO('mysql:host=' . $host . 
                                  ';dbname='    . $dbName . 
                                  ';charset='   . $charset, $dbUser, $pass);
            
            $this->conn->exec("SET NAMES" . $charset);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                        
            return  $this->conn;

        } catch (\PDOException $e) {
           
            $this->error = $e->getMessage();

            return null;
        }
    }

    /**
     * Run database queries.
     *
     * @since 1.0.0
     * 
     * @param string $query → query
     * @param string $type  → query type: SELECT INSERT UPDATE DELETE CREATE TRUNCATE
     * 
     * @return object|null → returns the object with the connection or null
     */
    public function query($query, $type = '') {

        try {
                 
            if ($type === 'SELECT') {

                return $this->conn->query($query);

            } else {

                return $this->conn->exec($query);
            }

        } catch (\PDOException $e) {

            $this->error = $e->getMessage();

            return null;
        }
    }

    /**
     * Execute prepared queries.
     *
     * @since 1.0.0
     * 
     * @param string $query      → query
     * @param array  $statements → array with prepared parameters
     * 
     * @return object|null → returns the object with the connection or null
     */
    public function statements($query, $statements) {

        try {

            $query = $this->conn->prepare($query); 

            foreach ($statements as $key => $value) {

                $parameter = $statements[$key][0];
                $value     = $statements[$key][1];
                $dataType  = (isset($statements[$key][2]) ? $statements[$key][2] : false; 

                switch ($dataType) {
                    case 'bool':
                        $query->bindValue($parameter, $value, \PDO::PARAM_BOOL);
                        continue;

                    case 'null':
                        $query->bindValue($parameter, $value, \PDO::PARAM_NULL);
                        continue;

                    case 'int':
                        $query->bindValue($parameter, $value, \PDO::PARAM_INT);
                        continue;

                    case 'str':
                        $query->bindValue($parameter, $value, \PDO::PARAM_STR);
                        continue;
                }

                $query->bindValue($parameter, $value);
            }

            $query->execute();

            return $query;

        } catch (\PDOException $e) {

            $this->error = $e->getMessage();

            return null;
        }
    }

    /**
     * Create table statement.
     *
     * @since 1.0.0
     * 
     * @param string $table → table name
     * @param array  $data  → column name and configuration for data types
     * 
     * @return int → 0
     */
    public function create($table, $data) {

        $query = 'CREATE TABLE IF NOT EXISTS `' . $table . '` (';

        foreach ($data as $column => $value) {

            $query .= $column . ' ' . $value . ', ';
        }

        $query = rtrim(trim($query), ',') . ')'; # Remove final comma

        return $this->query($query);
    }

    /**
     * Selec statement.
     *
     * @since 1.0.0
     * 
     * @param mixed $columns     → column/s name
     * @param string $from       → table name
     * @param mixed  $where      → where clauses
     * @param mixed  $order      → query sort parameters
     * @param int    $limit      → query limiting parameters
     * @param array  $statements → array with prepared parameters
     * 
     * @return object → query response
     */
    public function select($columns, $from, $where, $order, $limit, $statements) {

        $query = 'SELECT ';

        $query .= (is_array($columns)) ? implode(', ', $columns) : $columns;

        $query .= ' FROM `' . $from . '` ';

        $query .= (!is_null($where)) ? ' WHERE ' : '';

        $query .= (is_string($where)) ? $where . ' ' : '';

        if (is_array($where)) {

            foreach ($where as $clause) {

                $query .= $clause . ' AND ';
            }

            $query = rtrim(trim($query), 'AND');
        } 

        $query .= (!is_null($order)) ? ' ORDER BY ' : '';

        $query .= (is_string($order)) ? $order . ' ' : '';

        if (is_array($order)) {

            foreach ($order as $value) {

                $query .= $value . ', ';
            }

            $query = rtrim(trim($query), ',');
        }

        $query .= (!is_null($limit)) ? ' LIMIT ' : '';

        $query .= (is_int($limit)) ? $limit . ' ' : '';

        if (!is_null($statements) && is_array($statements)) {

            return $this->statements(trim($query), $statements);
        }

        return $this->query(trim($query), 'SELECT');
    }

    /**
     * Insert into statement.
     *
     * @since 1.0.0
     * 
     * @param string $table      → table name
     * @param array  $data       → column name and value
     * @param array  $statements → array with prepared parameters
     * 
     * @return object → query response
     */
    public function insert($table, $data, $statements) {

        $input = ['columns' => '', 
                  'values'  => ''];

        $query = 'INSERT INTO `' . $table . '` ';

        foreach ($data as $column => $value) {

            $input['columns'] .= $column . ', ';

            $value = (is_null($statements) && is_string($value)) ? "'$value'" : $value;

            $input['values']  .= $value  . ', ';
        }

        $query .= '(' . rtrim(trim($input['columns']), ',') . ') ';

        $query .= 'VALUES (' . rtrim(trim($input['values']), ',') . ')';

        if (!is_null($statements) && is_array($statements)) {

            return $this->statements($query, $statements);
        }

        return $this->query($query, 'INSERT');
    }

    /**
     * Update statement.
     *
     * @since 1.0.0
     * 
     * @param string $table      → table name
     * @param array  $data       → column name and value
     * @param array  $statements → array with prepared parameters
     * @param mixed  $where      → where clauses
     * 
     * @return object → query response
     */
    public function update($table, $data, $statements, $where) {

        $query = 'UPDATE `' . $table . '`  SET ';

        foreach ($data as $column => $value) {

            $value = (is_null($statements) && is_string($value)) ? "'$value'" : $value;

            $query .= $column . '=' . $value . ', ';
        }

        $query = rtrim(trim($query), ',');

        $query .= (!is_null($where)) ? ' WHERE ' : '';

        $query .= (is_string($where)) ? $where . ' ' : '';

        if (is_array($where)) {

            foreach ($where as $clause) {

                $query .= $clause . ' AND ';
            }

            $query = rtrim(trim($query), 'AND');
        } 

        if (!is_null($statements) && is_array($statements)) {

            return $this->statements($query, $statements);
        }

        return $this->query($query, 'INSERT');
    }

    /**
     * Replace a row in a table if it exists or insert a new row in a table if not exist.
     *
     * @since 1.0.0
     * 
     * @param string $table      → table name
     * @param array  $data       → column name and value
     * @param array  $statements → array with prepared parameters
     * 
     * @return object → query response
     */
    public function replace($table, $data, $statements) {

        $columns = array_keys($data);

        $columnIdName = $columns[0];

        $id = array_shift($data);

        $where = $columnIdName . ' = ' . $id;

        $result = $this->select($columns, $table, $where, null, 1, $statements);

        if ($this->rowCount($result)) {

            return $this->update($table, $data, $statements, $where);
        }

        return $this->insert($table, $data, $statements);
    }

    /**
     * Delete statement.
     *
     * @since 1.0.0
     * 
     * @param string $table      → table name
     * @param array  $statements → array with prepared parameters
     * @param mixed  $where      → where clauses
     * 
     * @return object → query response
     */
    public function delete($table, $statements, $where) {

        $query = 'DELETE FROM `' . $table . '` ';

        $query .= (!is_null($where)) ? ' WHERE ' : '';

        $query .= (is_string($where)) ? $where . ' ' : '';

        if (is_array($where)) {

            foreach ($where as $clause) {

                $query .= $clause . ' AND ';
            }

            $query = rtrim(trim($query), 'AND');
        } 

        if (!is_null($statements) && is_array($statements)) {

            return $this->statements($query, $statements);
        }

        return $this->query($query, 'INSERT');
    }

    /**
     * Truncate table statement.
     *
     * @since 1.0.0
     * 
     * @param string $table → table name
     * 
     * @return int → 0
     */
    public function truncate($table) {

        $query = 'TRUNCATE TABLE `' . $table .'`';

        return $this->query($query);
    }

    /**
     * Drop table statement.
     *
     * @since 1.0.0
     * 
     * @param string $table → table name
     * 
     * @return int → 0
     */
    public function drop($table) {

        $query = 'DROP TABLE IF EXISTS `' . $table .'`';

        return $this->query($query);
    }

    /**
     * Process query as object or numeric or associative array.
     *
     * @since 1.0.0
     * 
     * @param object $response → query result
     * @param string $result   → result as an object or array
     * 
     * @return object|array → object or array with results
     */
    public function fetchResponse($response, $result) {

        if ($result == 'obj') { 

            return $response->fetchAll(\PDO::FETCH_OBJ);

        } else if ($result == 'array_num') {
            
            return $response->fetchAll(\PDO::FETCH_NUM);

        } else if ($result == 'array_assoc') {
            
            return $response->fetchAll(\PDO::FETCH_ASSOC);
        } 
    }

    /**
     * Get the last id of the query object.
     *
     * @since 1.0.0
     * 
     * @return int → last row id modified or added
     */
    public function lastInsertId() {

        return (int) $this->conn->lastInsertId();                  
    }

    /**
     * Get rows number.
     *
     * @since 1.0.0
     * 
     * @param object $response → query result
     *
     * @return int → rows number in query object
     */
    public function rowCount($response) {

        if (is_object($response)) {

            return (int) $response->rowCount();
        }

        return (int) $response;
    }
    
    /**
     * Get errors.
     *
     * @since 1.0.0
     * 
     * @return string → get the message if there has been any error
     */
    public function getError() {

        return $this->error;
    }

    /**
     * Check database connection state.
     *
     * @since 1.0.0
     * 
     * @return bool true|false → check the connection and return true or false
     */
    public function isConnected() {
        
        return !is_null($this->conn);
    }

    /**
     * Close/delete database connection.
     *
     * @since 1.0.0
     */
    public function kill() {
        
        $this->conn = null;
    }
}

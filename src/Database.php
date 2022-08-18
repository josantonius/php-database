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
namespace Josantonius\Database;

use Josantonius\Database\Exception\DBException;

/**
 * Database handler.
 */
class Database
{
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
     * @var object
     */
    public $provider;

    /**
     * Last insert id of the last query.
     *
     * @var int
     */
    public $lastInsertId;

    /**
     * Get number of rows affected of the last query.
     *
     * @var int
     */
    public $rowCount;

    /**
     * Database settings.
     *
     * @var array
     */
    public $settings;

    /**
     * Configurations for queries.
     *
     * @since 1.2.1
     *
     * @var null|array
     */
    private $items = [
        'on' => null, // array  → db reference table (foreing)
        'type' => null, // string → type of query
        'data' => null, // array  → columns and values
        'table' => null, // string → database table name
        'order' => null, // mixed  → order clause
        'charset' => null, // string → database charset
        'limit' => null, // int    → limit clause
        'where' => null, // mixed  → where clause
        'engine' => null, // string → database engine
        'result' => null, // string → result datatype: array|object|rows
        'columns' => null, // mixed  → columns
        'foreing' => null, // array  → foreing
        'actions' => null, // array  → action when delete/update (foreing)
        'reference' => null, // array  → references for foreing
        'statements' => null, // array  → prepared statements
    ];

    /**
     * Database connection.
     *
     * @var array
     */
    private static $conn;

    /**
     * Query.
     *
     * @var string
     */
    private $query;

    /**
     * Query response.
     *
     * @var object
     */
    private $response;

    /**
     * Database provider constructor.
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
     */
    protected function __construct(
        $provider,
        $host,
        $user,
        $name,
        $password,
        $settings
    ) {
        $provider = "Josantonius\\Database\\Provider\\$provider";

        if (! class_exists($provider)) {
            throw new DBException("The provider doesn't exist: $provider");
        }

        $this->provider = new $provider;

        $this->provider->connect($host, $user, $name, $password, $settings);

        if (! $this->provider->isConnected()) {
            throw new DBException(
                "Could not connect to provider: $provider. " .
                $this->provider->getError()
            );
        }

        $this->settings = $settings;
    }

    /**
     * Close connection to database.
     */
    public function __destruct()
    {
        $this->provider->kill();
    }

    /**
     * Get connection.
     *
     * Create a new if it doesn't exist or another provider is used.
     *
     * @param string $id                  → identifying name for the database
     * @param string $provider            → name of provider class
     * @param string $host                → database host
     * @param string $user                → database user
     * @param string $name                → database name
     * @param string $password            → database password
     * @param array  $settings            → database options
     * @param string $settings['port']    → database port
     * @param string $settings['charset'] → database charset
     *
     * @return object → object with the connection
     */
    public static function getConnection(
        $id,
        $provider = null,
        $host = null,
        $user = null,
        $name = null,
        $password = null,
        $settings = null
    ) {
        if (isset(self::$conn[self::$id = $id])) {
            return self::$conn[$id];
        }

        return self::$conn[$id] = new self(
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
    public function query($query, $statements = null, $result = 'obj')
    {
        $this->items['type'] = trim(explode(' ', $query)[0]);

        $this->query = $query;

        $this->items['result'] = $result;
        $this->items['statements'] = $statements;

        $types = '|SELECT|INSERT|UPDATE|DELETE|CREATE|TRUNCATE|DROP|USE|';

        if (! strpos($types, $this->items['type'])) {
            throw new DBException(
                'Unknown query type:' . $this->items['type']
            );
        }

        $this->implement();

        return $this->getResponse();
    }

    /**
     * Create table statement.
     *
     * @param array $data → column name and configuration for data types
     *
     * @return object
     */
    public function create($data)
    {
        $this->items['type'] = 'CREATE';
        $this->items['data'] = $data;

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
    public function foreing($id)
    {
        $this->items['foreing'][] = $id;

        return $this;
    }

    /**
     * Set reference for foreing keys.
     *
     * @since 1.1.2
     *
     * @param array $table → table name
     *
     * @return object
     */
    public function reference($table)
    {
        $this->items['reference'][] = $table;

        return $this;
    }

    /**
     * Set database table name.
     *
     * @since 1.1.2
     *
     * @param array $table → table name
     *
     * @return object
     */
    public function on($table)
    {
        $this->items['on'][] = $table;

        return $this;
    }

    /**
     * Set actions when delete or update for foreing key.
     *
     * @since 1.1.2
     *
     * @param string $action → action when delete or update
     *
     * @return object
     */
    public function actions($action)
    {
        $this->items['actions'][] = $action;

        return $this;
    }

    /**
     * Set engine.
     *
     * @since 1.1.2
     *
     * @param string $type → engine type
     *
     * @return object
     */
    public function engine($type)
    {
        $this->items['engine'] = $type;

        return $this;
    }

    /**
     * Set charset.
     *
     * @since 1.1.2
     *
     * @return object
     */
    public function charset($type)
    {
        $this->items['charset'] = $type;

        return $this;
    }

    /**
     * Select statement.
     *
     * @param mixed $columns → column/s name
     *
     * @return object
     */
    public function select($columns = '*')
    {
        $this->items['type'] = 'SELECT';
        $this->items['columns'] = $columns;

        return $this;
    }

    /**
     * Insert into statement.
     *
     * @param array $data       → column name and value
     * @param array $statements → null by default or array for statements
     *
     * @return object
     */
    public function insert($data, $statements = null)
    {
        $this->items['type'] = 'INSERT';
        $this->items['data'] = $data;
        $this->items['statements'] = $statements;

        return $this;
    }

    /**
     * Update statement.
     *
     * @param array $data       → column name and value
     * @param array $statements → null by default or array for statements
     *
     * @return object
     */
    public function update($data, $statements = null)
    {
        $this->items['type'] = 'UPDATE';
        $this->items['data'] = $data;
        $this->items['statements'] = $statements;

        return $this;
    }

    /**
     * Replace a row in a table if it exists or insert a new row if not exist.
     *
     * @param array $data       → column name and value
     * @param array $statements → null by default or array for statements
     *
     * @return object
     */
    public function replace($data, $statements = null)
    {
        $this->items['type'] = 'REPLACE';
        $this->items['data'] = $data;
        $this->items['statements'] = $statements;

        return $this;
    }

    /**
     * Delete statement.
     *
     * @return object
     */
    public function delete()
    {
        $this->items['type'] = 'DELETE';

        return $this;
    }

    /**
     * Truncate table statement.
     *
     * @return object
     */
    public function truncate()
    {
        $this->items['type'] = 'TRUNCATE';

        return $this;
    }

    /**
     * Drop table statement.
     *
     * @return object
     */
    public function drop()
    {
        $this->items['type'] = 'DROP';

        return $this;
    }

    /**
     * Set database table name.
     *
     * @param string $table → table name
     *
     * @return object
     */
    public function in($table)
    {
        $this->items['table'] = $table;

        return $this;
    }

    /**
     * Set database table name.
     *
     * @param string $table → table name
     *
     * @return object
     */
    public function table($table)
    {
        $this->items['table'] = $table;

        return $this;
    }

    /**
     * Set database table name.
     *
     * @param string $table → table name
     *
     * @return object
     */
    public function from($table)
    {
        $this->items['table'] = $table;

        return $this;
    }

    /**
     * Where clauses.
     *
     * @param mixed $clauses    → column name and value
     * @param array $statements → null by default or array for statements
     *
     * @return object
     */
    public function where($clauses, $statements = null)
    {
        $this->items['where'] = $clauses;

        if (is_array($this->items['statements'])) {
            $this->items['statements'] = array_merge(
                $this->items['statements'],
                $statements
            );
        } else {
            $this->items['statements'] = $statements;
        }

        return $this;
    }

    /**
     * Set SELECT order.
     *
     * @param string $type → query sort parameters
     *
     * @return object
     */
    public function order($type)
    {
        $this->items['order'] = $type;

        return $this;
    }

    /**
     * Set SELECT limit.
     *
     * @param int $number → query limiting parameters
     *
     * @return object
     */
    public function limit($number)
    {
        $this->items['limit'] = $number;

        return $this;
    }

    /**
     * Execute query.
     *
     * @param string $result → 'obj'         → result as object
     *                       → 'array_num'   → result as numeric array
     *                       → 'array_assoc' → result as associative array
     *                       → 'rows'        → affected rows number
     *                       → 'id'          → last insert id
     *
     * @return int → number of lines updated or 0 if not updated
     */
    public function execute($result = 'obj')
    {
        $this->items['result'] = $result;

        $type = strtolower($this->items['type']);

        switch ($this->items['type']) {
            case 'SELECT':
                $params = [
                    $this->items['columns'],
                    $this->items['table'],
                    $this->items['where'],
                    $this->items['order'],
                    $this->items['limit'],
                    $this->items['statements'],
                    $this->items['result'],
                ];
                break;
            case 'INSERT':
                $params = [
                    $this->items['table'],
                    $this->items['data'],
                    $this->items['statements'],
                ];
                break;
            case 'UPDATE':
                $params = [
                    $this->items['table'],
                    $this->items['data'],
                    $this->items['statements'],
                    $this->items['where'],
                ];
                break;
            case 'REPLACE':
                $params = [
                    $this->items['table'],
                    $this->items['data'],
                    $this->items['statements'],
                ];
                break;
            case 'DELETE':
                $params = [
                    $this->items['table'],
                    $this->items['statements'],
                    $this->items['where'],
                ];
                break;
            case 'CREATE':
                $params = [
                    $this->items['table'],
                    $this->items['data'],
                    $this->items['foreing'],
                    $this->items['reference'],
                    $this->items['on'],
                    $this->items['actions'],
                    $this->items['engine'],
                    $this->items['charset'],
                ];
                break;
            case 'TRUNCATE':
                $params = [
                    $this->items['table'],
                ];
                break;
            case 'DROP':
                $params = [
                    $this->items['table'],
                ];
                break;
        }

        $provider = [$this->provider, $type];

        $this->response = call_user_func_array($provider, $params);

        return $this->getResponse();
    }

    /**
     * Query handler.
     *
     * @return object → returns query to be executed by provider class
     */
    private function implement()
    {
        if (is_array($this->items['statements'])) {
            return $this->implementPrepareStatements();
        }

        return $this->implementQuery();
    }

    /**
     * Run query with prepared statements.
     */
    private function implementPrepareStatements()
    {
        $this->response = $this->provider->statements(
            $this->query,
            $this->items['statements']
        );
    }

    /**
     * Run query without prepared statements.
     */
    private function implementQuery()
    {
        $this->response = $this->provider->query(
            $this->query,
            $this->items['type']
        );
    }

    /**
     * Get response after executing the query.
     *
     * @throws DBException → error executing query
     *
     * @return mixed → result as object, array, int...
     */
    private function getResponse()
    {
        $this->lastInsertId = $this->provider->lastInsertId();

        $this->rowCount = $this->provider->rowCount($this->response);

        if (is_null($this->response)) {
            $this->reset();
            throw new DBException(
                'Error executing the query ' . $this->provider->getError()
            );
        }

        $response = $this->fetchResponse();

        $this->reset();

        return $response;
    }

    /**
     * Process query as object or numeric or associative array.
     *
     * @return mixed|bool → results
     */
    private function fetchResponse()
    {
        $type = $this->items['type'];

        if (strpos('|INSERT|UPDATE|DELETE|REPLACE|', $type)) {
            if ($this->items['result'] === 'id') {
                return $this->lastInsertId;
            }

            return $this->rowCount;
        } elseif ($type === 'SELECT') {
            if ($this->items['result'] !== 'rows') {
                return $this->provider->fetchResponse(
                    $this->response,
                    $this->items['result']
                );
            }
            if (is_object($this->response)) {
                return $this->provider->rowCount($this->response);
            }
        }

        return true;
    }

    /**
     * Reset query parameters.
     */
    private function reset()
    {
        $this->items['columns'] = null;
        $this->items['table'] = null;
        $this->items['where'] = null;
        $this->items['order'] = null;
        $this->items['limit'] = null;
        $this->items['statements'] = null;
        $this->items['foreing'] = null;
        $this->items['reference'] = null;
        $this->items['on'] = null;
        $this->items['actions'] = null;
        $this->items['engine'] = null;
        $this->items['charset'] = null;
    }
}

# PHP Database library

[![Latest Stable Version](https://poser.pugx.org/josantonius/Database/v/stable)](https://packagist.org/packages/josantonius/Database) [![Latest Unstable Version](https://poser.pugx.org/josantonius/Database/v/unstable)](https://packagist.org/packages/josantonius/Database) [![License](https://poser.pugx.org/josantonius/Database/license)](LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/bc05a7b06c554a3e844ece8f360a05ed)](https://www.codacy.com/app/Josantonius/PHP-Database?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Josantonius/PHP-Database&amp;utm_campaign=Badge_Grade) [![Total Downloads](https://poser.pugx.org/josantonius/Database/downloads)](https://packagist.org/packages/josantonius/Database) [![Travis](https://travis-ci.org/Josantonius/PHP-Database.svg)](https://travis-ci.org/Josantonius/PHP-Database) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![CodeCov](https://codecov.io/gh/Josantonius/PHP-Database/branch/master/graph/badge.svg)](https://codecov.io/gh/Josantonius/PHP-Database)

[Versión en español](README-ES.md)

SQL database management to be used by several providers at the same time.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Get connection](#get-connection)
- [CREATE TABLE](#create-table)
- [SELECT](#select)
- [INSERT INTO](#insert)
- [UPDATE](#update)
- [REPLACE](#replace)
- [DELETE](#delete)
- [TRUNCATE TABLE](#truncate)
- [DROP TABLE](#drop)
- [Tests](#tests)
- [TODO](#-todo)
- [Exception Handler](#exception-handler)
- [Contribute](#contribute)
- [Repository](#repository)
- [License](#license)
- [Copyright](#copyright)

---

### Requirements

This library is supported by `PHP versions 5.6` or higher and is compatible with `HHVM versions 3.0` or higher.

### Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install `PHP Database library`, simply:

    $ composer require Josantonius/Database

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    $ composer require Josantonius/Database --prefer-source

You can also **clone the complete repository** with Git:

    $ git clone https://github.com/Josantonius/PHP-Database.git

Or **install it manually**:

Download [Database.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Database.php), [Provider.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/Provider.php), [PDOprovider.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/PDOprovider.php), [MSSQLprovider.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/MSSQLprovider.php) and [DBException.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Exception/DBException.php):

    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Database.php
    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/Provider.php
    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/PDOprovider.php
    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/MSSQLprovider.php
    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Exception/DBException.php

### Get connection

`Get connection:`

```php
Database::getConnection($id, $provider, $host, $user, $name, $password, $settings);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $id | Database unique ID. | string | Yes | |
| $provider | Name of provider class. | string | No | null |
| $host | Database host. | string | No | null |
| $user | Database user. | string | No | null |
| $name | Database name. | string | No | null |
| $password | Database password . | string | No | null |

| Attribute | Key | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| $settings | | Database options. | array | No | null |
| $settings | 'port' | Database port. | string | No |  |
| $settings | 'charset' | Database charset. | string | No | |

**# Return** (object) → object with the connection

```php
$db = Database::getConnection(
    'identifier',  # Unique identifier
    'PDOprovider', # Database provider name
    'localhost',   # Database server
    'db-user',     # Database user
    'db-name',     # Database name
    'password',    # Database password
    array('charset' => 'utf8')
);

$externalDB = Database::getConnection(
    'external',          # Unique identifier
    'PDOprovider',       # Database provider name
    'http://site.com',   # Database server
    'db-user',           # Database user
    'db-name',           # Database name
    'password',          # Database password
    array('charset' => 'utf8')
);

// And once the connection is established:

$db = Database::getConnection('identifier');

$externalDB = Database::getConnection('external');
```

### Query

`Process query and prepare it for the provider:`

```php
$db->query($query, $statements, $result);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $query | Query. | string | Yes | |
| $statements | Statements. | array | No | null |
| $result | Query result; 'obj', 'array_num', 'array_assoc', 'rows', 'id'. | string | No | 'obj' |

**# Return** (mixed) → result as object, array, int...

**# throws** [DBException] → invalid query type

```php
$db->query(
    'CREATE TABLE test (
        id    INT(6)      PRIMARY KEY,
        name  VARCHAR(30) NOT NULL,
        email VARCHAR(50)
    )'
);

$db->query(
    'SELECT id, name, email
     FROM test',
    false,
    'array_assoc' // array_assoc, obj, array_num
);

$statements[] = [1, "Many"];
$statements[] = [2, "many@email.com"];
        
$db->query(
    'INSERT INTO test (name, email)
     VALUES (?, ?)',
    $statements,
    'id' // id, rows
);
```

### CREATE TABLE

`CREATE TABLE statement:`

```php
$db->create($data)
   ->table($table)
   ->foreing($id)
   ->reference($table)
   ->on($table)
   ->actions($action)
   ->engine($type)
   ->charset($type)
   ->execute();
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| | $data | Column name and configuration for data types. | array | Yes | |
| table() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| foreing() | | Set foreing key. | method | No | |
| | $id | Column id. | string | Yes | |
| reference() | | Set reference for foreing keys. | method | No | |
| | $table | Table name. | array | Yes | |
| on() | | Set database table name. | method | No | |
| | $table | Table name. | array | Yes | |
| actions() | | Set actions when delete or update for foreing key. | method | No | |
| | $action | Action when delete or update. | array | Yes | |
| engine() | | Set table engine. | method | No | |
| | $type | Engine type. | string | Yes | |
| charset() | | Set table charset. | method | No | |
| | $type | Charset type. | string | Yes | |
| execute() | | Execute query. | method | Yes | |

**# Return** (boolean)

```php
$params = [
    'id'    => 'INT(6) PRIMARY KEY',
    'name'  => 'VARCHAR(30) NOT NULL',
    'email' => 'VARCHAR(50)'
];

$query = $db->create($params)
            ->table('test')
            ->execute();

$db->create($params)
   ->table('test_two')
   ->foreing('id')
   ->reference('id')
   ->on('test')
   ->actions('ON DELETE CASCADE ON UPDATE CASCADE')
   ->engine('innodb')
   ->charset('utf8')
   ->execute();
```

### SELECT

`SELECT statement:`

```php
$db->select($columns)
   ->from($table)
   ->where($clauses, $statements)
   ->order($type)
   ->limit($number)
   ->execute($result);
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| | $columns | Column/s name. | mixed | No | '*' |
| from() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| where() | | Where clauses. | method | No | |
| | $clauses | Column name and value. | mixed | Yes | |
| | $statements | Statements. | array | No | null |
| order() | | Order. | method | No | |
| | $type | Query sort parameters. | string | Yes | |
| limit() | | Limit. | method | No | |
| | $number | Number. | int | Yes | |
| execute() | | Execute query. | method | Yes | |
| | $result | Query result; 'obj', 'array_num', 'array_assoc', 'rows'. | string | No | 'obj' |

**# Return** (mixed) → query result  (object, array, int...) or rows affected

```php
#SELECT all
$db->select()
    ->from('test')
    ->execute('array_num');

#SELECT with all params
$db->select(['id', 'name'])
   ->from('test')
   ->where(['id = 4885', 'name = "Joe"'])
   ->order(['id DESC', 'name ASC'])
   ->limit(1)
   ->execute('obj');

#SELECT with statements
$statements[] = [1, 3008];
$statements[] = [2, 'Manny'];
        
$db->select('name')
   ->from('test')
   ->where('id = ? OR name = ?', $statements)
   ->execute('rows');

#Other version of SELECT with statements
$statements[] = [':id', 8, 'int'];
$statements[] = [':email', null, 'null'];

$clauses = [
    'id    = :id',
    'email = :email'
];

$db->select('name')
   ->from('test')
   ->where($clauses, $statements)
   ->execute('rows');
```

### INSERT INTO

`INSERT INTO statement:`

```php
$db->insert($data, $statements)
   ->in($table)
   ->execute($result);
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| | $data | Column name and value. | array | Yes | |
| | $statements | Statements. | array | No | null |
| in() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| execute() | | Execute query. | method | Yes | |
| | $result | Query result; 'rows', 'id'. | string | No | 'rows' |

**# Return** (int) → rows affected or last row affected ID

```php
#INSERT INTO basic example
$data = [
    "name"  => "Isis",
    "email" => "isis@email.com",
];
        
$db->insert($data)
   ->in('test')
   ->execute();

#INSERT INTO with statements
$data = [
    "name"  => "?",
    "email" => "?",
];

$statements[] = [1, "Isis"];
$statements[] = [2, "isis@email.com"];

$db->insert($data, $statements)
   ->in('test')
   ->execute('rows');

#Other version of INSERT INTO with statements
$data = [
    "name"  => ":name",
    "email" => ":email",
];

$statements[] = [":name", "Isis", "str"];
$statements[] = [":email", "isis@email.com", "str"];

$db->insert($data, $statements)
   ->in('test')
   ->execute('id');
```

### UPDATE

`UPDATE statement:`

```php
$db->update($data, $statements)
   ->in($table)
   ->where($clauses, $statements)
   ->execute();
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| | $data | Column name and value. | array | Yes | |
| | $statements | Statements. | array | No | null |
| in() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| where() | | Where clauses. | method | No | |
| | $clauses | Column name and value. | mixed | Yes | |
| | $statements | Statements. | array | No | null |
| execute() | | Execute query. | method | Yes | |

**# Return** (int) → rows affected 

```php
#UPDATE basic example
$data = [
    'name'  => 'Isis',
    'email' => 'isis@email.com',
];

$db->update($data)
   ->in('test')
   ->execute();

#UPDATE with WHERE
$data = [
    'name'  => 'Manny',
    'email' => 'manny@email.com',
];

$clauses = [
    'name  = "isis"',
    'email = "isis@email.com"'
];

$db->update($data)
   ->in('test')
   ->where($clauses)
   ->execute();

#UPDATE with statements
$data = [
    'name'  => '?',
    'email' => '?',
];

$statements['data'][] = [1, 'Isis'];
$statements['data'][] = [2, 'isis@email.com'];

$clauses = 'id = ? AND name = ? OR name = ?';

$statements['clauses'][] = [3, 4883];
$statements['clauses'][] = [4, 'Isis'];
$statements['clauses'][] = [5, 'Manny'];

$db->update($data, $statements['data'])
   ->in('test')
   ->where($clauses, $statements['clauses'])
   ->execute();

#Other version of UPDATE with statements
$data = [
    'name'  => ':new_name',
    'email' => ':new_email',
];

$statements['data'][] = [':new_name', 'Manny', 'str'];
$statements['data'][] = [':new_email', 'manny@email.com', 'str'];

$clauses = 'name = :name1 OR name = :name2';

$statements['clauses'][] = [':name1', 'Isis', 'str'];
$statements['clauses'][] = [':name2', 'Manny', 'str'];

$db->update($data, $statements['data'])
   ->in('test')
   ->where($clauses, $statements['clauses'])
   ->execute();
```

### REPLACE

`Replace a row in a table if it exists or insert a new row if not exist:`

```php
$db->replace($data, $statements)
   ->from($table)
   ->execute($result);
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| | $data | Column name and value. | array | Yes | |
| | $statements | Statements. | array | No | null |
| from() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| execute() | | Execute query. | method | Yes | |
| | $result | Query result; 'rows', 'id'. | string | No | 'rows' |

**# Return** (int) → rows affected or last row affected ID

```php
#REPLACE basic example
$data = [
    'id'    => 3008,
    'name'  => 'Manny',
    'email' => 'manny@email.com',
];

$db->replace($data)
   ->from('test')
   ->execute();

#UPDATE with statements
$data = [
    'id'    => 4889,
    'name'  => ':name',
    'email' => ':email',
];

$statements[] = [':name', 'Manny'];
$statements[] = [':email', 'manny@email.com'];

$db->replace($data, $statements)
   ->from('test')
   ->execute('rows');

#Other version of UPDATE with statements
$data = [
    'id'    => 2,
    'name'  => '?',
    'email' => '?',
];

$statements[] = [1, 'Manny'];
$statements[] = [2, 'manny@email.com'];

$db->replace($data, $statements)
   ->from('test')
   ->execute('id');
```

### DELETE

`DELETE statement:`

```php
$db->replace($data, $statements)
   ->from($table)
   ->where($clauses, $statements)
   ->execute();
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| | $data | Column name and value. | array | Yes | |
| | $statements | Statements. | array | No | null |
| from() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| where() | | Where clauses. | method | No | |
| | $clauses | Column name and value. | mixed | Yes | |
| | $statements | Statements. | array | No | null |
| execute() | | Execute query. | method | Yes | |

**# Return** (int) → rows affected 

```php
#DELETE all
$db->delete()
   ->from('test')
   ->execute();

#DELETE with WHERE
$clauses = [
    'id = 4884',
    'name  = "isis"',
    'email = "isis@email.com"',
];

$db->delete()
   ->from('test')
   ->where($clauses)
   ->execute();

#DELETE with statements
$clauses = 'id = :id AND name = :name1 OR name = :name2';

$statements[] = [':id', 4885];
$statements[] = [':name1', 'Isis'];
$statements[] = [':name2', 'Manny'];

$db->delete()
   ->from('test')
   ->where($clauses, $statements)
   ->execute();

#Other version of DELETE with statements
$clauses = 'id = :id AND name = :name1 OR name = :name2';

$statements[] = [':id', 4886, 'int'];
$statements[] = [':name1', 'Isis', 'src'];
$statements[] = [':name2', 'Manny', 'src'];

$db->delete()
   ->from('test_table')
   ->where($clauses, $statements)
   ->execute();
```

### TRUNCATE TABLE

`TRUNCATE TABLE statement:`

```php
$db->truncate()
   ->table($table)
   ->execute();
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| table() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| execute() | | Execute query. | method | Yes | |

**# Return** (boolean)

```php
$db->truncate()
   ->table('test')
   ->execute();
```

### DROP TABLE

`DROP TABLE statement:`

```php
$db->drop()
   ->table($table)
   ->execute();
```

| Method | Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| table() | | Set database table name. | method | Yes | |
| | $table | Table name. | string | Yes | |
| execute() | | Execute query. | method | Yes | |

**# Return** (boolean)

```php
$db->drop()
   ->table('test')
   ->execute();
```

### Quick Start

To use this class with `Composer`:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Database\Database;
```

Or If you installed it `manually`, use it:

```php
require_once __DIR__ . '/Database.php';

use Josantonius\Database\Database;
```

### Tests 

To run [tests](tests) you just need [Composer](http://getcomposer.org/download/) and to execute the following:

    $ git clone https://github.com/Josantonius/PHP-Database.git
    
    $ cd PHP-Database

    $ mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS phpunit CHARACTER SET utf8 COLLATE utf8_general_ci; CREATE USER 'travis'@'127.0.0.1' IDENTIFIED BY ''; GRANT ALL ON phpunit.* TO 'travis'@'127.0.0.1'; FLUSH PRIVILEGES;"
    
    $ composer install

Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Run all previous tests:

    $ composer tests

### ☑ TODO

- [x] Create tests
- [ ] Refactorizate code
- [ ] Add methods for SQL joins
- [ ] Complete provider for MSSQL
- [x] Improve documentation

### Exception Handler

This library uses [exception handler](src/Exception) that you can customize.

### Contribute

1. Check for open issues or open a new issue to start a discussion around a bug or feature.
1. Fork the repository on GitHub to start making your changes.
1. Write one or more tests for the new feature or that expose the bug.
1. Make code changes to implement the feature or fix the bug.
1. Send a pull request to get your changes merged and published.

This is intended for large and long-lived objects.

### Repository

All files in this repository were created and uploaded automatically with [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).
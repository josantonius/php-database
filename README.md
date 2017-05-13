# PHP Database library

[![Latest Stable Version](https://poser.pugx.org/josantonius/database/v/stable)](https://packagist.org/packages/josantonius/database) [![Total Downloads](https://poser.pugx.org/josantonius/database/downloads)](https://packagist.org/packages/josantonius/database) [![Latest Unstable Version](https://poser.pugx.org/josantonius/database/v/unstable)](https://packagist.org/packages/josantonius/database) [![License](https://poser.pugx.org/josantonius/database/license)](https://packagist.org/packages/josantonius/database)

[Versión en español](README-ES.md)

Library for SQL database management to be used by several providers at the same time.

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)
- [Available Methods](#available-methods)
- [Usage](#usage)
- [Select](#select)
- [Insert](#insert)
- [Update](#update)
- [Replace](#replace)
- [Delete](#delete)
- [Create](#create)
- [Truncate](#truncate)
- [Drop](#drop)
- [Tests](#tests)
- [Exception Handler](#exception-handler)
- [Contribute](#contribute)
- [Repository](#repository)
- [Licensing](#licensing)
- [Copyright](#copyright)

---

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install PHP Database library, simply:

    $ composer require Josantonius/Database

The previous command will only install the necessary files, if you prefer to download the entire source code (including tests, vendor folder, exceptions not used, docs...) you can use:

    $ composer require Josantonius/Database --prefer-source

Or you can also clone the complete repository with Git:

    $ git clone https://github.com/Josantonius/PHP-Database.git

### Requirements

This library is supported by PHP versions 5.6 or higher and is compatible with HHVM versions 3.0 or higher.

### Quick Start and Examples

To use this class, simply:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Database\Database;
```
### Available Methods

Available methods in this library:

```php
Database::getConnection();
Database->query();
Database->create();
Database->select();
Database->insert();
Database->update();
Database->replace();
Database->delete();
Database->truncate();
Database->drop();
Database->in();
Database->table();
Database->from();
Database->where();
Database->order();
Database->limit();
Database->execute();
```
### Usage

Example of use for this library:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Database\Database;

$db = Database::getConnection('identifier',	  #	Unique identifier for the connection
		                      'PDOprovider',  # Database provider name
		                      'localhost',	  # Database server
		                      'db-user',	  # Database user
		                      'db-name',	  # Database name
		                      'password',	  # Database password
		                      array('charset' => 'utf8'));
```

### Select

Select data from database.

```php
$db->select()->from()->where()->order()->limit()->execute();
```

**select**($columns)

$columns → (array|string|empty) Names of columns to select. If left blank select all fields (*).

**from**($table)

$table → (string) Database table name.

**where**($clauses, $statements) (Optional)

$clauses    → (array|string)     → Where clauses.

$statements → (array) (Optional) → Prepared statements.

**order**($params) (Optional)

$params → (array|string) → Parameters to sort query.

**limit**($number) (Optional)

$number → (int) → Rows number limit.

**execute**($dataType)

$dataType → (string|empty) → Accepted parameters: 'obj', 'array_num', 'array_assoc' & 'rows'.

**SELECT** query example. For more examples see the [DatabaseSelectTest](tests/DatabaseSelectTest.php) class.

```php
$statements[] = [':id',   1,       'int'];
$statements[] = [':name', 'Manny', 'str'];

$clauses = ['id = :id', 'name = :name'];

$query = $db->select('name')
            ->from('test')
            ->where($clauses, $statements);
            ->order('id DESC')
            ->limit(1);

$result = $query->execute('obj');
```

### Insert

Insert data into database.

```php
$db->insert()->in()->execute();
```

**insert**($data, $statements)

$data       → (array)            → Name of columns and values to be inserted.

$statements → (array) (Optional) → Prepared statements.

**in**($table)

$table → (string) Database table name.

**execute**($dataType)

$dataType → (string|empty) → Accepted parameters: 'rows' & 'id'.

**INSERT** query example. For more examples see the [DatabaseInsertTest](tests/DatabaseInsertTest.php) class.

```php
$statements[] = [1, "Isis"];
$statements[] = [2, "isis@email.com"];

$data = [
    "name"  => "?", 
    "email" => "?"
];

$query = $db->insert($data, $statements)
		    ->in('test');

$result = $query->execute('id');
```

### Update

Update fields in the database.

```php
$db->update()->in()->where()->execute();
```

**update**($data, $statements)

$data       → (array)            → Name of columns and values to be inserted.

$statements → (array) (Optional) → Prepared statements.

**where**($clauses, $statements) (Optional)

$clauses    → (array|string)     → Where clauses.

$statements → (array) (Optional) → Prepared statements.

**execute**($dataType)

$dataType → (string|empty) → Accepted parameters: 'rows' & 'id'.

**UPDATE** query example. For more examples see the [DatabaseUpdateTest](tests/DatabaseUpdateTest.php) class.

```php
$data = [
    'name'  => ':new_name', 
    'email' => ':new_email'
];

$statements['data'][] = [':new_name',  'Manny',           'str'];
$statements['data'][] = [':new_email', 'manny@email.com', 'str'];

$clauses = 'id = :id AND name = :name1 OR name = :name2';

$statements['clauses'][] = [':id',         1,      'int'];
$statements['clauses'][] = [':name1',     'Isis',  'str'];
$statements['clauses'][] = [':name2',     'Manny', 'str'];


$query = $db->update($data, $statements['data'])
            ->in('test')
            ->where($clauses, $statements['clauses']);

$result = $query->execute();
```

### Replace

Replace a row in a table if it exists or insert a new row in a table if not exist.

```php
$db->replace()->from()->execute();
```

**replace**($data, $statements)

$data       → (array)            → Name of columns and values to be replaced.

$statements → (array) (Optional) → Prepared statements.

**from**($table)

$table → (string) Database table name.

**execute**($dataType)

$dataType → (string|empty) → Accepted parameters: 'rows' & 'id'.

**REPLACE** example. For more examples see the [DatabaseReplaceTest](tests/DatabaseReplaceTest.php) class.

```php
$data = [
    'id'    => 1,
    'name'  => 'Manny', 
    'email' => 'manny@email.com'
];

$query = $db->replace($data)
            ->from('test');

$result = $query->execute();
```

### Delete

Delete fields in the database.

```php
$db->delete()->from()->where()->execute();
```

**delete()**

This method has no attributes.

**from**($table)

$table → (string) Database table name.

**where**($clauses, $statements) (Optional)

$clauses    → (array|string)     → Where clauses.

$statements → (array) (Optional) → Prepared statements.

**execute**($dataType)

$dataType → (string|empty) → Accepted parameters: 'rows' & 'id'.

**DELETE** query example. For more examples see the [DatabaseDeleteTest](tests/DatabaseDeleteTest.php) class.

```php
$query = $db->delete()
            ->from('test')
            ->where('id = 1');

$result = $query->execute();
```

### Create

Create table in database.

```php
$db->create()->table()->execute();
```

**create**($params)

$params → (array) → Parameters of configuration for the columns.

**table**($table)

$table → (string) Database table name.

**foreing**($foreing_key) (Optional)

$foreing_key → (string) Foreing key.

**references**($references) (Optional)

$references → (string) Column reference.

**on**($table) (Optional)

$table → (string) Table reference.

**actions**($actions) (Optional)

$actions → (string) Actions when delete or update for foreing key.

**engine**($engine) (Optional)

$engine → (string) Database engine.

**charset**($charset) (Optional)

$charset → (string) Database charset.

**execute()**

This method has no attributes.

**CREATE** query example. For more examples see the [DatabaseCreateTest](tests/DatabaseCreateTest.php) class.

```php
$params = [
    'id'       => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', 
    'name'     => 'VARCHAR(30) NOT NULL',
    'email'    => 'VARCHAR(50)',
    'reg_date' => 'TIMESTAMP'
];

$query = static::$db->create($params)
                    ->table('test');

$result = $query->execute();
```

### Truncate

Truncate table in database.

```php
$db->truncate()->table()->execute();
```

**truncate()**

This method has no attributes.

**table**($table)

$table → (string) Database table name.

**execute()**

This method has no attributes.

**TRUNCATE** query example. For more examples see the [DatabaseTruncateTest](tests/DatabaseTruncateTest.php) class.

```php
$query = $db->truncate()
            ->table('test');

$result = $query->execute();
```

### Drop

Drop table in database.

```php
$db->drop()->table()->execute();
```

**drop()**

This method has no attributes.

**table**($table)

$table → (string) Database table name.

**execute()**

This method has no attributes.

**DROP** query example. For more examples see the [DatabaseDropTest](tests/DatabaseDropTest.php) class.

```php
$query = $db->drop()
            ->table('test');

$result = $query->execute();
```

### Tests 

To use the [test](tests) class, simply:

```php
<?php
$loader = require __DIR__ . '/vendor/autoload.php';

$loader->addPsr4('Josantonius\\Database\\Tests\\', __DIR__ . '/vendor/josantonius/database/tests');

use Josantonius\Database\Tests\DatabaseCreateTest;
use Josantonius\Database\Tests\DatabaseDropTest;
use Josantonius\Database\Tests\DatabaseInsertTest;
use Josantonius\Database\Tests\DatabaseSelectTest;
use Josantonius\Database\Tests\DatabaseTruncateTest;
use Josantonius\Database\Tests\DatabaseUpdateTest;
use Josantonius\Database\Tests\DatabaseDeleteTest;
use Josantonius\Database\Tests\DatabaseReplaceTest;
```

Some methods available in this library.:

```php
DatabaseCreateTest::testCreateTableMethod();
DatabaseDropTest::testDropTableMethod();
DatabaseTruncateTest::testTruncateTableMethod();
DatabaseSelectTest::testSelectMethod();
DatabaseInsertTest::testInsertMethod();
DatabaseDeleteTest::testDeleteMethod();
DatabaseReplaceTest::testReplaceMethod();
```

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

### Licensing

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).
# CHANGELOG

## 1.1.6 - 2017-09-26

* Unit tests supported by `PHPUnit` were added.

* The repository was synchronized with `Travis CI` to implement continuous integration.

* Type attributes were deleted from HTML tags. Since HTML5 doesn't longer necessary.
 
* Added `Database/src/bootstrap.php` file

* Added `Database/tests/bootstrap.php` file.

* Added `Database/phpunit.xml.dist` file.
* Added `Database/_config.yml` file.
* Added `Database/.travis.yml` file.

* Renamed `Josantonius\Provider\PDOprovider` class to `Josantonius\Provider\PDOprovider\PDOprovider` class. 

* Renamed `Josantonius\Provider\MSSQLprovider` class to `Josantonius\Provider\MSSQLprovider\MSSQLprovider` class.

* Added `Josantonius\Database\Test\ConnectionTest` class
* Added `Josantonius\Database\Test\ConnectionTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\ConnectionTest->testGetConnectionFromEliasis()` method.
* Added `Josantonius\Database\Test\ConnectionTest->testExceptionWhenProviderNotExists()` method.
* Added `Josantonius\Database\Test\ConnectionTest->testExceptionNameOrServiceNotKnown()` method.
* Added `Josantonius\Database\Test\ConnectionTest->testExceptionAccessDeniedForUser()` method.
* Added `Josantonius\Database\Test\ConnectionTest->testExceptionAccessDeniedForUserPassword()` method.
* Added `Josantonius\Database\Test\ConnectionTest->testExceptionAccessDeniedForUserName()` method.

* Added `Josantonius\Database\Test\CreateTest` class
* Added `Josantonius\Database\Test\CreateTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\CreateTest->testCreateTableQuery()` method.
* Added `Josantonius\Database\Test\CreateTest->testCreateTableQueryError()` method.
* Added `Josantonius\Database\Test\CreateTest->testCreateTableMethod()` method.
* Added `Josantonius\Database\Test\CreateTest->testCreateTableMethodError()` method.
* Added `Josantonius\Database\Test\CreateTest->testCreateTableAdvancedMethod()` method.
* Added `Josantonius\Database\Test\CreateTest->testCreateTableAdvancedMethodError()` method.

* Added `Josantonius\Database\Test\InsertTest` class
* Added `Josantonius\Database\Test\InsertTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQuery_Rows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQuery_ID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQuery_Statements_Rows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQuery_Statements_DataType_Rows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQuery_Statements_ID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQuery_Statements_DataType_ID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQueryTableNameError()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertQueryColumnNameError()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Rows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Statements_ID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Statements_DataType_ID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Marks_Statements_ID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Marks_DataType_Rows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethodTableNameError()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethodColumnNameError()` method.

## 1.1.5 - 2017-07-03

* Bug fix in replace method.

## 1.1.4 - 2017-05-16

* Added `Eliasis\Model\Model->_getDatabaseInstance` method.

* Added compatibility with Eliasis Framework library inside getConnection method. If it exists, it will get the connection to the database.

* Will get the connection parameters from Eliasis Framework configuration files. It should have the following structure:

'db' => [

    'identifier' => [
        'id'         => 'identifier',
        'prefix'     => 'identifier_',
        'provider'   => 'PDOprovider',
        'host'       => 'localhost',
        'user'       => 'db_user',
        'name'       => 'db_name',
        'password'   => 'db_password',
        'settings'   => ['charset' => 'utf8'],
    ],
]

* Eliasis Framework url: https://github.com/Eliasis-Framework/Eliasis

## 1.1.3 - 2017-05-14

* Singleton pattern was added to create a single connection per database.

## 1.1.2 - 2017-05-13

* Added option for foreign key in creating tables.

* Added `Josantonius\Database\Database->foreing()` method.
* Added `Josantonius\Database\Database->references()` method.
* Added `Josantonius\Database\Database->on()` method.
* Added `Josantonius\Database\Database->actions()` method.
* Added `Josantonius\Database\Database->engine()` method.
* Added `Josantonius\Database\Database->charset()` method.

* Some bugs were fixed.

## 1.1.1 - 2017-03-18

* Some files were excluded from download and comments and readme files were updated.

## 1.1.0 - 2017-01-30

* Compatible with PHP 5.6 or higher.

## 1.0.0 - 2017-01-30

* Compatible only with PHP 7.0 or higher. In the next versions, the library will be modified to make it compatible with PHP 5.6 or higher.

## 1.0.0 - 2017-01-09

* Added `Josantonius\Database\Database` class.
* Added `Josantonius\Database\Database->__connstruct()` method.
* Added `Josantonius\Database\Database::getConnection()` method.
* Added `Josantonius\Database\Database->query()` method.
* Added `Josantonius\Database\Database->_implement()` method.
* Added `Josantonius\Database\Database->_implementPrepareStatements()` method.
* Added `Josantonius\Database\Database->_implementQuery()` method.
* Added `Josantonius\Database\Database->create()` method.
* Added `Josantonius\Database\Database->select()` method.
* Added `Josantonius\Database\Database->insert()` method.
* Added `Josantonius\Database\Database->update()` method.
* Added `Josantonius\Database\Database->replace()` method.
* Added `Josantonius\Database\Database->delete()` method.
* Added `Josantonius\Database\Database->truncate()` method.
* Added `Josantonius\Database\Database->drop()` method.
* Added `Josantonius\Database\Database->in()` method.
* Added `Josantonius\Database\Database->table()` method.
* Added `Josantonius\Database\Database->from()` method.
* Added `Josantonius\Database\Database->where()` method.
* Added `Josantonius\Database\Database->order()` method.
* Added `Josantonius\Database\Database->limit()` method.
* Added `Josantonius\Database\Database->_reset()` method.
* Added `Josantonius\Database\Database->execute()` method.
* Added `Josantonius\Database\Database->_getResponse()` method.
* Added `Josantonius\Database\Database->_fetchResponse()` method.
* Added `Josantonius\Database\Database->__destruct()` method.

## 1.0.0 - 2017-01-09

* Added `Josantonius\Database\Exception\DatabaseException` class.
* Added `Josantonius\Database\Exception\Exceptions` abstract class.
* Added `Josantonius\Database\Exception\DatabaseException->__construct()` method.

* Added `Josantonius\Provider\Provider` class.
* Added `Josantonius\Provider\Provider->connect()` method.
* Added `Josantonius\Provider\Provider->query()` method.
* Added `Josantonius\Provider\Provider->statements()` method.
* Added `Josantonius\Provider\Provider->create()` method.
* Added `Josantonius\Provider\Provider->select()` method.
* Added `Josantonius\Provider\Provider->insert()` method.
* Added `Josantonius\Provider\Provider->update()` method.
* Added `Josantonius\Provider\Provider->delete()` method.
* Added `Josantonius\Provider\Provider->truncate()` method.
* Added `Josantonius\Provider\Provider->drop()` method.
* Added `Josantonius\Provider\Provider->fetchResponse()` method.
* Added `Josantonius\Provider\Provider->lastInsertId()` method.
* Added `Josantonius\Provider\Provider->rowCount()` method.
* Added `Josantonius\Provider\Provider->getError()` method.
* Added `Josantonius\Provider\Provider->isConnected()` method.
* Added `Josantonius\Provider\Provider->kill()` method.

* Added `Josantonius\Provider\PDOprovider` class.
* Added `Josantonius\Provider\PDOprovider->connect()` method.
* Added `Josantonius\Provider\PDOprovider->query()` method.
* Added `Josantonius\Provider\PDOprovider->statements()` method.
* Added `Josantonius\Provider\PDOprovider->create()` method.
* Added `Josantonius\Provider\PDOprovider->select()` method.
* Added `Josantonius\Provider\PDOprovider->insert()` method.
* Added `Josantonius\Provider\PDOprovider->update()` method.
* Added `Josantonius\Provider\PDOprovider->delete()` method.
* Added `Josantonius\Provider\PDOprovider->truncate()` method.
* Added `Josantonius\Provider\PDOprovider->drop()` method.
* Added `Josantonius\Provider\PDOprovider->fetchResponse()` method.
* Added `Josantonius\Provider\PDOprovider->lastInsertId()` method.
* Added `Josantonius\Provider\PDOprovider->rowCount()` method.
* Added `Josantonius\Provider\PDOprovider->getError()` method.
* Added `Josantonius\Provider\PDOprovider->isConnected()` method.
* Added `Josantonius\Provider\PDOprovider->kill()` method.

* Added `Josantonius\Provider\MSSQLprovider` class.
* Added `Josantonius\Provider\MSSQLprovider->connect()` method.
* Added `Josantonius\Provider\MSSQLprovider->query()` method.
* Added `Josantonius\Provider\MSSQLprovider->statements()` method.
* Added `Josantonius\Provider\MSSQLprovider->create()` method.
* Added `Josantonius\Provider\MSSQLprovider->select()` method.
* Added `Josantonius\Provider\MSSQLprovider->insert()` method.
* Added `Josantonius\Provider\MSSQLprovider->update()` method.
* Added `Josantonius\Provider\MSSQLprovider->delete()` method.
* Added `Josantonius\Provider\MSSQLprovider->truncate()` method.
* Added `Josantonius\Provider\MSSQLprovider->drop()` method.
* Added `Josantonius\Provider\MSSQLprovider->fetchResponse()` method.
* Added `Josantonius\Provider\MSSQLprovider->lastInsertId()` method.
* Added `Josantonius\Provider\MSSQLprovider->rowCount()` method.
* Added `Josantonius\Provider\MSSQLprovider->getError()` method.
* Added `Josantonius\Provider\MSSQLprovider->isConnected()` method.
* Added `Josantonius\Provider\MSSQLprovider->kill()` method.

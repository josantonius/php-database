# CHANGELOG

## 1.2.1 - 2022-08-18

* The repository was archived.

* Fixed bug in `insert` and `update` methods of the `PDOprovider` class. Now correctly accepts null and boolean data types when the query is not prepared.

* The `$settings` attribute of the `Josantonius\Database\Database` class has been renamed to `$items`.

* The `$settings` attribute of the `Josantonius\Database\Database` class will now be used as a public attribute and will save an array with the database options passed by the user when connecting.

* Compatibility was added to refer to data types in prepared queries:

* boolean
* integer
* string

* `USE` was added as a valid query type.

## 1.2.0 - 2018-02-25

* Some methods were modified to adapt them to the new version of Eliasis Framework.

## 1.1.9 - 2018-01-06

* The tests were fixed.

* Changes in documentation.

## 1.1.8 - 2017-11-08

* Implemented `PHP Mess Detector` to detect inconsistencies in code styles.

* Implemented `PHP Code Beautifier and Fixer` to fixing errors automatically.

* Implemented `PHP Coding Standards Fixer` to organize PHP code automatically according to PSR standards.

## 1.1.7 - 2017-10-26

* Implemented `PSR-4 autoloader standard` from all library files.

* Implemented `PSR-2 coding standard` from all library PHP files.

* Implemented `PHPCS` to ensure that PHP code complies with `PSR2` code standards.

* Implemented `Codacy` to automates code reviews and monitors code quality over time.

* Implemented `Codecov` to coverage reports.

* Added `Database/phpcs.ruleset.xml` file.

* Deleted `Database/src/bootstrap.php` file.

* Deleted `Database/tests/bootstrap.php` file.

* Deleted `Database/vendor` folder.

* Changed `Josantonius\Database\Test\` namespace to  `Josantonius\Database\` namespace .

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
* Added `Josantonius\Database\Test\ConnectionTest->testCreateTableMethodExtra()` method.
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

* Added `Josantonius\Database\Test\InsertTest` class.
* Added `Josantonius\Database\Test\InsertTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsert_ReturnRows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsert_ReturnID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsert_Statements_ReturnRows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsert_Statements_DataType_ReturnRows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertDuplicateEntryException()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsert_Statements_ReturnID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsert_Statements_DataType_ReturnID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertTableNameErrorException()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertColumnNameErrorException()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_ReturnRows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Statements_ReturnID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Statements_DataType_ReturnID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Marks_Statements_ReturnID()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethod_Marks_DataType_ReturnRows()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethodTableNameErrorException()` method.
* Added `Josantonius\Database\Test\InsertTest->testInsertMethodColumnNameErrorException()` method.

* Added `Josantonius\Database\Test\SelectTest` class.
* Added `Josantonius\Database\Test\SelectTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\SelectTest->testQuery_Multiple_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testQuery_SelectAll_Limit_ReturnArrayNumeric()` method.
* Added `Josantonius\Database\Test\SelectTest->testQuery_Multiple_Where_Order_ReturnArrayAssoc()` method.
* Added `Josantonius\Database\Test\SelectTest->testQuery_Multiple_ReturnRows()` method.
* Added `Josantonius\Database\Test\SelectTest->testQuery_Multiple_Statements_Where_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testQueryTableNamErrorException()` method.
* Added `Josantonius\Database\Test\SelectTest->testQueryColumnNamErrorException()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_SelectAll_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_SelectAll_Numeric()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_SelectAll_ReturnArrayAssoc()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Limit_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Multiple_Where_ReturnArrayAssoc()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Multiple_Where_Order_Limit_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Order_Where_Multiple_Limit_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Statements_Where_Multiple_ReturnObject()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Statements_Where_Advanced_ReturnAssoc()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethodWhenThereAreNoResults()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_MarksStatements_Advanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethod_Marks_DataType_Where_Advanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethodTableNameErrorException()` method.
* Added `Josantonius\Database\Test\SelectTest->testMethodColumnNameErrorException()` method.

* Added `Josantonius\Database\Test\ReplaceTest` class.
* Added `Josantonius\Database\Test\ReplaceTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethod_ReturnRows()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethod_Statements_Advanced_ReturnID()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethod_Statements_DataType_Avanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethod_MarksStatements_WhereAdvance_ReturnRows()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethod_MarksStatements_DataType_Where_ReturnID()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethodTableNameErrorException()` method.
* Added `Josantonius\Database\Test\ReplaceTest->testMethodColumnNameErrorException()` method.

* Added `Josantonius\Database\Test\UpdateTest` class.
* Added `Josantonius\Database\Test\UpdateTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQuery_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQuery_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQuery_Statements_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQuery_Statements_DataType_WhereMultiple()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQuery_MarksStatements_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQuery_MarksStatements_DataType_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQueryTableNameErrorException()` method.
* Added `Josantonius\Database\Test\UpdateTest->testQueryColumnNameErrorException()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_WhereMultiple_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_Statements_WhereAdvanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_Statements_DataType_Advanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_MarksStatements_WhereAdvance_ReturnRows()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethod_MarksStatements_DataType_ReturnZero()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethodTableNameErrorException()` method.
* Added `Josantonius\Database\Test\UpdateTest->testMethodColumnNameErrorException()` method.

* Added `Josantonius\Database\Test\DeleteTest` class.
* Added `Josantonius\Database\Test\DeleteTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQuery_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQuery_Statements_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQuery_Statements_WhereMultiple_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQuery_MarksStatements_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQuery_MarksStatements_Where_DataType_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQueryTableNameErrorException()` method.
* Added `Josantonius\Database\Test\DeleteTest->testQueryColumnNameErrorException()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethod_Where_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethod_Where_ReturnsRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethod_Statements_WhereAdvanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethod_Statements_DataType_WhereAdvanced_Rows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethod_MarksStatements_WhereAdvanced_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethod_MarksStatements_DataType_WhereAdvanced()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethodTableNameErrorException()` method.
* Added `Josantonius\Database\Test\DeleteTest->testMethodColumnNameErrorException()` method.
* Added `Josantonius\Database\Test\DeleteTest->testDeleteAllMethod_ReturnRows()` method.
* Added `Josantonius\Database\Test\DeleteTest->testDeleteAllQuery_ReturnRows()` method.

* Added `Josantonius\Database\Test\TruncateTest` class.
* Added `Josantonius\Database\Test\TruncateTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\TruncateTest->testTruncateTableQuery()` method.
* Added `Josantonius\Database\Test\TruncateTest->testTruncateTableQueryTableNameError()` method.
* Added `Josantonius\Database\Test\TruncateTest->testTruncateTableMethod()` method.
* Added `Josantonius\Database\Test\TruncateTest->testTruncateTableMethodTableNameError()` method.

* Added `Josantonius\Database\Test\DropTest` class.
* Added `Josantonius\Database\Test\DropTest->testGetConnection()` method.
* Added `Josantonius\Database\Test\DropTest->testDropTableQuery()` method.
* Added `Josantonius\Database\Test\DropTest->testDropTableMethod()` method.
* Added `Josantonius\Database\Test\DropTest->testDropTableMethodExtra()` method.

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

* Eliasis Framework url: <https://github.com/Eliasis-Framework/Eliasis>

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

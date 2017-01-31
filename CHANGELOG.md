# CHANGELOG

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

## 1.0.0 - 2017-01-09
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

## 1.0.0 - 2017-01-09
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

## 1.0.0 - 2017-01-09
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

## 1.0.0 - 2017-01-09
* Added `Josantonius\Database\Tests\DatabaseCreateTest` class.
* Added `Josantonius\Database\Tests\DatabaseDeleteTest` class.
* Added `Josantonius\Database\Tests\DatabaseDropTest` class.
* Added `Josantonius\Database\Tests\DatabaseInsertTest` class.
* Added `Josantonius\Database\Tests\DatabaseReplaceTest` class.
* Added `Josantonius\Database\Tests\DatabaseSelectTest` class.
* Added `Josantonius\Database\Tests\DatabaseTruncateTest` class.
* Added `Josantonius\Database\Tests\DatabaseUpdateTest` class.
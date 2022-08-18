# PHP Database library

[![Latest Stable Version](https://poser.pugx.org/josantonius/Database/v/stable)](https://packagist.org/packages/josantonius/Database)
[![License](https://poser.pugx.org/josantonius/Database/license)](LICENSE)

[English version](README.md)

Biblioteca para la administración de bases de datos SQL para ser utilizada por varios proveedores al mismo tiempo.

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Cómo empezar](#cómo-empezar)
- [Get connection](#get-connection)
- [CREATE TABLE](#create-table)
- [SELECT](#select)
- [INSERT INTO](#insert)
- [UPDATE](#update)
- [REPLACE](#replace)
- [DELETE](#delete)
- [TRUNCATE TABLE](#truncate)
- [DROP TABLE](#drop)
- [Tipos de datos soportados para sentencias preparadas](#tipos-de-datos-soportados-para-sentencias-preparadas)
- [Tests](#tests)
- [Patrocinar](#patrocinar)
- [Licencia](#licencia)

---

## Requisitos

Esta clase es soportada por versiones de **PHP 5.6** o superiores y es compatible con versiones de **HHVM 3.0** o superiores.

## Instalación

La mejor forma de instalar esta extensión es a través de [Composer](http://getcomposer.org/download/).

Para instalar **PHP Database library**, simplemente escribe:

    composer require Josantonius/Database

El comando anterior sólo instalará los archivos necesarios, si prefieres **descargar todo el código fuente** puedes utilizar:

    composer require Josantonius/Database --prefer-source

También puedes **clonar el repositorio** completo con Git:

    git clone https://github.com/Josantonius/PHP-Database.git

O **instalarlo manualmente**:

Descargar [Database.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Database.php), [Provider.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/Provider.php), [PDOprovider.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/PDOprovider.php), [MSSQLprovider.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/MSSQLprovider.php) and [DBException.php](https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Exception/DBException.php):

    wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Database.php
    wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/Provider.php
    wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/PDOprovider.php
    wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Provider/MSSQLprovider.php
    wget https://raw.githubusercontent.com/Josantonius/PHP-Database/master/src/Exception/DBException.php

## Get connection

### - Get connection

```php
Database::getConnection($id, $provider, $host, $user, $name, $password, $settings);
```

| Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- |
| $id | ID único. | string | Sí | |
| $provider | Nombre de la clase del proveedor. | string | No | null |
| $host | Host. | string | No | null |
| $user | Usuario. | string | No | null |
| $name | Nombre. | string | No | null |
| $password | Password. | string | No | null |

| Attribute | Key | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| $settings | | Opciones. Una vez realizada la conexión, esta configuración estará disponible en el objeto de conexión a la base de datos: $db->settings. | array | No | null |
| $settings | 'port' | Puerto. | string | No |  |
| $settings | 'charset' | Charset. | string | No | |

**# Return** (object) → objeto con la conexión

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

## Query

### - Procesar la consulta y prepararla para el proveedor

```php
$db->query($query, $statements, $result);
```

| Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- |
| $query | Query. | string | Sí | |
| $statements | Declaraciones preparadas. | array | No | null |
| $result | Resultado de la consulta; 'obj', 'array_num', 'array_assoc', 'rows', 'id'. | string | No | 'obj' |

**# Return** (mixed) → resultado como objeto, array, int...

**# throws** [DBException] → tipo de consulta no válida

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

## CREATE TABLE

### - CREATE TABLE

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

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| | $data | Nombre de columna y configuración para tipos de datos. | array | Sí | |
| table() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| foreing() | | Establecer clave foránea. | method | No | |
| | $id | ID de la columna. | string | Sí | |
| reference() | | Referencia para clave foránea. | method | No | |
| | $table | Nombre de tabla. | array | Sí | |
| on() | | Establecer nombre de tabla. | method | No | |
| | $table | Nombre de tabla. | array | Sí | |
| actions() | | Establecer las acciones cuando se borre o actualice algún campo relacionado con clave foránea. | method | No | |
| | $action | Acción para cuando se borre o actualice algún campo. | array | Sí | |
| engine() | | Establecer tipo de motor para la tabla. | method | No | |
| | $type | Tipo de motor. | string | Sí | |
| charset() | | Establecer charset. | method | No | |
| | $type | Tipo de charset. | string | Sí | |
| execute() | | Ejecutar consulta. | method | Sí | |

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

## SELECT

### - Declaración SELECT

```php
$db->select($columns)
   ->from($table)
   ->where($clauses, $statements)
   ->order($type)
   ->limit($number)
   ->execute($result);
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| | $columns | Nombre/s de columna/s. | mixed | No | '*' |
| from() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| where() | | Cláusulas WHERE. | method | No | |
| | $clauses | Nombre de la columna y valor. | mixed | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| order() | | Órden. | method | No | |
| | $type | Tipo de ordenamiento. | string | Sí | |
| limit() | | Límite. | method | No | |
| | $number | Número. | int | Sí | |
| execute() | | Ejecutar consulta. | method | Sí | |
| | $result | Resultado de la consulta; 'obj', 'array_num', 'array_assoc', 'rows'. | string | No | 'obj' |

**# Return** (mixed) → resultado de la consulta (object, array, int...) o número de filas afectadas

```php
#SELECT all
$db->select()
    ->from('test')
    ->execute('array_num');

#SELECT con todos los parámetros
$db->select(['id', 'name'])
   ->from('test')
   ->where(['id = 4885', 'name = "Joe"'])
   ->order(['id DESC', 'name ASC'])
   ->limit(1)
   ->execute('obj');

#SELECT con declaraciones preparadas
$statements[] = [1, 3008];
$statements[] = [2, 'Manny'];
        
$db->select('name')
   ->from('test')
   ->where('id = ? OR name = ?', $statements)
   ->execute('rows');

#Otra versión de SELECT con declaraciones preparadas
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

## INSERT INTO

### - Declaración INSERT INTO

```php
$db->insert($data, $statements)
   ->in($table)
   ->execute($result);
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| | $data | Nombre de la columna y valor. | array | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| in() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| execute() | | Ejecutar consulta. | method | Sí | |
| | $result | Resultado de la consulta; 'rows', 'id'. | string | No | 'rows' |

**# Return** (int) → número de filas afectadas o ID de la última fila afectada

```php
#INSERT INTO ejemplo básico
$data = [
    "name"  => "Isis",
    "email" => "isis@email.com",
];
        
$db->insert($data)
   ->in('test')
   ->execute();

#INSERT INTO con declaraciones preparadas
$data = [
    "name"  => "?",
    "email" => "?",
];

$statements[] = [1, "Isis"];
$statements[] = [2, "isis@email.com"];

$db->insert($data, $statements)
   ->in('test')
   ->execute('rows');

#Otra versión de INSERT INTO con declaraciones preparadas
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

## UPDATE

### - Declaración UPDATE

```php
$db->update($data, $statements)
   ->in($table)
   ->where($clauses, $statements)
   ->execute();
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| | $data | Nombre de la columna y valor. | array | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| in() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| where() | | Cláusulas WHERE. | method | No | |
| | $clauses | Nombre de la columna y valor. | mixed | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| execute() | | Ejecutar consulta. | method | Sí | |

**# Return** (int) → número de filas afectadas

```php
#UPDATE ejemplo básico
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

#UPDATE con declaraciones preparadas
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

#Otra versión de UPDATE con declaraciones preparadas
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

## REPLACE

### - Reemplazar una línea en una tabla si existe o insertar una nueva línea si no existe

```php
$db->replace($data, $statements)
   ->from($table)
   ->execute($result);
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| | $data | Nombre de la columna y valor. | array | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| from() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| execute() | | Ejecutar consulta. | method | Sí | |
| | $result | Resultado de la consulta; 'rows', 'id'. | string | No | 'rows' |

**# Return** (int) → número de filas afectadas o ID de la última fila afectada

```php
#REPLACE ejemplo básico
$data = [
    'id'    => 3008,
    'name'  => 'Manny',
    'email' => 'manny@email.com',
];

$db->replace($data)
   ->from('test')
   ->execute();

#UPDATE con declaraciones preparadas
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

#Otra versión de UPDATE con declaraciones preparadas
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

## DELETE

### - Declaración DELETE

```php
$db->delete($data, $statements)
   ->from($table)
   ->where($clauses, $statements)
   ->execute();
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| | $data | Nombre de la columna y valor. | array | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| from() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| where() | | Cláusulas WHERE. | method | No | |
| | $clauses | Nombre de la columna y valor. | mixed | Sí | |
| | $statements | Declaraciones preparadas. | array | No | null |
| execute() | | Ejecutar consulta. | method | Sí | |

**# Return** (int) → número de filas afectadas

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

#DELETE con declaraciones preparadas
$clauses = 'id = :id AND name = :name1 OR name = :name2';

$statements[] = [':id', 4885];
$statements[] = [':name1', 'Isis'];
$statements[] = [':name2', 'Manny'];

$db->delete()
   ->from('test')
   ->where($clauses, $statements)
   ->execute();

#Otra versión de DELETE con declaraciones preparadas
$clauses = 'id = :id AND name = :name1 OR name = :name2';

$statements[] = [':id', 4886, 'int'];
$statements[] = [':name1', 'Isis', 'src'];
$statements[] = [':name2', 'Manny', 'src'];

$db->delete()
   ->from('test_table')
   ->where($clauses, $statements)
   ->execute();
```

## TRUNCATE TABLE

### - Declaración TRUNCATE TABLE

```php
$db->truncate()
   ->table($table)
   ->execute();
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| table() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| execute() | | Ejecutar consulta. | method | Sí | |

**# Return** (boolean)

```php
$db->truncate()
   ->table('test')
   ->execute();
```

## DROP TABLE

### - Declaración DROP TABLE

```php
$db->drop()
   ->table($table)
   ->execute();
```

| Método | Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| table() | | Establecer nombre de tabla. | method | Sí | |
| | $table | Nombre de tabla. | string | Sí | |
| execute() | | Ejecutar consulta. | method | Sí | |

**# Return** (boolean)

```php
$db->drop()
   ->table('test')
   ->execute();
```

## Tipos de datos soportados para sentencias preparadas

### Booleano

- bool
- boolean

### Nulo

- null

### Números enteros

- int
- integer

### Cadenas de texto

- str
- string

**Si algún tipo de dato no coincide con los anteriores, será validado como una cadena de texto.**

**Si no se especifica ningún tipo de dato, el tipo de dato no será validado en la consulta preparada.**

## Tests

Para ejecutar las [pruebas](tests) necesitarás [Composer](http://getcomposer.org/download/) y seguir los siguientes pasos:

    git clone https://github.com/Josantonius/PHP-Database.git
    
    cd PHP-Database

    composer install

Ejecutar pruebas unitarias con [PHPUnit](https://phpunit.de/):

    composer phpunit

Ejecutar pruebas de estándares de código [PSR2](http://www.php-fig.org/psr/psr-2/) con [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    composer phpcs

Ejecutar pruebas con [PHP Mess Detector](https://phpmd.org/) para detectar inconsistencias en el estilo de codificación:

    composer phpmd

Ejecutar todas las pruebas anteriores:

    composer tests

## Patrocinar

Si este proyecto te ayuda a reducir el tiempo de desarrollo,
[puedes patrocinarme](https://github.com/josantonius/lang/es-ES/README.md#patrocinar)
para apoyar mi trabajo :blush:

## Licencia

Este repositorio tiene una licencia [MIT License](LICENSE).

Copyright © 2017-2022, [Josantonius](https://github.com/josantonius/lang/es-ES/README.md#contacto)

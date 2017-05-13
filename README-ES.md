# PHP Database library

[![Latest Stable Version](https://poser.pugx.org/josantonius/database/v/stable)](https://packagist.org/packages/josantonius/database) [![Total Downloads](https://poser.pugx.org/josantonius/database/downloads)](https://packagist.org/packages/josantonius/database) [![Latest Unstable Version](https://poser.pugx.org/josantonius/database/v/unstable)](https://packagist.org/packages/josantonius/database) [![License](https://poser.pugx.org/josantonius/database/license)](https://packagist.org/packages/josantonius/database)

[English version](README.md)

Biblioteca para la administración de bases de datos SQL para ser utilizada por varios proveedores al mismo tiempo.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Métodos disponibles](#métodos-disponibles)
- [Uso](#uso)
- [Select](#select)
- [Insert](#insert)
- [Update](#update)
- [Replace](#replace)
- [Delete](#delete)
- [Create](#create)
- [Truncate](#truncate)
- [Drop](#drop)
- [Tests](#tests)
- [Manejador de excepciones](#manejador-de-excepciones)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

### Instalación 

La mejor forma de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Para instalar PHP Database library, simplemente escribe:

    $ composer require Josantonius/Database

El comando anterior sólo instalará los archivos necesarios, si prefieres descargar todo el código fuente (incluyendo tests, directorio vendor, excepciones no utilizadas, documentos...) puedes utilizar:

    $ composer require Josantonius/Database --prefer-source

También puedes clonar el repositorio completo con Git:

    $ git clone https://github.com/Josantonius/PHP-Database.git

### Requisitos

Esta ĺibrería es soportada por versiones de PHP 5.6 o superiores y es compatible con versiones de HHVM 3.0 o superiores.

### Cómo empezar y ejemplos

Para utilizar esta librería, simplemente:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Database\Database;
```
### Métodos disponibles

Métodos disponibles en esta librería:

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
### Uso

Ejemplo de uso para esta librería:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Database\Database;

$db = Database::getConnection('identifier',	  #	Identificador único para la conexión
		                      'PDOprovider',  # Nombre del proveedor
		                      'localhost',	  # Nombre del servidor de la base de datos
		                      'db-user',	  # Nombre de usuario de la base de datos
		                      'db-name',	  # Nombre de la base de datos
		                      'password',	  # Contraseña de la base de datos
		                      array('charset' => 'utf8'));
```
### Select

Seleccionar en la base de datos.

```php
$db->select()->from()->where()->order()->limit()->execute();
```

**select**($columns)

$columns → (array|string|empty) Nombres de las columnas a seleccionar. Vacío para seleccionar todo (*).

**from**($table)

$table → (string) Nombre de la tabla.

**where**($clauses, $statements) (Opcional) 

$clauses    → (array|string)     → Parámetros para filtrado.

$statements → (array) (Opcional) → Declaraciones preparadas.

**order**($params) (Opcional)

$params → (array|string) → Parámetros de ordenación para la consulta.

**limit**($number) (Opcional) 

$number → (int) → Limitar el número de filas para la respuesta a la consulta.

**execute**($dataType) 

$dataType → (string|empty) → Parámetros aceptados: 'obj', 'array_num', 'array_assoc' & 'rows'.

Ejemplo de consulta **SELECT**. Para más ejemplos ver la clase [DatabaseSelectTest](tests/DatabaseSelectTest.php).

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

Insertar en la base de datos.

```php
$db->insert()->in()->execute();
```

**insert**($data, $statements)

$data       → (array)            → Nombre de columnas y valores a insertar.

$statements → (array) (Opcional) → Declaraciones preparadas.

**in**($table)

$table → (string) Nombre de la tabla.

**execute**($dataType)

$dataType → (string|empty) → Parámetros aceptados: 'rows' & 'id'.

Ejemplo de consulta **INSERT**. Para más ejemplos ver la clase [DatabaseInsertTest](tests/DatabaseInsertTest.php).

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

Actualizar en base de datos.

```php
$db->update()->in()->where()->execute();
```

**update**($data, $statements)

$data       → (array)            → Nombre de columnas y valores a actualizar.

$statements → (array) (Opcional) → Declaraciones preparadas.

**where**($clauses, $statements) (Opcional)

$clauses    → (array|string)     → Parámetros para filtrado.

$statements → (array) (Opcional) → Declaraciones preparadas.

**execute**($dataType)

$dataType → (string|empty) → Parámetros aceptados: 'rows' & 'id'.

Ejemplo de consulta **UPDATE**. Para más ejemplos ver la clase [DatabaseUpdateTest](tests/DatabaseUpdateTest.php).

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

Reemplazar si existe o insertar una nueva fila si no existe.

```php
$db->replace()->from()->execute();
```

**replace**($data, $statements)

$data       → (array)            → Nombre de columnas y valores a insertar o reemplazar.

$statements → (array) (Opcional) → Declaraciones preparadas.

**from**($table)

$table → (string) Nombre de la tabla.

**execute**($dataType)

$dataType → (string|empty) → Parámetros aceptados: 'rows' & 'id'.

Ejemplo de **REPLACE**. Para más ejemplos ver la clase [DatabaseReplaceTest](tests/DatabaseReplaceTest.php).

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

Eliminar campos en base de datos.

```php
$db->delete()->from()->where()->execute();
```

**delete()**

Este método no tiene atributos.

**from**($table)

$table → (string) Nombre de la tabla.

**where**($clauses, $statements) (Opcional)

$clauses    → (array|string)     → Parámetros para filtrado.

$statements → (array) (Opcional) → Declaraciones preparadas.

**execute**($dataType)

$dataType → (string|empty) → Parámetros aceptados: 'rows' & 'id'.

Ejemplo de consulta **DELETE**. Para más ejemplos ver la clase [DatabaseDeleteTest](tests/DatabaseDeleteTest.php).

```php
$query = $db->delete()
            ->from('test')
            ->where('id = 1');

$result = $query->execute();
```

### Create

Crear tabla en base de datos.

```php
$db->create()->table()->execute();
```

**create**($params)

$params → (array) → Parámetros de configuración para las columnas.

**table**($table)

$table → (string) Nombre de la tabla.

**execute()**

Este método no tiene atributos.

Ejemplo de consulta **CREATE**. Para más ejemplos ver la clase [DatabaseCreateTest](tests/DatabaseCreateTest.php).

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

Truncate tabla en base de datos.

```php
$db->truncate()->table()->execute();
```

**truncate()**

Este método no tiene atributos.

**table**($table)

$table → (string) Nombre de la tabla.

**execute()**

Este método no tiene atributos.

Ejemplo de consulta **TRUNCATE**. Para más ejemplos ver la clase [DatabaseTruncateTest](tests/DatabaseTruncateTest.php).

```php
$query = $db->truncate()
            ->table('test');

$result = $query->execute();
```

### Drop

Eliminar tabla en base de datos.

```php
$db->drop()->table()->execute();
```

**drop()**

Este método no tiene atributos.

**table**($table)

$table → (string) Nombre de la tabla.

**execute()**

Este método no tiene atributos.

Ejemplo de consulta **DROP**. Para más ejemplos ver la clase [DatabaseDropTest](tests/DatabaseDropTest.php).

```php
$query = $db->drop()
            ->table('test');

$result = $query->execute();
```

### Tests 

Para utilizar la clase de [pruebas](tests), simplemente:

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

Algunos métodos de prueba de los disponibles en esta librería:

```php
DatabaseCreateTest::testCreateTableMethod();
DatabaseDropTest::testDropTableMethod();
DatabaseTruncateTest::testTruncateTableMethod();
DatabaseSelectTest::testSelectMethod();
DatabaseInsertTest::testInsertMethod();
DatabaseDeleteTest::testDeleteMethod();
DatabaseReplaceTest::testReplaceMethod();
```

### Manejador de excepciones

Esta librería utiliza [control de excepciones](src/Exception) que puedes personalizar a tu gusto.
### Contribuir
1. Comprobar si hay incidencias abiertas o abrir una nueva para iniciar una discusión en torno a un fallo o función.
1. Bifurca la rama del repositorio en GitHub para iniciar la operación de ajuste.
1. Escribe una o más pruebas para la nueva característica o expón el error.
1. Haz cambios en el código para implementar la característica o reparar el fallo.
1. Envía pull request para fusionar los cambios y que sean publicados.

Esto está pensado para proyectos grandes y de larga duración.

### Repositorio

Los archivos de este repositorio se crearon y subieron automáticamente con [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).
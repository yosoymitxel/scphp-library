# Librería de funciones útiles PHP - scPHP

Librería con funciones varias para PHP que nace a fin de simplicar ciertas tareas del lenguaje o versatilizar funciones ya existentes en este por medio de la parametrización y la evasión de excepciones.

## Grupos de funcionalidades

Este se divide en distintas finalidades de funciones usando como prefijo para toda la libería siempre primero `ScPHP::` seguido de la abreviatura del grupo de funcionalidades `dev`,`str`,`dom`, etc.

#### Ejemplos:
```
sc_dev_var_dump('prueba')
```
Donde `sc_` es el prefijo de la librería y `dev_` indica que será del grupo development.
```
sc_str_contiene('Hola mundo', 'Hola');
```
Donde `sc_` es el prefijo de la librería y `str_` indica que será del grupo de manejo strings.

### 1) DEV
Aquí encontramos funciones para hacer testeos rápidos siguiendo la filosofía "echo a todo lo que se mueva" asímismo poner información solo visible desde el DOM, etc.

#### Ejemplos:

```
ScPHP::dev_echo('Título', 'Valor') // <p id='' class='' style='' name=''>Título: Valor</p>

ScPHP::dev_var_dump([1,2]); // Imprime con una etiqueta <pre> un var_dump

ScPHP::dev_activar_depurar_global(true); // Activa o desactiva el modo debug de php

ScPHP::dev_echo_oculto('Esto solo lo veremos desde el HTML del sitio', true, 'id-para-ubicar-en-el-dom') // Imprime un var dump oculto dentro del DOM
```

### 2) DOM
Se utiliza para creación de elementos HTML

#### Ejemplos:
```
ScPHP::dom_crear_elemento();
```

### 3) URL
Es informativo así como sirve para manejo de urls.

#### Ejemplos:
```
ScPHP::url_informacion_sitio_actual()
```

### 4) SQL
Manejo de sql (actualmente requiere una variable $pdoLibreria en un escope anterior para obtenerlo como global $pdoLibreria)

#### Ejemplos:
```
ScPHP::sql_lookup('SELECT * FROM usuario');
```

### 5) STR
Sirve para el manejo de strings desde expresiones regulares, cambios de casos (lower, upper, etc.), quitar espacios en blanco, saber si comieza o termina con alguna expresion, etc.

#### Ejemplos:
```
ScPHP::str_reemplazar_expresion_regular('Hola mundo 123', '\d+',' '); //Hola mundo 

ScPHP::str_quitar_espacios_blancos('Hola mundo,   esto es una      prueba'); //Holamundo,estoesunaprueba

ScPHP::str_sin_caracteres_especiales('Eso está ahí'); //Eso esta ahi

ScPHP::str_contiene('Hola mundo', 'Hola'); // true

ScPHP::str_extraer_expresion_regular('1 - Hola mundo 2','\d'); // [1,2]

ScPHP::str_incluye_expresion_regular('Hola mundo', '\d') // false
```

### 6) JS
Opciones típicas de JS

#### Ejemplos

```
ScPHP::js_alert('texto')
```
### 7) IS
Saber que tipo de dato es

#### Ejemplos

```
ScPHP::is_array(array('valor'))
```

### 8) ARR
Manejo de array.

#### Ejemplos

```
ScPHP::arr_incluye_expresion_regular(array('prueba'),'\w+')
```
### 9) FEC
Manejo de fechas.

#### Ejemplos

```
ScPHP::fec_formatear('2021-12-12 02:20:00','Y-m-d')
```

## Instalación 
#### Al descargarla para añadir se incluye con un require

```
require_once '/scPHP.php'
```

## Ejecutando las pruebas

Puedes escribir `ScPHP::var_dump('prueba')` o `ScPHP::dev_var_dump('prueba')` para saber si esta fue instalada correctamente

## Construido con 

* PHP - Lenguaje de programación

## Licencia 

Este proyecto está bajo la Licencia (MIT) 


---
Con ❤️ por [yosoymitxel](https://github.com/yosoymitxel)


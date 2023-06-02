<?php

    require __DIR__.'/vendor/autoload.php';
    use ScPHPLibrary\ScPHP;
    
    ini_set('display_errors',true);
    ini_set('display_startup_errors',true);
    error_reporting(E_ALL);

    $variable = 'Hoañelt0\'4 wi44tla, mundo!';
    
    $sc = new ScPHP();
    //$sc->dev_activar_depurar_global(true);

    ScPHP::dev_var_dump('prueba');
    ScPHP::dev_var_dump(ScPHP::str_contiene('Hola mundo', 'Hola'));

    ScPHP::dev_echo('Título', 'Valor'); // <p id='' class='' style='' name=''>Título: Valor</p>
    ScPHP::dev_echo_oculto('Esto solo lo veremos desde el HTML del sitio', true, 'id-para-ubicar-en-el-dom'); // Imprime un var dump oculto dentro del DOM

    //ScPHP::dev_var_dump(ScPHP::url_informacion_sitio_actual());

    ScPHP::dev_var_dump(ScPHP::str_reemplazar_expresion_regular('Hola mundo 123', '\d+',' ')); //Hola mundo 
    ScPHP::dev_var_dump(ScPHP::str_quitar_espacios_blancos('Hola mundo,   esto es una      prueba')); //Holamundo,estoesunaprueba
    ScPHP::dev_var_dump(ScPHP::str_sin_caracteres_especiales('Eso está ahí')); //Eso esta ahi
    ScPHP::dev_var_dump(ScPHP::str_contiene('Hola mundo', 'Hola')); // true
    ScPHP::dev_var_dump(ScPHP::str_extraer_expresion_regular('1 - Hola mundo 2','\d')); // [1,2]
    ScPHP::dev_var_dump(ScPHP::str_incluye_expresion_regular('Hola mundo', '\d')); // false
?>

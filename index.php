<?php

    require __DIR__.'/vendor/autoload.php';
    use ScPHPLibrary\ScPHP;

    $variable = 'Hola, mundo!';
    $sc = new ScPHP();
    $sc->dev_var_dump($variable);

?>

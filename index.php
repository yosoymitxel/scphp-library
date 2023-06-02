<?php

    require __DIR__.'/vendor/autoload.php';
    use ScPHPLibrary\ScPHP;



    $variable = 'Hoañelt0\'4 wi44tla, mundo!';
    $sc = new ScPHP();
    $sc->dev_activar_depurar_global(true);

    echo $sc->url_str_a_url_amigable($variable);

?>


<?php

function ler($class) {


    $class = str_replace("\\", DS, $class);

    //print "<pre>" . ROOT . $class . "</pre>";
//se o ficheiro não existe dentro  APP_PATH a pasta [seta o arquivo dentro de config/config.php]
    if (file_exists(ROOT . $class . ".php")) {
        require ROOT . $class . ".php";
    } else {
        exit('O arquivo ' . ROOT.$class . '.php não existe no servidor.');
    }
}

spl_autoload_register("ler");
?>


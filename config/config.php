<?php


/*
 * arquivo de configuração da aplicação
 */
//error_reporting(E_ALL);
//ini_set("display_errors", 0);

define("URL", "http://relatorioH.com/");

//define a pasta layout com a pagina padrão de layout
define("DEFAULT_LAYOUT", "default");
//define a empresa
define("COMPANY", "ZAP");
//define o grupo onde serão cadastrados todos os usuarios

//define o tempo de  sessão activa que o usuario tera
define("SESSION_TIME", "50");
//define o directorio padrão da aplicação
define("DS", DIRECTORY_SEPARATOR);
//define o caminho Root da aplicação
define("ROOT", realpath(dirname(__DIR__)) . DS);
//define o caminho da pasta aplicação
define("HASH_KEY", "peixede234luanda1298");
define("APP_PATH",  "application" . DS);
//define  nome do arquivo onde se encontra o arquivo de erro
define("DEFAULT_ERRO", "errorController");
define("DEFAULT_CONTROLLER", "index");




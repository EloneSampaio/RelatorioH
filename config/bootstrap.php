<?php

// bootstrap.php
//vamos configurar a chamada ao Entity Manager, o mais importante do Doctrine
// o Autoload é responsável por carregar as classes sem necessidade de incluí-las previamente
//require_once "/var/www/html/noc/vendor/autoload.php";
// o Doctrine utiliza namespaces em sua estrutura, por isto estes uses
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

//
$root = "/home/sam/Dropbox/relatorioH/";
////onde irão ficar as entidades do projeto? Defina o caminho aqui
$entidades = array($root . "models/");
//
$isDevMode = true;
//
////// configurações de conexão. Coloque aqui os seus dados
//$dbParams = array(
//    'driver' => 'pdo_mysql',
//    'user' => 'root',
//    'password' => 'elone',
//    'dbname' => 'ZAP',
//);
////
//////setando as configurações definidas anteriormente
$config = Setup::createAnnotationMetadataConfiguration($entidades, $isDevMode, NULL, NULL, FALSE);
//////criando o Entity Manager com base nas configurações de dev e banco de dados
////$entityManager = EntityManager::create($dbParams, $config);
//


$applicationMode = "desenvolvimento";


if ($applicationMode == "desenvolvimento") {
    $cache = new \Doctrine\Common\Cache\ArrayCache;
} else {
    $cache = new \Doctrine\Common\Cache\ApcCache;
}

$config = new Configuration();
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver($root . '/' . 'models/');
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir($root . '/' . 'proxies/');
$config->setProxyNamespace('proxies');

if ($applicationMode == "desenvolvimento") {
    $config->setAutoGenerateProxyClasses(true);
} else {
    $config->setAutoGenerateProxyClasses(false);
}
$config = Setup::createAnnotationMetadataConfiguration($entidades, $isDevMode, NULL, NULL, FALSE);



$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'elone',
    'dbname' => 'ZAP',
);

$em = EntityManager::create($dbParams, $config);

?>
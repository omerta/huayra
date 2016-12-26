<?php
// bootstrap.php
session_start();

//require_once "../vendor/autoload.php";
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
#require_once "doctrine/orm/lib/doctrine/orm/tools/Setup.php";
use Doctrine\ORM\EntityManager;

$paths = array("../entidades/");
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_pgsql',
    'host'     => $_SESSION["ls_hostname"],
    'user'     => $_SESSION["ls_login"],
    'password' => $_SESSION["ls_password"],
    'dbname'   => $_SESSION["ls_database"],
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

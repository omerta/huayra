<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("entidades/");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_pgsql',
    'user'     => 'USER',
    'password' => '',
    'dbname'   => 'DATABASE',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

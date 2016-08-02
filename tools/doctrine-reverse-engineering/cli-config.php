<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
//$entityManager = GetEntityManager();
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

# descomentar para importar una tabla determinada
//$conn = $entityManager->getConnection();
//$conn->getConfiguration()->setFilterSchemaAssetsExpression("~^(saf_tipoestructura$)~");
//$conn->getConfiguration()->setFilterSchemaAssetsExpression("~^(sigesp_empresa$)~");

return ConsoleRunner::createHelperSet($entityManager);

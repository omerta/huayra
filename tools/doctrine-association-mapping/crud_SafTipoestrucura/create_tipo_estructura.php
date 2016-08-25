<?php
// create_tipo_estructura.php
require_once "../bootstrap.php";
require_once "../entidades/SafTipoestructura.php";
require_once "../entidades/SigespEmpresa.php";

$codemp = $argv[1];
$newDenominacion = $argv[2];

$sigespEmpresa = $entityManager->find('SigespEmpresa', $codemp);

$tipoEstructura = new SafTipoestructura();
$tipoEstructura->SetCodemp($sigespEmpresa);
$tipoEstructura->SetDentipest($newDenominacion);

$entityManager->persist($tipoEstructura);
$entityManager->flush();

echo sprintf("Created %s %s %s\n", $tipoEstructura->getCodemp(),
  $tipoEstructura->getCodtipest(),
  $tipoEstructura->getDentipest()
);

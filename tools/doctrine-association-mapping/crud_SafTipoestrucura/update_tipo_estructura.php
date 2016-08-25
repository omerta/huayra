<?php
// update_tipo_estructura.php <id> <new-name>
require_once "../bootstrap.php";
require_once "../entidades/SafTipoestructura.php";
require_once "../entidades/SigespEmpresa.php";

$codtipest = $argv[1];
$newDenominacion = $argv[2];

$tipoEstructura = $entityManager->find('SafTipoestructura', $codtipest);

if ($tipoEstructura === null) {
    echo "Product $id does not exist.\n";
    exit(1);
}

$tipoEstructura->SetDentipest($newDenominacion);

$entityManager->flush();

echo sprintf("Updated %s %s %s\n", $tipoEstructura->getCodemp(),
  $tipoEstructura->getCodtipest(),
  $tipoEstructura->getDentipest()
);

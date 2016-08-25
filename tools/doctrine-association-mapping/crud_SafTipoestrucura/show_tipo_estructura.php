<?php
// show_tipo_estructura.php <id>
require_once "../bootstrap.php";
require_once "../entidades/SafTipoestructura.php";
require_once "../entidades/SigespEmpresa.php";

$codemp = $argv[1];
$tipoEstructura = $entityManager->find('SafTipoEstructura', $codemp);

if ($tipoEstructura === null) {
    echo "No structure found.\n";
    exit(1);
}

echo sprintf("Created %s %s %s\n", $tipoEstructura->getCodemp(),
  $tipoEstructura->getCodtipest(),
  $tipoEstructura->getDentipest()
);

<?php
// list_tipo_estructura.php
require_once "../bootstrap.php";
require_once "../entidades/SafTipoestructura.php";
require_once "../entidades/SigespEmpresa.php";

$productRepository = $entityManager->getRepository('SafTipoEstructura');
$tipoEstrucuras = $productRepository->findAll();

foreach ($tipoEstrucuras as $tipoEstructura) {
    echo sprintf("-%s %s\n", $tipoEstructura->getCodtipest(),$tipoEstructura->getDentipest());
}

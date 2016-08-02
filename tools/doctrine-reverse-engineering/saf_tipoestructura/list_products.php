<?php
// list_products.php
require_once "bootstrap.php";
require_once "entidades/SafTipoestructura.php";
require_once "entidades/SigespEmpresa.php";

$productRepository = $entityManager->getRepository('SafTipoestructura');
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getDentipest());
}

<?php
// create_product.php
require_once "bootstrap.php";
require_once "entidades/SafTipoestructura.php";
//require_once "entidades/SigespEmpresa.php";

$newcodemp = $argv[1];
$newProductName = $argv[2];
$newProductDescription = $argv[3];

$product = new SafTipoestructura();
$product->setCodemp($newcodemp);
$product->setCodtipest($newProductName);
$product->setDentipest($newProductDescription);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getCodtipest() . "\n";

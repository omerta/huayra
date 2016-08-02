<?php
// create_product.php
require_once "bootstrap.php";
require_once "entidades/Product.php";

$newProductName = $argv[1];
$newProductDescription = $argv[2];

$product = new Product();
$product->setName($newProductName);
$product->setDescription($newProductDescription);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . "\n";

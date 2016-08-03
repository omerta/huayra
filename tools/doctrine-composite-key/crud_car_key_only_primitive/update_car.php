<?php
// update_product.php <id> <new-name>
require_once "bootstrap.php";
require_once "entidades/Car.php";

$name = $argv[1];
$year = $argv[2];
$newName = $argv[3];

$product = $entityManager->find('Car', array("name" => $name, "year" => $year));

if ($product === null) {
    echo "Car $name does not exist.\n";
    exit(1);
}

$product->setName($newName);

$entityManager->flush();

<?php
// show_product.php <id>
require_once "bootstrap.php";
require_once "entidades/Car.php";

//$year = $argv[1];

$car = $entityManager->find('Car', array("name" => "Audi A8", "year" => 2010));

if ($car === null) {
    echo "No car found.\n";
    exit(1);
}

echo sprintf("-%s %s\n", $car->getYearOfProduction(), $car->getModelName());

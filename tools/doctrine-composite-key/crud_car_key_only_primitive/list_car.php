<?php
// list_products.php
require_once "bootstrap.php";
require_once "entidades/Car.php";

$carRepository = $entityManager->getRepository('Car');
$cars = $carRepository->findAll();

foreach ($cars as $car) {
    echo sprintf("-%s %s\n", $car->getYearOfProduction(), $car->getModelName());
}

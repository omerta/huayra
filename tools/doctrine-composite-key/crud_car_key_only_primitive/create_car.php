<?php
// create_product.php

/**
 * CREATE TABLE Car (name VARCHAR(255) NOT NULL, year INT NOT NULL, PRIMARY KEY(name, year));
 *
 *                 Tabla «public.car»
 *  Columna |          Tipo          | Modificadores 
 * ---------+------------------------+---------------
 *  name    | character varying(255) | not null
 *  year    | integer                | not null
 * Índices:
 *     "car_pkey" PRIMARY KEY, btree (name, year)
 */

require_once "bootstrap.php";
require_once "entidades/Car.php";

$model = $argv[1];
$year = $argv[2];

$car = new Car($model, $year);

$entityManager->persist($car);
$entityManager->flush();

echo "Created Car with ID " . $car->getModelName() . "\n";

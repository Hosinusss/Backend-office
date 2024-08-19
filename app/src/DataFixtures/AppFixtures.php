<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
public function load(ObjectManager $manager): void
{
// Create new suppliers
$supplier1 = new Supplier();
$supplier1->setName('Supplier 1');
$manager->persist($supplier1);

$supplier2 = new Supplier();
$supplier2->setName('Supplier 2');
$manager->persist($supplier2);

// Add more suppliers as needed
// $supplier3 = new Supplier();
// $supplier3->setName('Supplier 3');
// $manager->persist($supplier3);

// Flush the changes to the database
$manager->flush();
}
}

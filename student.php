<?php
  include "Dynamicmigration.php";
class Student {
    private int $id;
    private string $name;
    private string $gender;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
}

class Product {
    private int $id;
    private string $name;
    private string $price;
    private string $thumbial;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$migration = new DynamicMigration();
$migration->up('Student'); 
$migration->up('Product');


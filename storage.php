<?php
session_start();
include 'classes/dbh.classes.php';
try {
  $username = "root";
  $password = "";
  $pdo = new PDO('mysql:host=127.0.0.1;port=3307;dbname=hardware_store;charset=utf8mb4', $username, $password);
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE type="Storage" LIMIT 1');
$stmt->execute();
$disk = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categoryTitle = 'Storage';
$categoryProducts = $disk;
include __DIR__ . '/includes/category-products.php';

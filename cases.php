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

$stmt = $pdo->prepare('SELECT * FROM products WHERE type="Case" LIMIT 1');
$stmt->execute();
$case = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categoryTitle = 'Cases';
$categoryProducts = $case;
include __DIR__ . '/includes/category-products.php';

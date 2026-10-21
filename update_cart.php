<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $productId = $_POST['id'];
  $quantity = $_POST['quantity'];

   
  $username = "root";
  $password = "";
  $db = new PDO('mysql:host=127.0.0.1;port=3307;dbname=hardware_store;charset=utf8mb4', $username, $password);

   
  $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
  $stmt->execute(['id' => $productId]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product) {
    if (isset($_SESSION['cart'][$productId])) {
      $_SESSION['cart'][$productId]['quantity'] = $quantity;
      $totalPrice = 0;
      foreach ($_SESSION['cart'] as $product) {
        $totalPrice += $product['price'] * $product['quantity'];
      }
      echo json_encode(array(
        'message' => 'Product quantity updated.',
        'cart' => $_SESSION['cart'],
        'totalPrice' => $totalPrice
      ));
    } else {
      echo json_encode(array(
        'message' => 'Product is not in the cart.'
      ));
    }
  } else {
    echo json_encode(array(
      'message' => 'Product not found.'
    ));
  }
}
?>


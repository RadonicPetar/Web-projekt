<?php
session_start();

$username = "root";
$password = "";
$db = new PDO('mysql:host=127.0.0.1;port=3307;dbname=hardware_store;charset=utf8mb4', $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $productId = $_POST['id'];
  $quantity = $_POST['quantity'];

  $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
  $stmt->execute(['id' => $productId]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product) {
    $_SESSION['cart'][$productId] = [
      'id' => $product['id'],
      'title' => $product['title'],
      'price' => $product['price'],
      'quantity' => $quantity
    ];
    echo "Product added to cart.";
  } else {
    echo "Product not found.";
  }
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $productId => $product) {
    $total = $product['price'] * $product['quantity'];
  }
  echo "</table>";
} else {
  echo "Your cart is empty.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
  $productId = $_POST['id'];
  $quantity = $_POST['quantity'];
  if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] = $quantity;
    echo "Product quantity updated.";
  } else {
    echo "Product is not in the cart.";
  }
}

if (isset($_GET['remove'])) {
  $productId = $_GET['remove'];
  if (isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
    echo "Product removed from cart.";
  } else {
    echo "Product is not in the cart.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Hardware Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css" class="">
  <script src="https://kit.fontawesome.com/d7256736fd.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>
  <div class="header">

    <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFA500;">
      <div class="container">
        <a class="navbar-brand" href="home.php"><img src="Ref/PCLogo.png" width="90px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav me-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img src="ref/graphics-card-icon.png" width="40px" height="40px"></a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="processors.php">Processors</a></li>
                <li><a class="dropdown-item" href="VideoCards.php">Video Cards</a></li>
                <li><a class="dropdown-item" href="motherboards.php">Motherboards</a></li>
                <li><a class="dropdown-item" href="cases.php">Cases</a></li>
                <li><a class="dropdown-item" href="power-supplies.php">Power Supplies</a></li>
                <li><a class="dropdown-item" href="RAM.php">RAM</a></li>
                <li><a class="dropdown-item" href="storage.php">Storage</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signUp.php"><img src="ref/sighup.png" width="40px" height="40px"></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><img src="Ref/cart.png" width="40px" height="40px"></a>
            </li>
            <li class="nav nav-item"></li>

          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="text" placeholder="Search">
            <button class="btn btn-primary" type="button" style="background-color: #454545;">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </div>

  <section class="pt-5 pb-5">
    <div class="container">
      <div class="row w-100">
        <div class="col-lg-12 col-md-12 col-12">
          <h3 class="display-5 mb-2 text-center">Shopping Cart</h3>
          <p class="mb-5 text-center">
            <i class="text-info font-weight-bold"><?php
                                                  $totalItems = 0;
                                                  foreach ($_SESSION['cart'] as $item) {
                                                    $totalItems += $item['quantity'];
                                                  }
                                                  ?><?= $totalItems ?></i> items in your cart
          </p>
          <table id="shoppingCart" class="table table-condensed table-responsive">
            <thead>
              <tr>
                <th style="width:60%">Product</th>
                <th style="width:12%">Price</th>
                <th style="width:10%">Quantity</th>
                <th style="width:16%"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION['cart'] as $productId => $product) : ?>
                <tr>
                  <td data-th="Product">
                    <div class="row">
                    <?php
                    $stmt = $db->prepare("SELECT img FROM products WHERE id = :id");
                    $stmt->execute(['id' => $productId]);
                    $productImage = $stmt->fetchColumn();
                    $product['img'] = $productImage;
                    ?>
                    <div class="col-md-3 text-left">
                      <img src="Ref/<?= isset($product['img']) ? $product['img'] : '' ?>" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow">
                    </div>
                      <div class="col-md-9 text-left mt-sm-2">
                        <h4><?= $product['title'] ?></h4>
                        <p class="font-weight-light">Brand &amp; Name</p>
                      </div>
                    </div>
                  </td>
                  <td data-th="Price"><?= $product['price'] ?></td>
                  <td data-th="Quantity">
                    <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1" class="quantity-input">
                    <button class="update-button" data-id="<?= $productId ?>">Update</button>

                    <script>
                    $(document).ready(function() {
                      $(".update-button").click(function() {
                        var productId = $(this).data('id');
                        var quantity = $(this).siblings(".quantity-input").val();

                        $.ajax({
                          type: "POST",
                          url: "update_cart.php",
                          data: {
                            id: productId,
                            quantity: quantity
                          },
                          success: function(response) {
                            var data = JSON.parse(response);
                            alert(data.message);  

                             
                            var totalPrice = 0;
                            for (var key in data.cart) {
                              if (data.cart.hasOwnProperty(key)) {
                                var product = data.cart[key];
                                totalPrice += parseFloat(product.price) * parseInt(product.quantity);
                              }
                            }
                            $("#subtotal-amount").text(totalPrice.toFixed(2) + " $");
                          }
                        });
                      });
                    });
                  </script>
                  </td>
                  <td class="actions" data-th="">
                    <div class="text-right">
                      <a href="cart.php?remove=<?= $productId ?>">Remove</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div id="subtotal" class="float-right text-right">
          <?php
          $totalPrice = 0;
          foreach ($_SESSION['cart'] as $product) {
            $totalPrice += $product['price'] * $product['quantity'];
          }
          echo "<h1>Subtotal: <span id=\"subtotal-amount\">{$totalPrice} $</span></h1>";
          ?>
          </div>
        </div>
      </div>
      <div class="row mt-4 d-flex align-items-center">
        <div class="col-sm-6 order-md-2 text-right">
          <a href="home.php" class="btn btn-primary mb-4 btn-lg pl-5 pr-5">Checkout</a>
        </div>
        <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
          <a href="home.php">
            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
        </div>
      </div>
    </div>
  </section>



  <footer class="text-center text-lg-start bg-white text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <div class="me-5 d-none d-lg-block">
        <span>Get connected with us on social networks:</span>
      </div>

      <div>
        <a href="https://www.facebook.com/" class="me-4 link-secondary">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com/Babananba1" class="me-4 link-secondary">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.google.com/" class="me-4 link-secondary">
          <i class="fab fa-google"></i>
        </a>
        <a href="https://www.instagram.com/peetekaboo/" class="me-4 link-secondary">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com/" class="me-4 link-secondary">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="https://github.com/Babananba" class="me-4 link-secondary">
          <i class="fab fa-github"></i>
        </a>
      </div>
    </section>

    <section class="">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">
              <i class="fas fa-gem me-3 text-secondary"></i>Hardware Store
            </h6>
            <p>
              The best money can buy.
            </p>
          </div>

          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">
              About our store
            </h6>
            <p>
              <a href="" class="text-reset">Offices</a>
            </p>
            <p>
              <a href="" class="text-reset">Contacts and information</a>
            </p>
            <p>
              <a href="" class="text-reset">Who are we?</a>
            </p>
            <p>
              <a href="" class="text-reset">Work and career</a>
            </p>
          </div>

          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">
              CUSTOMER SERVICE
            </h6>
            <p>
              <a href="#!" class="text-reset">Help Center</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Track an Order</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Return Policy</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Help</a>
            </p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-home me-3 text-secondary"></i> Osijek, Croatia</p>
            <p>
              <i class="fas fa-envelope me-3 text-secondary"></i>
              petar.radonic1912@gmail.com
            </p>
            <p><i class="fas fa-phone me-3 text-secondary"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print me-3 text-secondary"></i> + 01 234 567 89</p>
          </div>
        </div>
      </div>
    </section>
  </footer>

</body>

</html>




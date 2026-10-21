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

$stmt = $pdo->prepare('SELECT * FROM products ORDER BY price DESC LIMIT 3');
$stmt->execute();
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['id'])) {
  $productId = $_POST['id'];
  $quantity = $_POST['quantity'];

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
  $stmt->execute(['id' => $productId]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$productId])) {
      $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$productId] = array(
        'id' => $product['id'],
        'title' => $product['title'],
        'price' => $product['price'],
        'quantity' => $quantity
      );
    }
    echo "Product added to cart.";
  } else {
    echo "Product not found.";
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
  <script>
  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault(); 
      var form = $(this);
      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function(response) {
          var message = $('<div class="alert alert-success">Product added to cart.</div>'); 
          $('#message').html(message); 
          setTimeout(function() {
            message.remove(); 
          }, 1000);
        }
      });
    });
    
    $('.btn.btn-primary').click(function() {
      var message = $('<div class="alert alert-success">Product added to cart.</div>'); 
      $('#message').html(message); 
      setTimeout(function() {
        message.remove(); 
      }, 1000);
    });
  });
</script>

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
              <a class="nav-link" href="signUp.html"><img src="ref/sighup.png" width="40px" height="40px"></a>
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


    <div class="container">
      <div class="row">
        <div class="col-2">
          <h1>Introducing! the AMD Radeon™ RX 7900 XT</h1>
          <h3>The Most Advanced Graphics for Gamers & Creators.</h3>
        </div>
        <div class="col-2">
          <img src="Ref/Rx7900xt.png">
        </div>
      </div>
    </div>
  </div>

  <br>
  <br>
  <br>

  <div class="container">
    <h3>Featured products</h3>
    <div class="row g-3">
      <?php foreach ($featuredProducts as $product) : ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card">
            <a href="product.php?page=product&id=<?= $product['id'] ?>">
              <img src="Ref/<?= $product['img'] ?>" alt="ph" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title"><?= $product['title'] ?></h5>
            </a>
            <p class="card-text"><?= $product['price'] ?>$</p>
            <form method="POST" action="home.php">
              <input type="hidden" name="id" value="<?= $product['id'] ?>">
              <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" class="form-control" value="1">
              </div>
              <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
            </form>
          </div>
        </div>
    </div>
  <?php endforeach; ?>
  <div id="message"></div>
</div>
</div>
  <br>
  <br>
  <br>
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

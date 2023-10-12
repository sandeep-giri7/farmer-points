<?php
// Include the configuration file
include('config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page
  header("Location: login.php");
  exit; // Stop further execution of the code
}

// Check if the buy button is clicked for a specific product
if (isset($_POST['buy'])) {
  // Process the buy button click
  $productId = $_POST['productId'];
  $quantity = $_POST['quantity'];

  // Fetch the selected product from the database
  $query = "SELECT * FROM products WHERE id = $productId";
  $result = mysqli_query($conn, $query);

  // Check if the product is found
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $productName = $row['name'];
    $productPrice = $row['price'];
    $productQuantity = $row['quantity'];
    $userId = $_SESSION['user_id'];
    $totalPrice = $productPrice * $quantity;

    // Check if the requested quantity is available in stock
    if ($quantity <= $productQuantity) {
      // Update the product quantity in the database
      $newQuantity = $productQuantity - $quantity;
      $updateQuery = "UPDATE products SET quantity = $newQuantity WHERE id = $productId";
      mysqli_query($conn, $updateQuery);

      // Insert the order into the finalorder table
      $insertQuery = "INSERT INTO finalorder (user_id, product_id, quantity, total_price) VALUES ($userId, $productId, $quantity, $totalPrice)";
      mysqli_query($conn, $insertQuery);

      echo "<p>Order placed successfully! Total price: $totalPrice</p>";
    } else {
      echo "<p>Requested quantity exceeds available stock.</p>";
    }
  } else {
    echo "<p>Product not found.</p>";
  }
} elseif (isset($_POST['addtocart'])) {
  // Process the addtocart button click
  $productId = $_POST['productId'];
  $quantity = $_POST['quantity'];

  // Fetch the selected product from the database
  $query = "SELECT * FROM products WHERE id = $productId";
  $result = mysqli_query($conn, $query);

  // Check if the product is found
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $productName = $row['name'];
    $productPrice = $row['price'];
    $productQuantity = $row['quantity'];
    $userId = $_SESSION['user_id'];
    $totalPrice = $productPrice * $quantity;

    // Check if the requested quantity is available in stock
    if ($quantity <= $productQuantity) {
      // Insert the order into the cart table
      $insertQuery = "INSERT INTO cart (user_id, product_id, quantity, total_price) VALUES ($userId, $productId, $quantity, $totalPrice)";
      mysqli_query($conn, $insertQuery);

      echo "<p>Product added to cart successfully! Total price: $totalPrice</p>";
    } else {
      // echo "<p>Requested quantity exceeds available stock.</p>";
      '<script>
            alert("Requested quantity exceeds available stock.")
            </script>';
    }
  } else {
    echo "<p>Product not found.</p>";
  }
}

// Retrieve all meat products from the database
$query = "SELECT * FROM products WHERE category = 'Fruit'";
$result = mysqli_query($conn, $query);

// Check if any meat products are found
if (mysqli_num_rows($result) > 0) {
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
<link rel="stylesheet" href="customer.css">
  </head>
  <body>
  <?php include('header.php')?>
  <div class="look-for">
        <p>Here are the <span class="fruit">Fruit </span>Products</p>
  </div>
      <div class="cat-box">
        <a href="vegetables.php">
        <div class="cat-box-item" data-category="Vegetable">
          <div class="svg">
            <img src="images/carrot-svgrepo-com.svg" alt="">
          </div>
          <div class="cat-title">
            <p>Vegetable</p>
          </div>
        </div>
        </a>
        <a href="fruits.php">
        <div class="cat-box-item" data-category="Fruits">
          <div class="svg">
            <img src="images/fruit-food-apple-svgrepo-com.svg" alt="">
          </div>
          <div class="cat-title">
            <p>Fruits</p>
          </div>
        </div>
</a>
<a href="meat.php">
        <div class="cat-box-item" data-category="Meat">
          <div class="cat-img">
            <img src="images/meat-on-the-bone-2-svgrepo-com.svg" alt="">
          </div>
          <div class="cat-title">
            <p>Meat</p>
          </div>
        </div>
</a>
      </div>
    <h1 class='item'>Fruit Products</h1>
    
    <div class="products">
      <?php
      while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['id'];
        $productName = $row['name'];
        $productPrice = $row['price'];
        $productImage = 'admin/uploads/' . $row['image'];
        $productQuantity = $row['quantity'];
        ?>
        <div class="product">
          <div class="product-img">
            <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
          </div>
          <div class="product-title">
            <?php echo $productName; ?>
          </div>
          <div class="product-price">Price:
            <?php echo $productPrice; ?>
          </div>
          <div class="product-quantity">Available Quantity:
            <?php echo $productQuantity; ?>
          </div>

          <form method="POST">
            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
            <input type="number" name="quantity" min="1" value="1">
            <div class="options-btn">
              <button type="submit" name="buy" value="buy">Order Now</button>
              <button type="submit" name="addtocart" value="addtocart">Add to Cart</button>
            </div>
          </form>
        </div>
        <?php
      }
      ?>
    </div>
  </body>
  </html>
  <?php
} else {
  echo "No Fruit products found.";
}

// Close the database connection
mysqli_close($conn);
?>

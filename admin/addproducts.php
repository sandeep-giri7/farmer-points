<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
</head>
<body>
  <?php
  // Include the configuration file
  include '../config.php';

  // Check if the admin is logged in
  session_start();
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT isAdmin FROM users WHERE id = $userId";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if ($row['isAdmin']) {
        // Admin is logged in, show the add product form
        ?>

        <h2>Add Product</h2>

        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Retrieve form data
          $name = $_POST['name'];
          $quantity = $_POST['quantity'];
          $price = $_POST['price'];
          $image = $_POST['image'];
          $category = $_POST['category'];

          // Prepare and execute the SQL query
          $query = "INSERT INTO products (name, quantity, price, image, category) VALUES ('$name', '$quantity', '$price', '$image', '$category')";

          if (mysqli_query($conn, $query)) {
            echo "Product added successfully!";
          } else {
            echo "Error adding product: " . mysqli_error($conn);
          }
        }

        // Product form
        ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" required><br><br>

          <label for="quantity">Quantity:</label>
          <input type="number" name="quantity" id="quantity" required><br><br>

          <label for="price">Price:</label>
          <input type="number" name="price" id="price" required><br><br>

          <label for="image">Image:</label>
          <input type="file" name="image" id="image"><br><br>

          <label for="category">Category:</label>
          <select name="category" id="category" required>
            <option value="Fruit">Fruit</option>
            <option value="Vegetable">Vegetable</option>
            <option value="Meat">Meat</option>
            <option value="Dry Fruits">Dry Fruits</option>
            <option value="Seeds">Seeds</option> <!-- Fixed duplicate value -->
          </select><br><br>

          <input type="submit" value="Add Product">
        </form>

        <?php
      } else {
        echo "You are not authorized to access this page.";
      }
    } else {
      echo "Error retrieving user information.";
    }
  } else {
    header("Location: login.php");
  }
  ?>
   <a href="logout.php">Logout</a>
</body>
</html>

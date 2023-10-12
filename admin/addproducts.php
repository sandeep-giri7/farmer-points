<?php
// Include the configuration file
include '../config.php';

// Check if the admin is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ../login.php");
    exit; // Stop further execution of the code
  }

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $sql = "SELECT isAdmin FROM users WHERE id = $userId";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if ($row['isAdmin']) {
      // Admin is logged in, show the add product form

      // Define variables and set to empty values
      $nameErr = $quantityErr = $priceErr = "";
      $name = $quantity = $price = $image = $category = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate name
        if (empty($_POST["name"])) {
          $nameErr = "Name is required";
        } else {
          $name = $_POST["name"];
        }

        // Validate quantity
        if (empty($_POST["quantity"])) {
          $quantityErr = "Quantity is required";
        } elseif ($_POST["quantity"] < 1) {
          $quantityErr = "Quantity must be at least 1";
        } else {
          $quantity = $_POST["quantity"];
        }

        // Validate price
        if (empty($_POST["price"])) {
          $priceErr = "Price is required";
        } elseif ($_POST["price"] < 1) {
          $priceErr = "Price must be at least 1";
        } else {
          $price = $_POST["price"];
        }

        // Retrieve other form data
        $category = $_POST["category"];

        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image or a fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
          $uploadOk = 1;
        } else {
          $uploadOk = 0;
        }

        // Check if the file already exists
        if (file_exists($target_file)) {
          $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
          $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
          $uploadOk = 0;
        }

        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        } else {
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imageName = basename($_FILES["image"]["name"]);
            $query = "INSERT INTO products (name, quantity, price, image, category) VALUES ('$name', '$quantity', '$price', '$imageName', '$category')";

            if (mysqli_query($conn, $query)) {
              echo "Product added successfully!";
            } else {
              echo "Error adding product: " . mysqli_error($conn);
            }
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
      }
      ?>

      <!DOCTYPE html>
      <html>

      <head>
        <title>Add Product</title>
        <style>
          form {
            margin-top: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
            align-items: center;
          }

          .form-box-container {
            display: flex;
            justify-content: center;
          }

          label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            align-items: center;
            margin-top: 16px;
          }

          input[type="text"],
          input[type="number"],
          select {
            width: 200px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
          }

          input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 16px;
          }

          input[type="submit"]:hover {
            background-color: #45a049;
          }

          .error {
            color: red;
            margin-top: 5px;
          }


          .hom {
            margin-top: 16px;
            font-size: 14px;
            font-weight: bold;
            color: darkolivegreen;
          }
        </style>
      </head>

      <body>
        <div class="form-box-container">
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
          <h2>Add Product</h2>
            <div>
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" required>
              <span class="error">
                <?php echo $nameErr; ?>
              </span>
            </div>

            <div>
              <label for="quantity">Quantity:</label>
              <input type="number" name="quantity" id="quantity" required>
              <span class="error">
                <?php echo $quantityErr; ?>
              </span>
            </div>

            <div>
              <label for="price">Price:</label>
              <input type="number" name="price" id="price" required>
              <span class="error">
                <?php echo $priceErr; ?>
              </span>
            </div>

            <div>
              <label for="image">Image:</label>
              <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required>
            </div>

            <div>
              <label for="category">Category:</label>
              <select name="category" id="category" required>
                <option value="Fruit">Fruit</option>
                <option value="Vegetable">Vegetable</option>
                <option value="Meat">Meat</option>
              </select>
            </div>

            <div>
              <input type="submit" name="upload" value="Add Product">
            </div>
            <div class="hom">
              Go to Admin Dashboard <a input type="submit" value="Home" href="admin.php"> Home</a>
            </div>
          </form>
        </div>
      </body>

      </html>

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

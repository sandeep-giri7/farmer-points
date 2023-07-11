<?php
// Include the configuration file
include('config.php');
session_start();
echo '<a href="index.php">Home</a>';

// Check if the user is not logged in
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
            echo "<p>Requested quantity exceeds available stock.</p>";
        }
    } else {
        echo "<p>Product not found.</p>";
    }
}

// Fetch all products from the database
$query = "SELECT p.*, COALESCE(SUM(c.quantity), 0) AS total_quantity 
          FROM products p
          LEFT JOIN finalorder f ON p.id = f.product_id
          LEFT JOIN cart c ON p.id = c.product_id
          GROUP BY p.id";
$result = mysqli_query($conn, $query);

// Check if any products are found

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['id'];
        $productName = $row['name'];
        $productPrice = $row['price'];
        $productImage = 'images/' . $row['image']; // Add 'images/' prefix to the image path
        $totalQuantity = $row['quantity'];
     ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Products</title>
        <style>
            .product-container {
                display: flex;
                margin-bottom: 20px;
            }

            .product-image {
                width: 200px;
                height: 200px;
                object-fit: cover;
                margin-right: 20px;
            }

            form {
                display: flex;
                align-items: center;
            }

            input[type=number] {
                width: 50px;
                margin-right: 10px;
            }

            input[type=submit] {
                padding: 5px 10px;
                border: none;

            }

            input[type=submit]:hover {
                cursor: pointer;
            }

            .error {
                color: red;
            }
        </style>
    </head>

    <body>

        <div class="product-container">
            <img class="product-image" src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
            <div>
                <p><strong>
                        <?php echo $productName; ?>
                    </strong></p>
                <p>Price:
                    <?php echo $productPrice; ?>
                </p>
                <p>Total Quantity:
                    <?php echo $totalQuantity; ?>
                </p>

                <!-- Quantity field and buy button -->
                <form method="POST" action="">
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                    <input type="number" name="quantity" min="1" value="1">
                    <div class="register-clear-button">
                        <button type="submit" name="buy" value="buy">BUY</button>
                        <button type="submit" name="addtocart" value="addtocart">ADD TO CART</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
        
    <?php
    }
} else {
    echo "No products found.";
}

// Close the database connection
mysqli_close($conn);
?>
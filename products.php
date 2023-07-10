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
echo '<style>
.product-container {
    display: flex;
    align-items: center;
    margin-bottom: 20px; /* Add space between products */
}

.product-image {
    width: 150px; /* Set the desired width of the image */
    height: auto; /* Maintain the aspect ratio */
    margin-right: 20px; /* Add space between image and details */
}
</style>
';


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['id'];
        $productName = $row['name'];
        $productPrice = $row['price'];
        $productImage = 'images/' . $row['image']; // Add 'images/' prefix to the image path
        $totalQuantity = $row['quantity'];

        // Display product details
        echo "<div class='product-container'>";
        echo "<img class='product-image' src='$productImage' alt='$productName'>";
        echo "<div>";
        echo "<p><strong>$productName</strong></p>";
        echo "<p>Price: $productPrice</p>";
        echo "<p>Total Quantity: $totalQuantity</p>";

        // Quantity field and buy button
        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='productId' value='$productId'>";
        echo "<input type='number' name='quantity' min='1' value='1'>";
        echo "<input type='submit' name='buy' value='Buy'>";
        echo "<input type='submit' name='addtocart' value='Add to cart'>";
        echo "</form>";

        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No products found.";
}

// Close the database connection
mysqli_close($conn);
?>


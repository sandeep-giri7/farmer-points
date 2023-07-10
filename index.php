<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require_once 'config.php';

// Retrieve the name of the logged-in user from the database
$userId = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE id = '$userId'";
$result = $conn->query($sql);
$userName = '';

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $userName = $row['name'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <p>Welcome, <?php echo $userName; ?>!</p>
    <a href="products.php">Check/buy Product</a><br>
    <a href="cart.php">my cart</a><br>
    <a href="finalorders.php">My Orders</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>

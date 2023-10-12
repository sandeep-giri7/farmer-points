<?php
// Include the configuration file
include('config.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT COUNT(*) FROM cart WHERE user_id = $userId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        echo $row[0]; // Output the cart item count
    } else {
        echo 0; // No items in the cart
    }
} else {
    echo 0; // User not logged in, so no items in the cart
}
?>

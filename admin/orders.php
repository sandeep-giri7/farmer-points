<?php
include('../config.php');

// Check if the admin is logged in
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if the user is an admin
    $isAdminQuery = $conn->query("SELECT isAdmin FROM users WHERE id = $userId");
    $row = $isAdminQuery->fetch_assoc();
    $isAdmin = $row['isAdmin'];
    
    if ($isAdmin) {
        // Retrieve all orders (final orders)
        $ordersQuery = $conn->query("SELECT finalorder.id, users.name AS user_name, products.name AS product_name, finalorder.quantity, finalorder.total_price
                                    FROM finalorder
                                    INNER JOIN users ON finalorder.user_id = users.id
                                    INNER JOIN products ON finalorder.product_id = products.id");
    
        // Display the orders (carts)
        if ($ordersQuery->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Order ID</th><th>User</th><th>Product</th><th>Quantity</th><th>Total Price</th><th>Action</th></tr>";
            while ($order = $ordersQuery->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$order['id']}</td>";
                echo "<td>{$order['user_name']}</td>";
                echo "<td>{$order['product_name']}</td>";
                echo "<td>{$order['quantity']}</td>";
                echo "<td>{$order['total_price']}</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='order_id' value='{$order['id']}' />";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No orders found.";
        }

        // Handle the deletion when the form is submitted
        if (isset($_POST['delete'])) {
            $orderId = $_POST['order_id'];
            $deleteQuery = $conn->query("DELETE FROM cart WHERE id = $orderId");

            if ($deleteQuery) {
                echo "Order deleted successfully.";
                // Refresh the page to reflect the updated order list
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                // echo "Error deleting order: " . $conn->error;
            }
        }
    } else {
        echo "You are not authorized to access this page.";
    }
} else {
    echo "Please log in as an admin.";
}

// Close the database connection
$conn->close();
?>

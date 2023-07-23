<?php
include '../config.php';

// Fetch all orders from the finalorder table with customer and product details
$sql = "SELECT finalorder.id, users.name AS customer_name, products.name AS product_name, finalorder.quantity, finalorder.total_price
        FROM finalorder
        INNER JOIN users ON finalorder.user_id = users.id
        INNER JOIN products ON finalorder.product_id = products.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
</head>
<body>
    <h1>Orders</h1>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["customer_name"] . "</td>";
                echo "<td>" . $row["product_name"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["total_price"] . "</td>";
                echo "<td>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='order_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' name='confirm' value='Confirm'>";
                echo "<input type='submit' name='reject' value='Reject'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No orders found</td></tr>";
        }
        ?>
    </table>

    <?php
    // Process the confirmation or rejection of an order
    if (isset($_POST['confirm']) || isset($_POST['reject'])) {
        $order_id = $_POST['order_id'];

        if (isset($_POST['confirm'])) {
            // Remove order from finalorder table
            $remove_sql = "DELETE FROM finalorder WHERE id = $order_id";
            $conn->query($remove_sql);

            // Send confirmation message to the user
            $message = "Your order with ID $order_id has been confirmed.";
   
            // send_message_to_user($message);
        } elseif (isset($_POST['reject'])) {
            // Remove order from finalorder table
            $remove_sql = "DELETE FROM finalorder WHERE id = $order_id";
            $conn->query($remove_sql);

            // Send rejection message to the user
            $message = "Your order with ID $order_id has been rejected.";
           
            // send_message_to_user($message);
        }

        // Redirect to the same page to avoid form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

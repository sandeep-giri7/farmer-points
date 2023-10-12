<?php
include '../config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: /login.php");
    exit; // Stop further execution of the code
}

// Function to send an email
function send_email($to, $subject, $message) {
    $headers = "khadkasushil555@gmail.com"; // Replace with your email address
    return mail($to, $subject, $message, $headers);
}

// Fetch all orders from the finalorder table with customer and product details
$sql = "SELECT finalorder.id, users.name AS customer_name, products.name AS product_name, finalorder.quantity, finalorder.total_price, users.email
        FROM finalorder
        INNER JOIN users ON finalorder.user_id = users.id
        INNER JOIN products ON finalorder.product_id = products.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<h1>Orders</h1>

<table id="ordersTable">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
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
                echo "<input type='hidden' name='customer_email' value='" . $row["email"] . "'>";
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
    </tbody>
</table>

<?php
// Process the confirmation or rejection of an order
if (isset($_POST['confirm']) || isset($_POST['reject'])) {
    $order_id = $_POST['order_id'];
    $customer_email = $_POST['customer_email'];

    if (isset($_POST['confirm'])) {
        // Remove order from finalorder table
        $remove_sql = "DELETE FROM finalorder WHERE id = $order_id";
        $conn->query($remove_sql);

        // Send confirmation message to the user
        $message = "Your order with ID $order_id has been confirmed.";
        send_email($customer_email, "Order Confirmation", $message);
    } elseif (isset($_POST['reject'])) {
        // Remove order from finalorder table
        $remove_sql = "DELETE FROM finalorder WHERE id = $order_id";
        $conn->query($remove_sql);

        // Send rejection message to the user
        $message = "Your order with ID $order_id has been rejected.";
        send_email($customer_email, "Order Rejection", $message);
    }

    // Redirect to the same page to avoid form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
}

// Close the database connection
$conn->close();
?>

<script>
    $(document).ready(function () {
        $('#ordersTable').DataTable();
    });
</script>
</body>
</html>

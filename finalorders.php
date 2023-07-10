<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT finalorder.id, products.name, products.price, finalorder.quantity, finalorder.total_price
        FROM finalorder
        INNER JOIN products ON finalorder.product_id = products.id
        WHERE finalorder.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmed Orders</title>
    <a href="logout.php">Logout</a><br>
    <a href="index.php">Home Page</a>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>Confirmed Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
      
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $order_id = $row["id"];
                $product_name = $row["name"];
                $price = $row["price"];
                $quantity = $row["quantity"];
                $total_price = $row["total_price"];
                ?>
                <tr>
                    <td><?php echo $order_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $total_price; ?></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='5'>No confirmed orders found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

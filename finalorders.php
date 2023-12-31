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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        a {
            color: darkgoldenrod;
            text-decoration: underline;
            margin-right: 10px;
            font-size: 14px;
            font-weight:lighter;
        }
        h2 {
            color: green;
            text-align: center;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #75c576;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e2e2e2;
        }
    </style>
</head>
<body>
    <h2>Confirmed Orders</h2>
    <a href="index.php">Home</a>
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


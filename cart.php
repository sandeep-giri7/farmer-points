<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle quantity and price update
    if (isset($_POST['update_quantity'])) {
        $order_id = $_POST['order_id'];
        $new_quantity = $_POST['new_quantity'];
        $new_price = $_POST['new_price'];

        $sql = "UPDATE cart SET quantity = $new_quantity, total_price = $new_price * $new_quantity WHERE id = $order_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: cart.php");
            exit;
        } else {
            echo "Error updating quantity: " . $conn->error;
        }
    }
    // Handle order deletion
    elseif (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        $sql = "DELETE FROM cart WHERE id = $order_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: cart.php");
            exit;
        } else {
            echo "Error deleting order: " . $conn->error;
        }
    }
    // Handle placing the order
    elseif (isset($_POST['place_order'])) {
        $order_id = $_POST['order_id'];

        // Get the order details from the cart table
        $sql = "SELECT * FROM cart WHERE id = $order_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $total_price = $row['total_price'];

        // Insert the order into the finalorder table
        $sql = "INSERT INTO finalorder (user_id, product_id, quantity, total_price)
                VALUES ($user_id, $product_id, $quantity, $total_price)";
        if ($conn->query($sql) === TRUE) {
            // Delete the order from the cart table
            $sql = "DELETE FROM cart WHERE id = $order_id";
            if ($conn->query($sql) === TRUE) {
                header("Location: cart.php");
                exit;
            } else {
                echo "Error deleting order from cart: " . $conn->error;
            }
        } else {
            echo "Error placing order: " . $conn->error;
        }
    }
}

$sql = "SELECT cart.id, products.name, products.price, cart.quantity, cart.total_price
        FROM cart
        INNER JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders</title>
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
    <h2>Customer Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Edit Quantity</th>
            <th>Delete Order</th>
        </tr>
        <!-- add total button -->
      
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
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <input type="number" name="new_quantity" value="<?php echo $quantity; ?>" required>
                            <input type="hidden" name="new_price" value="<?php echo $price; ?>" required>
                            <input type="submit" name="update_quantity" value="Update">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <input type="submit" name="delete_order" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>No orders found.</td></tr>";
        }
        ?>
          <tr>
            <td colspan="4">Total</td>
            <td>
                <?php
                $sql = "SELECT SUM(total_price) AS total FROM cart WHERE user_id = $user_id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo $row["total"];
                ?>
            </td>
            <!-- add button buy -->
            <td colspan="2">
            <form method="post" action="">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="submit" name="place_order" value="Place Order">
                </form>
    </table>
</body>
</html>

<?php
// Include config file
include '../config.php';

// Check if the product ID parameter is provided and the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    // Prepare a delete statement
    $sql = "DELETE FROM products WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind the product ID parameter as a parameter to the prepared statement
        $stmt->bind_param("i", $_POST['delete_id']);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Product deleted successfully";
            // Product deleted successfully, you can add a success message if needed
        } else {
            // Error occurred while deleting the product
            echo "Error deleting the product.";
        }

        // Close the statement
        $stmt->close();
    }
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<aside>
      <h2>Sidebar</h2>
      <ul>
        <li><a href="addproducts.php">AddProduct</a></li>
        <li><a href="orders.php">CheckOrder</a></li>
        <li><a href="inventory.php">Inventory</a></li>
       </ul>
       <div class="lgot">
        <a href="../logout.php">Logout</a>
      </div>
    </aside>
    
    <h1>Inventory</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Image</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["quantity"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["image"]; ?></td>
                    <td><?php echo $row["category"]; ?></td>
                    <td>
                        <a href="editproduct.php?id=<?php echo $row["id"]; ?>">Edit</a>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>No products found.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
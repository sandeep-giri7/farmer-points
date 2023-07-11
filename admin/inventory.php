<?php
// Include config file
include '../config.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
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
                        <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a>
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

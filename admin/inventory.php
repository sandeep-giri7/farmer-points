<?php
// session 

// Check if the admin is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ../login.php");
    exit; // Stop further execution of the code
}

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
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

    <h1>Inventory</h1>

    <table id="example" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>

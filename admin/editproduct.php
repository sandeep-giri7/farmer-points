<?php
// Include config file
include '../config.php';

// Define variables and initialize with empty values
$name = $quantity = $price = $image = $category = "";
$name_err = $quantity_err = $price_err = $image_err = $category_err = "";

// Processing form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate quantity
    if (empty(trim($_POST["quantity"]))) {
        $quantity_err = "Please enter the quantity.";
    } else {
        $quantity = trim($_POST["quantity"]);
    }

    // Validate price
    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter the price.";
    } else {
        $price = trim($_POST["price"]);
    }

    // Validate category
    if (empty(trim($_POST["category"]))) {
        $category_err = "Please select a category.";
    } else {
        $category = trim($_POST["category"]);
    }

    // Check input errors before updating the product
    if (empty($name_err) && empty($quantity_err) && empty($price_err) && empty($category_err)) {
        // Prepare an update statement
        $sql = "UPDATE products SET name=?, quantity=?, price=?, category=? WHERE id=?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssi", $param_name, $param_quantity, $param_price, $param_category, $param_id);

            // Set parameters
            $param_name = $name;
            $param_quantity = $quantity;
            $param_price = $price;
            $param_category = $category;
            $param_id = $_GET["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to the product list
                header("location: inventory.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
} else {
    // Check if the id parameter is valid
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Prepare a select statement
        $sql = "SELECT * FROM products WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = trim($_GET["id"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    // Fetch the product data
                    $row = $result->fetch_assoc();
                    $name = $row["name"];
                    $quantity = $row["quantity"];
                    $price = $row["price"];
                    $category = $row["category"];
                } else {
                    // Redirect to the error page if the id parameter doesn't exist
                    header("location: inventory.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    } else {
        // Redirect to the error page if the id parameter is missing
        header("location: inventory.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }

        .form-group {
            margin-top: 1rem;
        }

        .form-group span {
            color: red;
        }

        .form-group input[type="text"], .form-group select {
            width: 100%;
            padding: 0.5rem;
        }

        .form-group input[type="submit"] {
            padding: 0.5rem 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Edit Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <span><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($quantity_err)) ? 'has-error' : ''; ?>">
                <label>Quantity</label>
                <input type="text" name="quantity" value="<?php echo $quantity; ?>">
                <span><?php echo $quantity_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Price</label>
                <input type="text" name="price" value="<?php echo $price; ?>">
                <span><?php echo $price_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                <label>Category</label>
                <select name="category">
                    <option value="" <?php echo ($category == "") ? "selected" : ""; ?>>Please select</option>
                    <option value="Fruit" <?php echo ($category == "Fruit") ? "selected" : ""; ?>>Fruit</option>
                    <option value="Vegetable" <?php echo ($category == "Vegetable") ? "selected" : ""; ?>>Vegetable</option>
                    <option value="Meat" <?php echo ($category == "Meat") ? "selected" : ""; ?>>Meat</option>

                </select>
                <span><?php echo $category_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Save Changes">
                <a href="inventory.php" style="margin-left: 1rem;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>

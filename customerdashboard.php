<?php
include 'config.php';

// Assuming you want to retrieve all the records from the 'vegetables' table
$vegetableQuery = "SELECT * FROM vegetables";
$vegetableResult = mysqli_query($conn, $vegetableQuery);

// Assuming you want to retrieve all the records from the 'fruits' table
$fruitQuery = "SELECT * FROM products";
$fruitResult = mysqli_query($conn, $fruitQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Fruits</h2>
        <?php
        if (mysqli_num_rows($fruitResult) > 0) {
            // Loop through each row of fruit data
            while ($row = mysqli_fetch_assoc($fruitResult)) {
                $name = $row['name'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $image = $row['image'];

                // Display the fruit information
                echo "Product Name: " . $name . "<br>";
                echo "Quantity: " . $quantity . "<br>";
                echo "Price: " . $price . "<br>";
                echo "Image: " . $image . "<br>";
                echo "<br>";
            }
        } else {
            echo "No fruits found";
        }
        ?>
    </div>

    <div>
        <h2>Vegetables</h2>
        <?php
        if (mysqli_num_rows($vegetableResult) > 0) {
            // Loop through each row of vegetable data
            while ($row = mysqli_fetch_assoc($vegetableResult)) {
                $name = $row['name'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $image = $row['image'];

                // Display the vegetable information
                echo "Product Name: " . $name . "<br>";
                echo "Quantity: " . $quantity . "<br>";
                echo "Price: " . $price . "<br>";
                echo "Image: " . $image . "<br>";
                echo "<br>";
            }
        } else {
            echo "No vegetables found";
        }
        ?>
    </div>

</body>
</html>

<?php
mysqli_close($conn);
?>
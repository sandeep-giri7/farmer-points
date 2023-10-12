
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer's Point</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to update the cart icon count
        function updateCartCount() {
            $.ajax({
                url: 'get_cart_count.php', // Create a new PHP file for this
                method: 'GET',
                success: function (response) {
                    $('#message').text(response);
                }
            });
        }

        // Call the function on page load
        $(document).ready(function () {
            updateCartCount();
        });
    </script>

    <style>
          body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .top {
            height: 30px;
            /* background-color: #363636; */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15%;
            margin-left: 15%;
        }

        .title {
            font-size: 30px;
            color: green;
            font-weight: bold;
            
        }

        nav {
            background-color: #363636;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            margin-right: 5%;
            margin-left: 5%;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            margin-right: 15%;
            margin-left: 15%;
        }

        li {
            margin-right: 20px;
            font-size: 20px;
        }

        li:last-child {
            margin-right: 0;
        }

        li a {
            color: beige;
            text-decoration: none;
            padding: 5px 10px;
        }

        li img {
            height: 25px;
            filter: invert(100%);
        }
        #message{
            color: red;
        }
    </style>
</head>
<body>
    <header style="position: sticky; top: 0;">
        <div class="top" style="backdrop-filter:blur(10px);">
            <h1 class="title">Farmer's Point</h1>
        </div>
        <nav>
            <ul>
                <li><a href="userdashboard.php">Home</a></li>
                <!-- <li><a href="products.php">Products</a></li> -->
                <li><a href="information/aboutus.php">About</a></li>
                <li><a href="information/contactus.php">Contact</a></li>
            </ul>
            <ul>
                <li><a href="cart.php">
                    <sup id="message"></sup>
                    <img src="images/cart.png" alt=""></li>
    </a>
                <!-- <li><a href="profile.php">
                    <img src="images/profile.png" alt=""></li>
    </a> -->
                <li><a href="logout.php">
                    <img src="images/logout.png" alt=""></li>
    </a>
            </ul>
        </nav>
    </header>

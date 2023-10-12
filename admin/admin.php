<?php
//include config file
include '../config.php';

//session start
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ../login.php");
    exit; // Stop further execution of the code
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
    position: fixed;
    width: 240px;
    height: 100%;
    background: #1e1e1e;
    transition: all 0.5s ease;
}


        .sidebar header {
            font-size: 28px;
            color: white;
            line-height: 70px;
            text-align: center;
            background: #1b1b1b;
            user-select: none;
        }

        .sidebar a {
            display: block;
            height: 65px;
            width: 100%;
            color: white;
            line-height: 65px;
            padding-left: 30px;
            box-sizing: border-box;
            border-bottom: 1px solid black;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        a.active, a:hover {
            background: #262626;
        }

        .content {
    margin-left: 240px;
    padding: 20px;
    /* width: calc(100% - 240px); Calculate the remaining width */
    
}
    </style>
</head>
<body>
<div class="sidebar">
    <header>Admin Dashboard</header>
    <a href="#" onclick="loadPage('addproducts.php')">
        <span>Add Product</span>
    </a>
    <a href="#" onclick="loadPage('inventory.php')">
        <span>Inventory</span>
    </a>
    <a href="#" onclick="loadPage('orders.php')">
        <span>Orders</span>
    </a>
    <a href="#" onclick="logout()">
        <span>Logout</span>
    </a>
</div>

<div class="content" id="content">
    <!-- Content will be loaded here -->
</div>

<script>
    // Load the "Add product" content by default when the page loads
    window.onload = function () {
        loadPage('addproducts.php');
    };

    function loadPage(pageUrl) {
    var contentContainer = document.getElementById("content");
    var sidebar = document.querySelector(".sidebar");

    if (pageUrl === 'inventory.php' || pageUrl === 'orders.php') {
        // Calculate the available height within the sidebar
        var headerHeight = sidebar.querySelector("header").clientHeight;
        var availableHeight = sidebar.clientHeight - headerHeight;

        // Create an iframe element
        var iframe = document.createElement("iframe");
        iframe.src = pageUrl;
        iframe.frameBorder = "0";
        iframe.width = "100%";
        iframe.height = availableHeight + "px";

        // Clear the content container and append the iframe
        contentContainer.innerHTML = '';
        contentContainer.appendChild(iframe);
    } else {
        // Use AJAX to load other pages (e.g., 'addproducts.php')
        var xhr = new XMLHttpRequest();
        xhr.open("GET", pageUrl, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Replace the content of the container with the loaded page's content
                contentContainer.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
}





    function logout() {
        //logout function
        window.location.href = "../logout.php";
    }
</script>
</body>
</html>

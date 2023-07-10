<?php
// Include the config file
require_once '../config.php';

// Check if the user is logged in as an admin
session_start();
// if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != 1) {
//   // Redirect the user to the login page or show an error message
//   header("Location: ../login.php");
//   exit;
// }
// ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1>Header</h1>
    <nav>
      <!-- Include navigation links here -->
    </nav>
  </header>

  <main>
    <aside>
      <h2>Sidebar</h2>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="addproducts.php">AddProduct</a></li>
        <li><a href="manageProducts.php">ManageProduct</a></li>
        <li><a href="orders.php">CheckOrder</a></li>
      </ul>
    </aside>

    <section>
      <h2>Main Content</h2>
      <h3>This is Admin Page</h3>
      <a href="../logout.php">Logout</a>
    </section>
  </main>

  <footer>
    <p>Footer</p>
  </footer>
</body>

</html>
<?php
require_once 'config.php';

// Start a session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
  // Redirect to index.php or any other desired page
  header("Location: landingpage/index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['code'])) {
  $verificationCode = $_GET['code'];

  $sql = "UPDATE users SET verification_status = 1 WHERE verification_code = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $verificationCode);

  if ($stmt->execute()) {
    // Redirect to success page or any other desired page
    header("Location: login.php");
    exit();
  } else {
    echo "Error: ";
  }
}

$conn->close();
?>

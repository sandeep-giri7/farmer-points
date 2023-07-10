<?php
require_once 'config.php';

// Start a session
session_start();

// Check if a session exists and user_id is set
if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    
    if ($row['verification_status'] == 0) {
      // User's email is not verified, redirect to verification instructions page
      header("Location: verification_instructions.html");
      exit();
    }

    $_SESSION['user_id'] = $row['id'];
    if ($row['isAdmin'] == 1) {
      echo "Login successful! You are an admin.";
      header("Location: admin/admin.php");
      // Perform actions for admin users
    } else {
      echo "Login successful! You are a regular user.";
      header("Location: index.php");
      // Perform actions for regular users
    }
    
    exit();
  } else {
    echo "Invalid email or password.";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Login</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }
    h2 {
      text-align: center;
    }
    form {
      width: 30%;
      margin: 0 auto;
    }
    .form-group {
      margin-bottom: 8px;
    }
    label {
      display: block;
    }
    input[type=email], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    input[type=submit] {
      width: 20%;
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      margin-top: 8px;
      border: none;
      cursor: pointer;
    }
    input[type=submit]:hover {
      background-color: #45a049;
    }
    .register-link {
      font-weight: bold;
      color: black; /* Replace with your desired color */
      font-size: 20px; /* Replace with your desired font size */
    }
  </style>
</head>
<body>
  <h2>User Login</h2>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>

    <div>
      <input type="submit" value="Login">
    </div>
    <div>
      <a>you have to register here</a>
      <a href="register.php" class="register-link">Register</a>
    </div>
  </div>
  </form>
</body>
</html>


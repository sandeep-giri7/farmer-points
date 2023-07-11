<?php
require_once 'config.php';

// Start a session
session_start();

// Check if a session exists and user_id is set
if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

$error = ""; // Initialize the error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email=? AND password=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if ($row['verification_status'] == 0) {
      // User's email is not verified, redirect to verification instructions page
      header("Location: verification_instructions.html");
      exit();
    }

    $_SESSION['user_id'] = $row['id'];
    if ($row['isAdmin'] === 1) {
      header("Location: admin/admin.php");
      exit();
    } else {
      header("Location: index.php");
      exit();
    }
  } else {
    $error = "Invalid email or password.";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmers Point - Login</title>
  <link rel="stylesheet" href="style.css">
  <script>
      function togglePassword() {
      var passwordField = document.getElementById('password');
      var passwordToggle = document.getElementById('password-toggle');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordToggle.textContent = 'Hide Password';
      } else {
        passwordField.type = 'password';
        passwordToggle.textContent = 'Show Password';
      }
    }

  </script>
</head>

<body>
  <div class="container">
    <div class="form-box">
      <h1 class="registration-title">Account Login</h1>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div><input type="email" name="email" placeholder="Email" required></div>
        <div><input type="password" name="password" id="password" placeholder="Password" required></div>
        
        <div class="password-toggle-container">
          <input type="checkbox" id="password-toggle" class="password-toggle" onchange="togglePassword()">
          <label for="password-toggle" class="password-toggle-label">Show Password</label>
        </div>

        <br>
        <div><button type="submit">Login</button></div>
        <div class="register-link">
          Don't have an account? <a href="Register.php">Register</a>
        </div>
      </form>
      <?php if ($error): ?>
        <div class="error-message">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>
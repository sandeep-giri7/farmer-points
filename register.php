<?php
require_once 'config.php';

// Start a session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect to index.php or any other desired page
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $password = $_POST['password'];

  // Generate a verification code
  $verificationCode = md5(uniqid(rand(), true));

  $sql = "INSERT INTO users (name, email, phone, address, password, verification_code) VALUES (?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssss", $name, $email, $phone, $address, $password, $verificationCode);

  if ($stmt->execute()) {
    // Email configuration
    $to = $email;
    $subject = "Account Verification";
    $message = "Dear $name,\r\n\r\nPlease click the following link to verify your account:\r\n\r\n";
    $message .= "http://localhost/farmerspoint/emailverification.php?code=$verificationCode\r\n\r\n";
    $message .= "Best regards,\r\nFarmers Point";
    $headers = "From: your-email@example.com\r\n";
    $headers .= "Reply-To: your-email@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the verification email
    mail($to, $subject, $message, $headers);

    // Redirect to the verification instructions page
    header("Location: verification_instructions.html");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
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
    input[type=text], input[type=email], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    input[type=submit] {
      width: 20%;
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
    }
    input[type=submit]:hover {
      background-color: #45a049;
    }
    .login-link {
  font-weight: bold;
  color: black; /* Replace with your desired color */
  font-size: 20px; /* Replace with your desired font size */
}

  </style>
</head>
<body>
  <h2>User Registration</h2>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
    </div>

    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div>
      <label for="phone">Phone:</label>
      <input type="text" id="phone" name="phone" required>
    </div>

    <div>
      <label for="address">Address:</label>
      <input type="text" id="address" name="address" required>
    </div>

    <div>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>

    <div>
      <input type="submit" value="Register">
    </div>
    <div >
      <a>already have an account ? </a>
      <a href="login.php" class="login-link">Login</a>
    </div>
  </form>
</body>
</html>


<?php
include 'config.php';

// // Start session
// session_start();

// // Check if user is already logged in
// if (isset($_SESSION['user_id'])) {
//   header('Location: login.php');
//   exit;
// }

$err = array(); // Initialize error array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['fname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


  // Validation
  if (empty($name)) {
    $err['fname'] = 'Please enter a name';
  }

  if (empty($email)) {
    $err['email'] = 'Please enter an email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err['email'] = 'Enter a valid email';
  }

  if (empty($phone)) {
    $err['phone'] = 'Please enter a phone number';
  } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
    $err['phone'] = 'Phone number must be 10 digits';
  }

  if (empty($address)) {
    $err['address'] = 'Please enter an address';
  }

  if (empty($password)) {
    $err['password'] = 'Please enter a password';
  } elseif (strlen($password) < 8) {
    $err['password'] = 'Password must be at least 8 characters long';
  }

  $confirm_password = $_POST['confirm_password'];
  if (empty($confirm_password)) {
    $err['confirm_password'] = 'Please enter confirm password';
  } elseif (!password_verify($_POST['confirm_password'], $password)) {
    $err['confirm_password'] = 'Passwords do not match';
  }

  // Proceed with email verification if there are no errors
  if (empty($err)) {
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
      echo "Error: " ;
    }
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Form</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>
  <div class="container">

    <div class="form-box register-container">
      <h1 class="registration-title">Registration Form</h1>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

        <?php
        // Display errors
        if (isset($err['fname'])) {
          echo '<span class="error">' . $err['fname'] . '</span>';
        }
        ?>
        <input class="input-field" type="text" name="fname" id="name" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>" placeholder="Enter name">

        <?php
        if (isset($err['email'])) {
          echo '<span class="error">' . $err['email'] . '</span>';
        }
        ?>
        <input class="input-field" type="text" name="email" id="email" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">

        <?php
        if (isset($err['phone'])) {
          echo '<span class="error">' . $err['phone'] . '</span>';
        }
        ?>
        <input class="input-field" type="text" name="phone" id="phone" placeholder="Enter phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">

        <?php
        if (isset($err['address'])) {
          echo '<span class="error">' . $err['address'] . '</span>';
        }
        ?>
        <input class="input-field" type="text" name="address" id="address" placeholder="Enter address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">

        <?php
        if (isset($err['password'])) {
          echo '<span class="error">' . $err['password'] . '</span>';
        }
        ?>
        <input class="input-field" type="password" name="password" id="password" placeholder="Enter password">

        <?php
        if (isset($err['confirm_password'])) {
          echo '<span class="error">' . $err['confirm_password'] . '</span>';
        }
        ?>
        <input class="input-field" type="password" name="confirm_password" id="confirm_password" placeholder="Enter confirm password">

        <div class="register-clear-button">
          <button type="submit" name="btnRegister" value="Register">Register</button>
          <button type="reset" name="btnReset" value="Clear">Clear</button>
        </div>

        <div class="already-account">
          Already have an account? <a href="login.php">Login</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>

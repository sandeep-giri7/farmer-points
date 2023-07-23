<?php 
// Include the config file 
include 'config.php'; 
 
// Check if the user is logged in 
// session_start(); 
// if (!isset($_SESSION['name'])) { 
//   // Redirect the user to the login page or show an error message 
//   header("Location: login.php"); 
//   exit; 
// } 
 
// Retrieve the user's information from the database 
$name = $_SESSION['name']; 
$sql = "SELECT * FROM users WHERE name = '$name'"; 
$result = mysqli_query($conn, $sql); 
if (!$result) { 
    die('Error executing query: ' . mysqli_error($conn)); 
} 
$row = mysqli_fetch_assoc($result); 
 
// Delete the user's profile and associated posts/comments 
if (isset($_POST['delete'])) { 
  $userId = $row['id']; 
  $password = $_POST['password']; 
 
  // Verify the entered password 
  if (password_verify($password, $row['password'])) { 
    // Delete user's posts 
    $sql = "DELETE FROM posts WHERE user_id = '$userId'"; 
    $result = mysqli_query($conn, $sql); 
    if (!$result) { 
      die('Error deleting posts: ' . mysqli_error($conn)); 
    } 
 
    // Delete user's comments 
    $sql = "DELETE FROM post_comments WHERE user_id = '$userId'"; 
    $result = mysqli_query($conn, $sql); 
    if (!$result) { 
      die('Error deleting comments: ' . mysqli_error($conn)); 
    } 
 
    // Delete the user's profile 
    $sql = "DELETE FROM users WHERE id = '$userId'"; 
    $result = mysqli_query($conn, $sql); 
    if (!$result) { 
      die('Error deleting profile: ' . mysqli_error($conn)); 
    } 
 
    // Redirect the user to the login page or show a success message 
    header("Location: ../login.php"); 
    exit; 
  } else { 
    // Incorrect password 
    $error = "Incorrect password. Please try again."; 
  } 
} 
?> 
 
 
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>User Profile</title> 
  <link rel="stylesheet" href="style.css"> 
</head> 
 
<body> 
  <header > 
  <?php include 'header.php'; ?> 
  </header> 
 
  <main>  
 
    <section> 
  <h2>Your Profle</h2> 
  <div class="profile"> 
    <div class="profile-labels"> 
      <label for="name">Name:</label> 
      <label for="username">Username:</label> 
      <label for="email">Email:</label> 
      <label for="phone">Phone:</label> 
      <label for="image">Profile Image:</label> 
    </div> 
    <div class="profile-info"> 
      <span><?php echo $row['name']; ?></span> 
      <span><?php echo $row['username']; ?></span> 
      <span><?php echo $row['email']; ?></span> 
      <span><?php echo $row['phone']; ?></span> 
      <img src="../uploads/<?php echo $row['image_path']; ?>" alt="Profile Image"> 
    </div> 
  </div> 
  <div class="profile-actions"> 
    <a class="edit-profile-link" href="edit_profile.php">Edit Profile</a> 
    <a class="logout-profile-link" href="../logout.php">Logout</a> 
     
  </div> 
</section> 
 
 
  </main> 
</body> 
 
</html> 
<script> 
  function confirmDeleteProfile() { 
    return confirm('Are you sure you want to delete your profile? This action cannot be undone.'); 
  } 
</script>
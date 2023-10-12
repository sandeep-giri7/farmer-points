<?php
session_start();
session_destroy();
header("Location: landingpage/index.php"); // Redirect to the login page after logout
exit;
?>

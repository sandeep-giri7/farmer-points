<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="landing.css">
  <style>
    *{
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }
    body {
      background-image: url("1000_F_145461155_JpkXt8o5Rf08tKXmYtSBqyrCcaDE2LVB.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
      color: white;
      font-family: 'Fira Sans', sans-serif;
      height: 100%;
    }
    nav {
      width: 100%;
      height: 100px;
      display: flex;
      justify-content: space-between;
      padding: 35px 5%;
      align-items: center;
    }
    nav ul{
      display: flex;
      list-style: none;
    }
    nav ul li{
      padding: 10px 15px;
      border-radius: 10px;
      transition: 0.2s ease-in;
      margin-left: 20px;
    }
    nav ul li a{
      color: white;
      font-size: 22px;
      font-weight: bold;
      text-decoration: none;
    }
    nav ul li:hover{
      background-color: green; 
    }

    .row{
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 2% 5%;
    }
    .row .column1 {
      padding-right: 50px;
    }
 
    .column1 p {
      font-size: 50px;
      margin-bottom: 20px;
      margin-top: 30px;
      color: white;
      text-shadow: 2px 2px 4px orangered;
      text-decoration: underline;
      text-decoration-color: wheat;
    }
    .column1 button {
      width: 150px;
      height: 50px;
      border-radius: 20px;
      border-style: none;
      color: darkred;
      font-size: 17px;
      font-weight: 600;
      cursor: pointer;
      margin-left: 200px;
      margin-top: 20px;
      background-color: whitesmoke;
      border: 2px solid white;
      transition: background-color 0.3s ease;
    }

    .column1 button:hover {
      background-color: wheat;
      color: orangered;
    }

    .H {
      font-size: 80px;
    }

    span{
      color: darkgreen;
      font-size: 120px;
      text-shadow: 2px 2px 4px maroon;
    }
    
    /* place footer in bottom of the page */
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color:black;
      color: white;
      text-align: center;
      padding: 1rem 0;
    }
  </style>
  <title>Product Landing Page</title>
</head>
<body>
  <nav>
    <div class="logo"></div>
    <div class="navLinks">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="about.php">About</a></li>

        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </nav>

  <!-- Header content with banner image -->
  <div class="row">
    <div class="column1">
      <h1 class="H"> WELCOME TO <br> <span>FARMER'S POINT</span> </h1>
      <p>A Platform To Connect Farmers And Customers!</p>
      <button><a href="../login.php"> GET STARTED</a></button>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2023 Farmers Point. All rights reserved.</p>
  </footer>
</body>
</html>

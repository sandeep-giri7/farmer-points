<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Landing Page</title>
  <style>
    *{
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }
    body {
      background-color: whitesmoke;
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
      color: white;
      font-family: 'Fira Sans', sans-serif;
      height: 100%;
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
      font-size: 30px;
      margin-bottom: 20px;
      margin-top: 30px;
      color: black;
    }
    h2 {
      color: black;
      font-size: 40px;
      margin-bottom: 20px;
      margin-top: 30px;
      text-align: center;
      text-decoration: underline;
    }
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: black;
      color: white;
      text-align: center;
      padding: 1rem 0;
    }

    </style>
</head>
<body>

  <!-- Main content -->
  <main>
    <div class="row">
      <div class="column1">
        <h2>About Farmers Point</h2>
        <p>Welcome to Farmers Point! We are dedicated to providing fresh, high-quality, and locally sourced produce to our customers. Our farm has been family-owned for generations, and we take pride in growing a wide variety of fruits and vegetables using sustainable farming practices.</p>
        <p>At Farmers Point, we believe in supporting local communities and promoting healthy eating habits. Our team of skilled farmers works diligently to ensure that every product we offer is carefully cultivated and reaches your table at its peak freshness.</p>
        <p>Whether you're a restaurant owner, a grocery store manager, or an individual looking for the freshest produce, Farmers Point has got you covered. We offer a diverse selection of seasonal fruits, vegetables, and herbs to meet your specific needs.</p>
      </div>
    </div>
  </main>

  <footer class="footer">
    <p>&copy; 2023 Farmers Point. All rights reserved.</p>
  </footer>

</body>
</html>

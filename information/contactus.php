<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers Point - Contact</title>
    <style>
        /* Add your custom CSS here */
        body {
            background-color: whitesmoke;
            font-family: 'Fira Sans', sans-serif;
            margin: 0;
            padding: 0;
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
    .contact-section {
            margin-top: 50px;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 10px;
            background-color: #f9f9f9;
            max-width: 600px;
            margin: 50px auto;
 
        }
.contact-section p{
    font-size: 20px;
}
        .form-group {
            margin-bottom: 20px;
            font-size: 20px;
        }

        label {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 100%;
        }

        textarea {
            resize: horizontal;
        }

        button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: green;
        }
        /* place footer at the bottom of the page */
        .footer {
            background-color: black;
            color: white;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- Main content -->
    <main>

        <section class="contact-section">
            <h2>Contact Farmers Point</h2>
            <p>If you have any questions, inquiries, or feedback, please don't hesitate to contact us. We'd love to hear
                from you!</p>
            <form action="submit_form.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2023 Farmers Point. All rights reserved.</p>
    </footer>

</body>

</html>
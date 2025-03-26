<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    require_once('dataconnect.php');

    // Get form data
    $name = mysqli_real_escape_string($conp, $_POST['name']);
    $email = mysqli_real_escape_string($conp, $_POST['email']);
    $message = mysqli_real_escape_string($conp, $_POST['message']);

    // Insert data into database
    $sql = "INSERT INTO contactus (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conp, $sql)) {
        $success = "Thank you for contacting us. We will get back to you shortly.";
    } else {
        $error = "Error: " . $sql . "<br>" . mysqli_error($conp);
    }

    // Close the database connection
    mysqli_close($conp);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #0277bd;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .branch, .Email-Us {
            margin-bottom: 20px;
        }
        .branch h3, .Email-Us p {
            color: #0277bd;
            margin-bottom: 5px;
        }
        .branch p, .Email-Us p {
            font-size: 1rem;
            margin: 5px 0;
        }
        .contact-form {
            margin-top: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .contact-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .contact-form input:focus, .contact-form textarea:focus {
            border-color: #0277bd;
            outline: none;
        }
        .contact-form button {
            display: block;
            width: 100%;
            padding: 10px 20px;
            font-size: 1rem;
            background: #0277bd;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .contact-form button:hover {
            background: #01579b;
        }
        .message {
            font-size: 1rem;
            text-align: center;
            margin-bottom: 20px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
        footer {
            background-color: #444; /* Dark shade */
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }
            h2 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <h2>We are here to help you!</h2>

        <div class="branch">
            <h3>Kandy Hospital</h3>
            <p><strong>Contact:</strong> +94 81 223 6451</p>
            <p><strong>Address:</strong> Kandy Main St, Kandy City</p>
        </div>

        <div class="branch">
            <h3>Colombo Hospital</h3>
            <p><strong>Contact:</strong> +94 11 2645124</p>
            <p><strong>Address:</strong> Colombo City Center, Colombo</p>
        </div>

        <div class="branch">
            <h3>Kurunegala Hospital</h3>
            <p><strong>Contact:</strong> +94 37 333 4541</p>
            <p><strong>Address:</strong> Kurunegala Main Rd, Kurunegala</p>
        </div>

        <div class="Email-Us">
            <p><strong>Email:</strong> contactus@carecompass.com</p>
        </div>

        <div class="contact-form">
            <?php if (isset($success)): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php elseif (isset($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required aria-label="Your Name">

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required aria-label="Your Email">

                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Write your message here" required aria-label="Your Message"></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
<footer>
        <p>&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
    </footer>
</html>

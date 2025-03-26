<?php
//link db connection
require_once('../dataconnect.php');

if(isset($_POST['submit'])){
    $Name=mysqli_real_escape_string($conp,$_POST['name']);
    $Email=mysqli_real_escape_string($conp,$_POST['email']);
    $Feedback=mysqli_real_escape_string($conp,$_POST['feedback']);
  
    $Insert="INSERT INTO feedback(name,email,feedback)
    VALUES ('$Name','$Email','$Feedback')";
    if(mysqli_query($conp,$Insert)){
        echo "<script>alert('Record Added Success!');</script>";
    } else {
        echo "<script>alert('Record Added Not Success!');</script>";
        echo "<script>window.location.href='Registration.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="css/Dashboard.css">
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Header styles */
        header {
            background-color: #333;
            color: #f0f0f0;
            text-align: center;
            padding: 20px 0;
        }

        /* Footer styles */
        footer {
            background-color: #333;
            color: #f0f0f0;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Form container */
        .form-container {
            width: 50%;
            margin: 50px auto;
            background-color: #444;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Form input fields */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #333;
            color: #f0f0f0;
            border: 1px solid #555;
            border-radius: 5px;
        }

        /* Submit button styles */
        button {
            width: 100%;
            padding: 10px;
            background-color: #666;
            color: #f0f0f0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<header>
    <h1>Care Compass Hospitals Feedback</h1>
</header>

<div class="form-container">
    <form action="" method="post">
      
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" id="name" required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" id="email" required></td>
            </tr>
            <tr>
                <td>Feedback</td>
                <td><input type="text" name="feedback" id="feedback" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>
</div>

<footer>
    2024 @ All Rights Reserved
</footer>

</body>
</html>

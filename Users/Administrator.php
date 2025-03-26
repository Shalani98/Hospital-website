<?php
//link db connection
require_once('../dataconnect.php');

$data = "SELECT * FROM feedback";
$rest_list = "";
$result = mysqli_query($conp, $data);
if($result){
    while($result1 = mysqli_fetch_assoc($result)){
        $rest_list .= "<tr>";
        $rest_list .= "<td>{$result1['name']}</td>";
        $rest_list .= "<td>{$result1['email']}</td>";
        $rest_list .= "<td>{$result1['feedback']}</td>";
        $rest_list .= "</tr>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Records</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* General page background */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Light grey background */
            color: #333;  /* Dark text color for readability */
            margin: 0;
            padding: 0;
        }

        /* Header styles */
        header {
            background-color: #ffffff;  /* White background for header */
            padding: 15px;
            text-align: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        header nav {
            font-size: 1.5em;
            color: #333; /* Dark text for contrast */
        }

        /* Table Styles */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff; /* White background for the table */
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Table header styles */
        th {
            background-color: #f2f2f2; /* Light grey for table headers */
            color: #333;
            padding: 12px;
            text-align: left;
        }

        /* Table data styles */
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f2f2f2; /* Light grey border between rows */
        }

        /* Footer styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <nav>Feedback Records</nav>
</header>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Feedback</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $rest_list; ?>
    </tbody>
</table>

<footer>2025 @ All Rights Reserved</footer>

</body>
</html>

<?php
// Include the database connection
require_once('../dataconnect.php');

// Query to fetch all laboratory tests
$sql = "SELECT * FROM laboratory_tests";
$result = mysqli_query($conp, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Laboratory Tests</title>
    <style>
       
        body {
    
            font-family: Arial, sans-serif;
            color: #fff;
        }

      
        .form-container {
            background-color: rgba(138, 105, 105, 0.6); 
            padding: 20px;
            border-radius: 10px;
            width: 70%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Available Laboratory Tests</h1>
        <form action="Bill.php" method="post">
            <table>
                <tr>
                    <th>Select</th>
                    <th>Test Name</th>
                    <th>Description</th>
                    <th>Preparation Guidelines</th>
                    <th>Price</th>
                </tr>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><input type="checkbox" name="tests[]" value="<?= htmlspecialchars($row['test_id']) ?>"></td>
                            <td><?= htmlspecialchars($row['test_name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['preparation_guidelines']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No tests available</td>
                    </tr>
                <?php endif; ?>
            </table>
            <br>
            <input type="submit" value="Proceed to Checkout">
        </form>
    </div>
</body>
</html>

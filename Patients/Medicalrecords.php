<?php
require_once('../dataconnect.php');
session_start();
//  Check if the user is logged in
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$query = "SELECT id, fullname FROM patients";
$result = mysqli_query($conp, $query);

if (!$result) {
    die("Error fetching patients: " . mysqli_error($conp));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        main {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #017d73;
            color: white;
        }

        button {
            background-color: #017d73;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
<main>
    <h2>Patients List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Records</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($patient = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($patient['id']); ?></td>
                    <td><?php echo htmlspecialchars($patient['fullname']); ?></td>
                    <td>
                        <a href="medicalrecordshow.php?id=<?php echo $patient['id']; ?>">
                            <button>View</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
</body>
</html>
<?php
require_once('../dataconnect.php'); // Ensure this file contains the correct database connection details

// Handle search and filter
$filters = ["specialization IS NOT NULL"];

if (!empty($_GET['specialization'])) {
    $specialization = mysqli_real_escape_string($conp, $_GET['specialization']);
    $filters[] = "specialization LIKE '%$specialization%'";
}
if (!empty($_GET['address'])) {
    $address = mysqli_real_escape_string($conp, $_GET['address']);
    $filters[] = "address LIKE '%$address%'";
}
if (!empty($_GET['availability'])) {
    $availability = mysqli_real_escape_string($conp, $_GET['availability']);
    $filters[] = "shift LIKE '%$availability%'";
}
if (!empty($_GET['qualifications'])) {
    $qualifications = mysqli_real_escape_string($conp, $_GET['qualifications']);
    $filters[] = "qualifications LIKE '%$qualifications%'";
}

$searchQuery = implode(" AND ", $filters);

// Fetch doctors from the staff table where specialization is not null
$doctorsQuery = "SELECT staff_id, user_id, first_name, last_name, specialization, department, phone_extension, shift, email, phone_number, address, registration_date, qualifications
                 FROM staff 
                 WHERE $searchQuery";
$doctorsResult = mysqli_query($conp, $doctorsQuery);

if (!$doctorsResult) {
    die("Error fetching doctors: " . mysqli_error($conp));
}

$doctors = [];
while ($row = mysqli_fetch_assoc($doctorsResult)) {
    $doctors[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: none;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #017d73;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form label {
            margin-right: 10px;
        }
        .filter-form input {
            margin-right: 20px;
            padding: 5px;
        }
        .filter-form button {
            padding: 5px 10px;
            background-color: #017d73;
            color: white;
            border: none;
            cursor: pointer;
        }
        .filter-form button:hover {
            background-color: #005e57;
        }
         /* Footer styles */
         footer {
            background-color: #444; /* Dark shade */
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Carousel Section -->
<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="../src/1.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../src/2.png" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../src/3.png" alt="Third slide">
    </div>
  
  </div>
</div>
<div class="container">
    <h2>Search and Filter Doctors</h2>
    <form class="filter-form" method="get" action="">
        <label for="specialization">Specialty:</label>
        <input type="text" name="specialization" id="specialization" value="<?php echo htmlspecialchars($_GET['specialization'] ?? ''); ?>">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($_GET['address'] ?? ''); ?>">
        <label for="availability">Availability:</label>
        <input type="text" name="availability" id="availability" value="<?php echo htmlspecialchars($_GET['availability'] ?? ''); ?>">
        <label for="qualifications">Qualifications:</label>
        <input type="text" name="qualifications" id="qualifications" value="<?php echo htmlspecialchars($_GET['qualifications'] ?? ''); ?>">
        <button type="submit">Search</button>
    </form>

    <h2>Doctors List</h2>
    <table>
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Specialization</th>
                <th>Department</th>
                <th>Phone Extension</th>
                <th>Shift</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Registration Date</th>
                <th>Qualifications</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($doctors) > 0): ?>
                <?php foreach ($doctors as $doctor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doctor['staff_id']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['department']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['phone_extension']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['shift']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['address']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['registration_date']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['qualifications']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="13">No doctors found matching the criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
<footer>
        <p>&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
    </footer>
</html>

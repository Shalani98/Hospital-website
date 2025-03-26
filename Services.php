<?php
session_start();

// Database connection
require_once('dataconnect.php');

// Fetch all hospital branches information from the database
$query = "SELECT * FROM hospital_info";
$result = mysqli_query($conp, $query);

// Check if the query returned any rows
if (!$result) {
    die("Query failed: " . mysqli_error($conp));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Care Compass Hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .logo {
            height: 150px;
            width: 150px;
        }
        .service-icon {
            font-size: 40px;
            color: #017d73;
            margin-right: 20px;
        }
        body {
            display: flex;
           
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            flex: 1;
        }
        footer {
            background-color: #017d73;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header Section -->
    <header class="mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <img src="src/CareCompass.png" alt="CareCompass Logo" class="logo">
            <h1>Care Compass Hospitals</h1>
        </div>
        <nav>
            <a href="#featured-services" class="text-decoration-none text-primary fw-bold me-3">Featured Services</a>
            <a href="#medical-treatments" class="text-decoration-none text-primary fw-bold me-3">Medical Treatments</a>
            <a href="#laboratory-services" class="text-decoration-none text-primary fw-bold me-3">Laboratory Services</a>
            <a href="#emergency-information" class="text-decoration-none text-primary fw-bold">Emergency Information</a>
        </nav>
    </header>

    <!-- Featured Services Section -->
    <section id="featured-services" class="mb-5">
        <h2 class="text-primary mb-4">Featured Services</h2>
        <div class="row g-4">
            <?php while ($hospital_info = mysqli_fetch_assoc($result)): ?>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                       
                            <h3 class="card-title text-success">Branch: <?php echo htmlspecialchars($hospital_info['branch_name']); ?></h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Service Details:</strong> <?php echo nl2br(htmlspecialchars($hospital_info['service_details'])); ?></li>
                                <li class="list-group-item"><strong>Contact:</strong> <?php echo htmlspecialchars($hospital_info['contact_info']); ?></li>
                                <li class="list-group-item"><strong>Address:</strong> <?php echo htmlspecialchars($hospital_info['address']); ?></li>
                                <li class="list-group-item"><strong>Last Updated:</strong> <?php echo htmlspecialchars($hospital_info['updated_at']); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Additional Healthcare Services Section -->
    <main>
        <section id="medical-treatments" class="mb-5">
            <h2 class="text-primary mb-3">Medical Treatments</h2>
            <p><i class="fas fa-stethoscope service-icon"></i> Our general medicine department offers consultations for a wide range of health conditions.</p>
        </section>

        <section id="laboratory-services" class="mb-5">
            <h2 class="text-primary mb-3">Laboratory Services</h2>
            <p><i class="fas fa-vials service-icon"></i> We provide comprehensive laboratory services including blood tests, urine tests, and more.</p>
        </section>

        <section id="emergency-information" class="mb-5">
            <h2 class="text-primary mb-3">Emergency Information</h2>
            <p><i class="fas fa-ambulance service-icon"></i> Our emergency department is always ready to provide immediate care for critical conditions.</p>
        </section>
    </main>
</div>

<!-- Footer Section -->
<footer>
    <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

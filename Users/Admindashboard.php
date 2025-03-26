<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareCompass Hospital Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome Icons -->
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
          
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
           
            color: white;
            height: 800px;
            position: fixed;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            transition: width 0.3s;
        }

        .sidebar h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 26px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar ul li:hover {
            background-color: #1abc9c;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            background-color: #ecf0f1;
            min-height: 100%;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 20px 0;
            text-align: center;
            background-color: #2980b9;
            color: white;
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
            font-size: 32px;
        }

        /* Dashboard Section */
        .admin-dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .info-box {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
            padding: 30px;
            text-align: center;
            color: #333;
            transition: transform 0.3s;
        }

        .info-box:hover {
            transform: translateY(-10px);
        }

        .info-box .icon {
            font-size: 40px;
            margin-bottom: 20px;
            color: #3498db;
        }

        .info-box h4 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .info-box p {
            font-size: 18px;
        }

        /* Icons */
        .fa-doctor, .fa-flask, .fa-user-nurse {
            color: #3498db;
        }

        /* Responsive Layout */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 80px;
            
            }

            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
            }

            .admin-dashboard {
                flex-direction: column;
                align-items: center;
            }

            .info-box {
                width: 80%;
                margin-bottom: 20px;
            }
        }

        footer {
            background-color: #444; 
    color: white;
    text-align: center;
    padding: 20px;
    width: 100vw; 
    position: relative;
    left: 0;
    bottom: 0;
        }

        .footer-info {
            font-size: 14px;
        }

    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">

    
        <ul>
            <li><a href="Admindashboard.php">Dashboard</a></li>
            <li><a href="Register.php">Create Users</a></li>
            <li><a href="manage_users.php">Add, Edit, Delete Users</a></li>
            <li><a href="hospitalinformation.php">Update Hospital Info</a></li>
            <li><a href="Doctorprofiles2.php">Manage Staff Profiles</a></li>
            <li><a href="queryshow.php">Handle User Queries</a></li>
            <li><a href="Administrator.php">Patient Feedback Records</a></li>
            <li><a href="Userlogin.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>Administrator Dashboard</h2>
        </header>

        <section class="admin-dashboard">
            <div class="info-box">
                <div class="icon"><i class="fas fa-user-md"></i></div>
                <h3>Doctors</h3>
                <p>
                    <?php
                        include("../dataconnect.php");
                        $sql_doctors = "SELECT COUNT(*) AS total_doctors FROM staff WHERE role = 'Doctor';";
                        $result_doctors = mysqli_query($conp, $sql_doctors);
                        if ($result_doctors) {
                            $row_doctors = mysqli_fetch_assoc($result_doctors);
                            echo $row_doctors['total_doctors'];
                        } else {
                            echo "0";
                        }
                    ?>
                </p>
            </div>

            <div class="info-box">
                <div class="icon"><i class="fas fa-flask"></i></div>
                <h3>Lab Technicians</h3>
                <p>
                    <?php
                        include("../dataconnect.php");
                        $sql_LabTechnician = "SELECT COUNT(*) AS total_LabTechnician FROM staff WHERE role = 'Lab Technician';";
                        $result_LabTechnician = mysqli_query($conp, $sql_LabTechnician);
                        if ($result_LabTechnician) {
                            $row_LabTechnician = mysqli_fetch_assoc($result_LabTechnician);
                            echo $row_LabTechnician['total_LabTechnician'];
                        } else {
                            echo "0";
                        }
                    ?>
                </p>
            </div>

            <div class="info-box">
                <div class="icon"><i class="fas fa-user-nurse"></i></div>
                <h3>Nurses</h3>
                <p>
                    <?php
                        include("../dataconnect.php");
                        $sql_nurses = "SELECT COUNT(*) AS total_nurses FROM staff WHERE role = 'Nurse';";
                        $result_nurses = mysqli_query($conp, $sql_nurses);
                        if ($result_nurses) {
                            $row_nurses = mysqli_fetch_assoc($result_nurses);
                            echo $row_nurses['total_nurses'];
                        } else {
                            echo "0";
                        }
                    ?>
                </p>
            </div>

            <div class="info-box">
                <div class="icon"><i class="fas fa-hospital"></i></div>
                <h3>Branches</h3>
                <p>3 Branches</p>
            </div>

            <div class="info-box">
                <div class="icon"><i class="fas fa-bed"></i></div>
                <h3>Available Beds</h3>
                <p>500 Beds</p>
            </div>
        </section>
    </div>
  
    <!-- Footer -->
    <footer>
        <p class="footer-info">&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
    </footer>
</body>
</html>

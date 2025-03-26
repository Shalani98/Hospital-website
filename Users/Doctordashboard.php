<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> <!-- Google Fonts for a modern look -->
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5em;
            margin: 0;
        }

        .navigation-bar {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }

        .navigation-bar a {
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            background-color: #34495e;
            border-radius: 5px;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
        }

        .navigation-bar a:hover {
            background-color: #1abc9c;
        }

        /* Logout Button Styling */
        .logout-button {
            color: white;
            background-color: #3498db; /* Calm blue shade */
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 15px;
            display: inline-block;
        }

        .logout-button:hover {
            background-color: #2980b9; /* Slightly darker blue */
            transform: translateY(-3px);
        }

        /* Main Dashboard */
        .doctor-dashboard {
            padding: 50px 20px;
            text-align: center;
        }

        .doctor-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
        }

        .doctor-section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .doctor-section:hover {
            transform: translateY(-5px);
        }

        .doctor-section h3 {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .doctor-section button {
            padding: 15px 30px;
            font-size: 1.1em;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s;
            margin-top: 10px;
        }

        .doctor-section button:hover {
            background-color: #3498db;
            transform: translateY(-3px);
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 1.1em;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .doctor-actions {
                flex-direction: column;
                align-items: center;
            }

            .doctor-section {
                width: 80%;
            }

            header h1 {
                font-size: 2em;
            }

            footer {
                background-color: #444; /* Dark shade */
                color: white;
                text-align: center;
                padding: 20px;
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section with Navigation -->
    <header>
        <h1>Doctor Dashboard</h1>
        <a href="Userlogin.php" class="logout-button">Logout</a>
    </header>

    <!-- Main Dashboard Section -->
    <main>
        <section class="doctor-dashboard">
            <h2>Welcome to Your Dashboard</h2>
            <div class="doctor-actions">
                <!-- View Appointments History Section -->
                <div class="doctor-section">
                    <h3>View Appointments History</h3>
                    <button onclick="window.location.href='Doctorappointmenthistory.php'">View Appointments</button>
                </div>

                <!-- View Patient Profiles Section -->
                <div class="doctor-section">
                    <h3>View Patient Profiles</h3>
                    <button onclick="window.location.href='Displaypatients.php'">View Profiles</button>
                </div>

                <!-- Doctor Profile Section -->
                <div class="doctor-section">
                    <h3>Your Profile</h3>
                    <button onclick="window.location.href='Dprofiles.php'">View Profile</button>
                </div>
            </div>
          
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
    </footer>

</body>
</html>

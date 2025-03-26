<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Technician Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header */
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        header h1 {
            font-size: 2.5em;
            margin: 0;
        }

        /* Logout Button */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s;
        }

        .logout-btn:hover {
            background-color: #bd2130;
            transform: translateY(-2px);
        }

        /* Main Dashboard */
        .labtechnician-dashboard {
            padding: 40px 20px;
            text-align: center;
        }

        .labtechnician-dashboard h2 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #007bff;
        }

        .labtechnician-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .labtechnician-section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 280px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .labtechnician-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .labtechnician-section h3 {
            font-size: 1.4em;
            margin: 15px 0;
            color: #333;
        }

        .labtechnician-section i {
            font-size: 2.5em;
            color: #007bff;
            margin-bottom: 15px;
        }

        .labtechnician-section button {
            padding: 12px 20px;
            font-size: 1em;
            background-color: rgb(125, 167, 134);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s;
        }

        .labtechnician-section button:hover {
            background-color: rgb(14, 94, 185);
            transform: translateY(-3px);
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
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
            .labtechnician-actions {
                flex-direction: column;
                align-items: center;
            }

            .labtechnician-section {
                width: 90%;
            }

            header h1 {
                font-size: 2em;
            }

            .logout-btn {
                position: static;
                display: block;
                margin: 10px auto;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Lab Technician Dashboard</h1>
        <a href="Userlogin.php" class="logout-btn">Logout</a>
    </header>

    <!-- Main Dashboard Section -->
    <main>
        <section class="labtechnician-dashboard">
            <h2>Welcome to Your Dashboard</h2>
            <div class="labtechnician-actions">
                <!-- View Lab Results Section -->
                <div class="labtechnician-section">
                    <i class="fas fa-file-medical"></i>
                    <h3>View Lab Results</h3>
                    <button onclick="window.location.href='Labresults2.php'">View Lab Results</button>
                </div>

                <!-- Update Lab Results Section -->
                <div class="labtechnician-section">
                    <i class="fas fa-edit"></i>
                    <h3>Update Lab Results</h3>
                    <button onclick="window.location.href='Updatedlabresults2.php'">Update Lab Results</button>
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

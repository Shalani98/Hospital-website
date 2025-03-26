<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareCompass Hospital Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Reset basic styles */
        body,
        ul {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Body background color */
        body {
            background-color:white;
        }

        /* Header styles */
        header {
            background-color:rgb(68, 50, 173); /* Calming teal */
            padding: 15px 0;
            color: black;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Logo bar styles */
        .logo-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        /* Logo styles */
        .logo {
            height: 143px;
            width: 143px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effect for logo */
        .logo:hover {
            transform: translateY(-5px);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        }

        /* Navbar style */
        .navbar {
            background-color: white !important;
            padding: 10px;
        }

        /* Logo image inside navbar */
        .navbar .logo-img {
            height: 100px;
            width: 100px;
            margin-left: auto;
            margin-right: 15px;
        }

        /* Navigation bar styles */
        .navigation-bar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navigation-bar ul li {
            margin: 0;
        }

        /* Navigation link styles */
        .navigation-bar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        /* Hover effect on navigation links */
        .navigation-bar ul li a:hover {
            background-color: #005e57; /* Darker teal */
        }

        /* Banner image styles */
        .banner {
            position: relative;
        }

        .banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Section styles */
        section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #007f7f;
            border-bottom: 2px solid #005e57;
            padding-bottom: 5px;
        }

        .branch-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .branch {
            flex: 1 1 calc(33.333% - 20px);
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .branch h3 {
            color: #005e57;
        }

        /* Testimonials */
        .testimonials {
            background-color: #eef7f6;
        }

        .testimonial-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .testimonial {
            background: #ffffff;
            border-left: 4px solid #007f7f;
            padding: 10px 15px;
            border-radius: 5px;
            font-style: italic;
        }

        /* Footer styles */
        footer {
            background-color: #444; /* Dark shade */
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logo-bar {
                flex-direction: column;
                align-items: center;
            }

            .navigation-bar ul {
                flex-direction: column;
                align-items: center;
                width: 100%;
            }

            .branch-list {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" style="background-color: white;">
        <div class="container-fluid">
            <a href="Dashboard.php" class="navbar-brand">
                <img src="src/CareCompass.png" alt="CareCompass Logo" class="logo" />
            </a>
            
            <div class="d-flex justify-content-end w-100 ">
                <a href="Test.php"><img src="src/lab2.png" alt="tests" class="logo-img"></a> 
                <a href="Patients/Patients.php"><img src="src/BA.png" alt="Book Appointment" class="logo-img"></a>
                <a href="abc.php"><img src="src/IPC1.png" alt="International Patient Care" class="logo-img"margin-right: 100px;></a>
            </div>
        </div>
    </nav>

    <header>
        <div class="logo-bar">
            <nav class="navigation-bar">
                <ul>
                    <li><a href="Dashboard.php">Home</a></li>
                    <li><a href="Services.php">Services</a></li>
                    <li><a href="Staff/Doctorprofiles.php">Doctors</a></li>
                    <li><a href="Patients/Patients.php">Patient Portal</a></li>
                    <li><a href="Contactus.php">Contact Us</a></li>
                    <li><a href="Users/Userlogin.php">Staff</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Banner Section -->
        <div class="banner">
            <img src="src/log.png" alt="Banner" class="banner-image">
        </div>

        <!-- Hospital Branches Overview Section -->
        <section class="hospital-branches">
            <h2>Our Hospital Branches</h2>
            <div id="branchesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <!-- Branch 1 -->
                    <div class="carousel-item active">
                        <img src="src/hospital.jpeg" class="d-block w-100" alt="Kandy Branch">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Kandy</h3>
                            <p>Our Kandy branch offers state-of-the-art facilities and a dedicated team of medical professionals.</p>
                        </div>
                    </div>
                    <!-- Branch 2 -->
                    <div class="carousel-item">
                        <img src="src/hospital2.jpeg" class="d-block w-100" alt="Colombo Branch">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Colombo</h3>
                            <p>Located in the heart of Colombo, our flagship hospital provides comprehensive care and specialized services.</p>
                        </div>
                    </div>
                    <!-- Branch 3 -->
                    <div class="carousel-item">
                        <img src="src/hospital3.jpeg" class="d-block w-100" alt="Kurunegala Branch">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Kurunegala</h3>
                            <p>In Kurunegala, we provide high-quality healthcare with a focus on patient well-being and comfort.</p>
                        </div>
                    </div>
                </div>
                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#branchesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#branchesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <h2>Patient Testimonials</h2>
            <div class="testimonial-list">
                <div class="testimonial">
                    "The care I received at CareCompass was exceptional. The doctors were highly skilled, and the staff made me feel at ease."
                </div>
                <div class="testimonial">
                    "I had an outstanding experience. The hospital's attention to detail and patient care was beyond my expectations."
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

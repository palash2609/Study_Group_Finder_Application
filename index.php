<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connect with mentors and fellow students through our Study Group Finder platform.">
    <meta name="keywords" content="study groups, mentors, student registration, online learning">
    <title>Study Group Finder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Navbar -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="NMIMS_LOGO.png" alt="NMIMS Logo" class="nmims-logo">
                <span>STUDY GROUP FINDER</span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="student_login.php">Student Login</a></li>
                <li><a href="mentor_login.php">Mentor Login</a></li>
                <li><a href="#about">About Us</a></li>
            </ul>
        </nav>
    </header>

    <section class="background-section">
        <h1>Welcome to Study Group Finder</h1>
        <p id="a">Register right now to connect with mentors and students!</p>
    </section>

    <main>
        <section class="registration-section">
            <p>Please register below as a Student or Mentor:</p>
        </section>
        
        <div class="center-buttons">
            <button class="btn" id="student-btn">
                <a href="student_registration.php">
                    <img src="student_photo.jpeg" alt="Illustration of a student registering for a study group">
                    <span>Register as Student</span>
                </a>
            </button>
            <button class="btn" id="mentor-btn">
                <a href="mentor_registration.php">
                    <img src="mentor_profile.jpeg" alt="Illustration of a mentor registration">
                    <span>Register as Mentor</span>
                </a>
            </button>
        </div>
    </main>

    <footer>
        <p> &copy; 2024 Study Group Finder. All rights reserved.</p>
        <ul>
            <li><a href="#about">About Us</a></li>
        </ul>
    </footer>

</body>
</html>

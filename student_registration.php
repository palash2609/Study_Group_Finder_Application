<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: student_index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
    <h2>Student Registration Form</h2>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $contact = $_POST["contact"];
           $course = $_POST["course"];
           $semester = $_POST["semester"];
           $subject = $_POST["subject"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($fullName) OR empty($contact) OR empty($course) OR empty($semester) OR empty($subject) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           require_once "database.php";
           $sql = "SELECT * FROM student_details WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO student_details (full_name, contact, course, semester, subject, email, password) VALUES ( ?, ?, ?, ?, ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sssssss",$fullName, $contact, $course, $semester, $subject, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        
        <form action="student_registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:" required>
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="contact" placeholder="Enter your WhatsApp number:" required pattern="[0-9]{10}">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="course" placeholder="Enter your course:" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="semester" placeholder="Enter your semester:" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="subject" placeholder="Enter your learning subject:" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
            
        <div><p>Already Registered
            <a href="student_login.php"> <button class="btn btn-primary">Login Here</button></a>
            </p>
        </div>
      </div>
    </div>
    <footer>
        <p> &copy; 2024 Study Group Finder. All rights reserved.</p>
        <ul>
            <li><a href="#about">About Us</a></li>
        </ul>
    </footer>
</body>
</html>
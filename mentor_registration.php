
<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: mentor_index.php");
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
    <h2>Mentor Registration Form</h2>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $contact = $_POST["contact"];
           $course = $_POST["course"];
           $semester = $_POST["semester"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);
           $errors = array();
           
           if (empty($fullName) OR empty($contact) OR empty($course) OR empty($semester) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
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
           $sql = "SELECT * FROM mentor_details WHERE email = '$email'";
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
            
            $sql = "INSERT INTO mentor_details (full_name, contact, course, semester, email, password) VALUES ( ?, ?, ?, ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"ssssss",$fullName, $contact, $course, $semester, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
          
        }
        ?>
        
        <form action="mentor_registration.php" method="post">
            <div class="form-group">
            Full Name: <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="form-group">
            Enter your WhatsApp number: <input type="tel" class="form-control" name="contact" required pattern="[0-9]{10}">
            </div>
            <div class="form-group">
            Enter your course: <input type="text" class="form-control" name="course"  required>
            </div>
            <div class="form-group">
            Enter your semester: <input type="text" class="form-control" name="semester" placeholder="">
            </div>
            
            <div class="form-group">
            Enter Email:<input type="email" class="form-control" name="email" placeholder="" required>
            </div>
            <div class="form-group">
            Enter Password: <input type="password" class="form-control" name="password" placeholder="">
            </div>
            <div class="form-group">
            Enter Repeat Password:<input type="password" class="form-control" name="repeat_password" placeholder="">
            </div>
            <center>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary w-100" value="Register" name="submit">
            </div>
            </center>
           
        </form>
        <br>
        
        <center>
        <div>Already Registered?
            <br>
            <a href="mentor_login.php"> <button class="btn btn-primary w-100">Login Here</button></a>
            
        </div>
        </center>
     
       
    </div>
    <footer>
        <p> &copy; 2024 Study Group Finder. All rights reserved.</p>
        <ul>
            <li><a href="#about">About Us</a></li>
        </ul>
    </footer>
</body>
</html>

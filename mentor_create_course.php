<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: mentor_login.php");
    exit();
}
require_once "database.php";

$message = ""; 

if (isset($_POST["create_course"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $no_of_modules = $_POST["no_of_modules"];
    $demo_video_link = $_POST["demo_video_link"];
    $demo_notes_link = $_POST["demo_notes_link"];
    $mentor_id = $_SESSION["mentor_id"];

    
    if (empty($title) || empty($description) || empty($no_of_modules) || empty($demo_video_link) || empty($demo_notes_link)) {
        $message = "<div class='alert alert-danger'>All fields are required</div>";
    } else {
        $sql = "INSERT INTO courses (title, description, no_of_modules, demo_video_link, demo_notes_link, mentor_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssissi", $title, $description, $no_of_modules, $demo_video_link, $demo_notes_link,  $mentor_id);
            if (mysqli_stmt_execute($stmt)) {
                $message = "<div class='alert alert-success'>Course created successfully</div>";
            } else {
                $message = "<div class='alert alert-danger'>Failed to create course. Please try again later.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Something went wrong with the database statement. Please try again later.</div>";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Create Course</title>
    <style>
        
        .alert {
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<header>
        <div class="navbar">
            <div class="logo">
                <img src="NMIMS_LOGO.png" alt="NMIMS Logo" class="nmims-logo">
                <span>STUDY GROUP FINDER</span>
            </div>
            <div class="user">
                <span>👤</span>Hello, Mentor!
            </div>
        </div>
    </header>
    <div class="container">
        <h1>Create a New Course</h1>
        
        <form action="mentor_create_course.php" method="post" class="course-form">
    
                    <div class="form-group">
                <label for="title">Course Title:</label>
                <input type="text" id="title" name="title" required class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Course Description:</label>
                <textarea id="description" name="description" required class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="no_of_modules">Number of Modules:</label>
                <input type="number" id="no_of_modules" name="no_of_modules" required class="form-control">
            </div>
            <div class="form-group">
                <label for="demo_video_link">Demo Video Link:</label>
                <input type="text" id="demo_video_link" name="demo_video_link" required class="form-control">
            </div>
            <div class="form-group">
                <label for="demo_notes_link">Demo Notes PDF Link:</label>
                <input type="text" id="demo_notes_link" name="demo_notes_link" required class="form-control">
            </div>
            <div class="form-group">
                <label for="mentor_id">Mentor ID:</label>
                <input type="text" id="mentor_id" name="mentor_id" value="<?php echo $_SESSION['mentor_id']; ?>" class="form-control">
            </div>
            <button type="submit" name="create_course" class="btn btn-primary">Create Course</button>
            <a href="mentor_index.php" class="btn btn-secondary">Back</a> 
        </form>

        
        <?php echo $message; ?>

    </div>
</body>
</html>

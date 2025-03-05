<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: student_login.php");
}
require_once "database.php";

$student_id = $_SESSION["student_id"]; 


$sql = "SELECT courses.*, mentor_details.full_name FROM courses 
        JOIN mentor_details ON courses.mentor_id = mentor_details.id";
$result = mysqli_query($conn, $sql);

if (isset($_POST["enroll"])) {
    $course_id = $_POST["course_id"];
    $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>Successfully enrolled in the course</div>";
    } else {
        echo "<div class='alert alert-danger'>Something went wrong. Please try again later</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Available Courses</title>
</head>
<body>
   
    <div class="container">
        <h2>Available Courses</h2>
        <div class="courses-list">
            <?php while ($course = mysqli_fetch_assoc($result)) { ?>
                <div class="course-item">
                    <h3><?php echo $course['title']; ?></h3>
                    <p><?php echo $course['description']; ?></p>
                    <p><strong>Mentor:</strong> <?php echo $course['full_name']; ?></p>
                    <form action="student_courses.php" method="post">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

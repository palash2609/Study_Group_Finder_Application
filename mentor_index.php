<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: mentor_login.php");
}
require_once "database.php";

$mentor_id = $_SESSION["mentor_id"];


$sql_courses = "SELECT * FROM courses WHERE mentor_id = ?";
$stmt_courses = mysqli_prepare($conn, $sql_courses);
mysqli_stmt_bind_param($stmt_courses, "i", $mentor_id);
mysqli_stmt_execute($stmt_courses);
$result_courses = mysqli_stmt_get_result($stmt_courses);


$sql_enrollments = "SELECT student_details.full_name, student_details.email, student_details.contact, enrollments.course_id 
                    FROM enrollments 
                    JOIN student_details ON enrollments.student_id = student_details.id 
                    WHERE enrollments.course_id = ?";
$stmt_enrollments = mysqli_prepare($conn, $sql_enrollments);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Mentor Dashboard</title>
</head>

<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="NMIMS_LOGO.png" alt="NMIMS Logo" class="nmims-logo">
                <span>STUDY GROUP FINDER</span>
            </div>
            <div class="user">
                <span>👤</span> Hello, Mentor!
            </div>
        </div>
    </header>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        <center>
        <a href="mentor_create_course.php" class="btn btn-primary">Create Course</a>
        </center>
        
        <h2>Your Courses</h2>
        <?php while ($course = mysqli_fetch_assoc($result_courses)) { ?>
            <div class="container">
                <div class="course-item">
                    <h3>Course title: <?php echo $course['title']; ?></h3>
                    <p><h3>Course Description:</h3> <?php echo $course['description']; ?></p>
                    <p><h3>Number of Modules: </h3><?php echo $course['no_of_modules']; ?></p>
                    <div class="demo-session">
                        <h3>Demo Session</h3>
                        <iframe width="525" height="300" src="<?php echo $course['demo_video_link']; ?>"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="notes-preview">
                        <h3>Notes Preview</h3>
                        <p>📄 <a href="<?php echo $course['demo_notes_link']; ?>" target="_blank" download>SAMPLE1.PDF</a>
                        </p>
                    </div>
                    <h3>Enrolled Students</h3>
                    <?php
                    mysqli_stmt_bind_param($stmt_enrollments, "i", $course['id']);
                    mysqli_stmt_execute($stmt_enrollments);
                    $result_enrollments = mysqli_stmt_get_result($stmt_enrollments);

                    if (mysqli_num_rows($result_enrollments) > 0) {
                        echo "<table class='table'>";
                        echo "<thead><tr><th>Name</th><th>Email</th><th>Contact</th></tr></thead><tbody>";
                        while ($student = mysqli_fetch_assoc($result_enrollments)) {
                            echo "<tr><td>{$student['full_name']}</td><td>{$student['email']}</td><td>{$student['contact']}</td></tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<p>No students enrolled yet.</p>";
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <center>
        <div class="text-center mt-3">
            <a href="mentor_logout.php" class="btn btn-secondary">Logout</a>
        </div>
        </center>
        
    </div>
</body>

</html>
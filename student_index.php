<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: student_login.php");
    exit();
}
require_once "database.php";


$whatsappLink = "https://chat.whatsapp.com/GsOJqR4xG7P3uj937Q5Alk";


$sql = "SELECT courses.*, mentor_details.full_name FROM courses 
        JOIN mentor_details ON courses.mentor_id = mentor_details.id";
$result = mysqli_query($conn, $sql);

$enrollmentSuccess = false; 


if (isset($_POST["enroll"])) {
    $student_id = $_SESSION["student_id"];
    $course_id = $_POST["course_id"];
    $sql_enroll = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
    $stmt_enroll = mysqli_prepare($conn, $sql_enroll);
    if ($stmt_enroll) {
        mysqli_stmt_bind_param($stmt_enroll, "ii", $student_id, $course_id);
        if (mysqli_stmt_execute($stmt_enroll)) {
            $enrollmentSuccess = true; 
        } else {
            echo "<div class='alert alert-danger'>Something went wrong. Please try again later</div>";
        }
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
                <span>👤</span> Hello, Student!
            </div>
        </div>
    </header>
    <div class="container">
        <h2>Available Courses</h2>

        <div class="courses-list">
            <?php while ($course = mysqli_fetch_assoc($result)) { ?>
                <div class="container">
                    <div class="course-item">
                        <h3>Course title: <?php echo $course['title']; ?></h3>
                        <p><h3>Course Description: </h3><?php echo $course['description']; ?></p>
                        <p><h3>Number of Modules:</h3> <?php echo $course['no_of_modules']; ?></p>
                        <div class="demo-session">
                            <h3>Demo Session</h3>
                            <iframe width="525" height="300" src="<?php echo $course['demo_video_link']; ?>"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="notes-preview">
                            <h3>Notes Preview</h3>
                            <p>📄 <a href="<?php echo $course['demo_notes_link']; ?>" target="_blank" download>SAMPLE1.PDF</a></p>
                        </div>
                        <p><strong>Mentor:</strong> <?php echo $course['full_name']; ?></p>
                        <form action="student_index.php" method="post">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
        <center>
        <div class="text-center mt-3">
            <a href="student_logout.php" class="btn btn-secondary">Logout</a>
        </div>
        </center>
        

        
        <?php if ($enrollmentSuccess): ?>
    <div class="alert alert-success">Successfully enrolled in the course. Redirecting to WhatsApp Group...</div>
    <script>
        
        setTimeout(function() {
            window.open("<?php echo $whatsappLink; ?>", "_blank");
        }, 3000); 
    </script>
<?php endif; ?>

    </div>
</body>

</html>

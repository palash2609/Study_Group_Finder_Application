<?php
session_start();
include 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mentor_id = $_POST['mentor_id']; 
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];
    $demo_file_links = $_POST['demo_file_links'];
    $video_link = $_POST['video_link'];

    $sql = "INSERT INTO courses (mentor_id, course_name, course_description, demo_file_links, video_link) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $mentor_id, $course_name, $course_description, $demo_file_links, $video_link);

    if ($stmt->execute()) {
        header("Location: mentor_index.php?success=Course created successfully");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

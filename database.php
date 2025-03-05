<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "root";
$dbName = "study_group_finder";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>
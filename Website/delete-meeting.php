<?php
    session_start();
    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    echo "hi";

    $delete = $con->prepare("DELETE FROM Class_Meeting WHERE MeetingName=? AND SEmail=? AND Course_Name=? AND Course_Number=?");
    $delete->bind_param("sssi", $_POST['name'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
    $delete->execute();

    $_POST['cname'] = $_SESSION['course-name'];
    $_POST['cnum'] = $_SESSION['course-number'];

    echo $_POST['cname'];
    echo $_POST['cnum'];
    //fix this thing still

    // header("Location: edit-course.php");
    // die();
?>
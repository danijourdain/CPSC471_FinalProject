<?php
    session_start();
    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // echo $_SESSION['user-email']. $_SESSION['course-name']. $_SESSION['course-number']. "<br>";

    $delete = $con->prepare("DELETE FROM Student_Course WHERE SEmail=? AND CName=? AND CNumber=?");
    $delete->bind_param("ssi", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
    $delete->execute();

    $check_course = $con->prepare("SELECT * FROM Student_Course WHERE CName=? AND CNumber=?");
    $check_course->bind_param("si", $_SESSION['course-name'], $_SESSION['course-number']);
    $check_course->execute();
    $check_course = $check_course->get_result();

    if($check_course->num_rows == 0) {
        $delete = $con->prepare("DELETE FROM Course WHERE CName=? AND CNumber=?");
        $delete->bind_param("si", $_SESSION['course-name'], $_SESSION['course-number']);
        $delete->execute();
        //if there are no students taking the course, delete the course from the Course table
    }

    header("Location: courses.php");
    die();
    //delete things from attend_class
?>
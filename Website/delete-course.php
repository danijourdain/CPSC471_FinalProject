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
    header("Location: courses.php");
?>
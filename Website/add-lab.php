<?php 
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if($_POST['due'] != null) {
        $insert = $con->prepare("INSERT INTO Lab(MeetingName_Lab, SEmail, CName, CNumber, Lab_Topic, Due_Date, TA_Name) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssisss", $_SESSION['meeting-name'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['topic'], $_POST['due'], $_POST['ta']);
        $insert->execute();

        header("Location: edit-course.php");
        die();
    }
    else {
        header("Location: add-meeting.php");
        die();
    }
?>
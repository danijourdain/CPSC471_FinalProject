<?php 
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $select_viewer = $con->prepare("SELECT * FROM Viewer WHERE Email = ? AND SEmail = ? AND SchedID = ?");
    $select_viewer->bind_param("ssi", $_SESSION['user-email'], $_POST['Femail'], $_POST['ID']);
    $select_viewer->execute();
    $select_viewer = $select_viewer->get_result();

    if ($select_viewer->num_rows != 0) {
        $insert_viewer = $con->prepare("INSERT INTO Viewer (Email, SEmail, SchedID) VALUES (?, ?, ?)");
        $insert_viewer->bind_param("ssi", $_SESSION['user-email'], $_POST['Femail'], $_POST['ID']);
        $insert_viewer->execute();
        header("Location: view-schedules.php");
        die();
    }else{
        echo '<script>alert("Please enter a valid email and id")</script>';
        header("Location: view-schedules.php");
    }
                    //move to the weekly schedule page
?>
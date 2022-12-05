<?php 
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    
    $insert_viewer = $con->prepare("INSERT INTO Viewer (Email, SEmail, SchedID) VALUES (?, ?, ?)");
    $insert_viewer->bind_param("ssi", $_SESSION['user-email'], $_POST['Femail'], $_POST['ID']);
    $insert_viewer->execute();
    header("Location: view-schedules.php");
                    die();
                    //move to the weekly schedule page
?>
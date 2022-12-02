<?php
    session_start();

    if(!empty($_POST["start_date"]) && !empty($_POST["end_date"]) && !empty($_POST["Year"]) && !empty($_POST["Semester"])) {
        $start = $_POST["start_date"];
        $end = $_POST["end_date"];
        $year = $_POST["Year"];
        $semester = $_POST["Semester"];

        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $schedule = $con->prepare("SELECT * FROM schedule_ WHERE StudentEmail=? AND SemName=?");
        $schedule->bind_param("ss", $_SESSION['user-email'], $semester);
        $schedule->execute();
        $schedule = $schedule->get_result();
        //check if the new course already exists in the course table

        if($schedule->num_rows == 0) {
            $insert = $con->prepare("INSERT INTO schedule_(StartDate, EndDate, Year_, SemName, StudentEmail) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("ssiss", $start, $end, $year, $semester, $_SESSION['user-email']);
            $insert->execute();
        }

        
        
        //refresh the page so the new course will show up
    }
    header("Location: my-weekly-schedule.php");
    die();
?>
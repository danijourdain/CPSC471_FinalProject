<?php
    session_start();

    if(!empty($_POST["name"]) && !empty($_POST["number"]) && !empty($_POST["lecture-section"]) && !empty($_POST["semester"])) {
        $name = $_POST["name"];
        $number = $_POST["number"];
        $lecture = $_POST["lecture-section"];
        $semester = $_POST["semester"];

        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $course = $con->prepare("SELECT * FROM Course WHERE CName=? AND CNumber=?");
        $course->bind_param("ss", $name, $number);
        $course->execute();
        $course = $course->get_result();
        //check if the new course already exists in the course table

        if($course->num_rows == 0) {
            $insert = $con->prepare("INSERT INTO Course(CName, CNumber) VALUES (?, ?)");
            $insert->bind_param("si", $name, $number);
            $insert->execute();
        }

        $section = $con->prepare("SELECT * FROM Section WHERE CName=? AND CNumber=? AND LectureSection=? AND Semester=?");
        $section->bind_param("siss", $name, $number, $lecture, $semester);
        $section->execute();
        $section = $section->get_result();
        //check if the section already exists

        if($section->num_rows == 0) {
            $insert = $con->prepare("INSERT INTO Section(CName, CNumber, LectureSection, Semester) VALUES (?, ?, ?, ?)");
            $insert->bind_param("siss", $name, $number, $lecture, $semester);
            $insert->execute();
        }

        $student_course = $con->query("SELECT * FROM Student_Course WHERE SEmail='". $_SESSION['user-email']. "' AND CName='". $name. "' AND CNumber=". $number);
        //check if the student is already taking the course

        if($student_course->num_rows == 0) {
            $insert_student = $con->prepare("INSERT INTO Student_Course(SEmail, CName, CNumber) VALUES (?, ?, ?)");
            $insert_student->bind_param("ssi", $_SESSION['user-email'], $name, $number);
            $insert_student->execute();
            //if the student is not already taking the course, add them to the Student_Course table
        }

        
        //refresh the page so the new course will show up
    }
    header("Location: courses.php");
    die();
?>
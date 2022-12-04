<!DOCTYPE html>

<html>
    <head>
        <title>Exams</title>

        <link rel="stylesheet" href="styles/general.css">
    </head>

    <body>
        <header class="header">
            <a class="header-link" href="index.php">
                <div class="header-tab">
                    <div>Log Out</div>
                </div>
            </a>
            <div class="selected-header-tab">
                <div>My Schedule</div>
            </div>
            <a class="header-link" href="view-schedules.php">
                <div class="header-tab">
                    <div>View Schedules</div>
                </div>
            </a>
        </header>

        <nav class="sidebar">
            <a class="sidebar-link" href="my-schedule-weekly.php">
                <div class="sidebar-tab">
                    <div>Weekly Schedule</div>
                </div>
            </a>
            <a class="sidebar-link" href="to-do-list.php">
                <div class="sidebar-tab">
                    <div>To Do List</div>
                </div>
            </a>
            <div class="selected-sidebar-tab">
                <div>Assignments</div>
            </div>
            <a class="sidebar-link" href="exams.html">
                <div class="sidebar-tab">
                    <div>Exams</div>
                </div>
            </a>
            <a class="sidebar-link" href="courses.php">
                <div class="sidebar-tab">
                    <div>Courses</div>
                </div>
            </a>
        </nav>

        <main>
            <?php 
                session_start();
                $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
                //create database connection
                if ($con->connect_error) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                echo $_POST['aName']. $_POST['cnum']. $_POST['cname'];
                $takes = $con->prepare("DELETE FROM student_exam
                                                WHERE SEmail = ?
                                                AND EQName = ?
                                                AND Course_Number = ?
                                                AND Course_Name = ?");
                $takes->bind_param("ssis", $_SESSION['user-email'],$_POST['aName'], $_POST['cnum'], $_POST['cname']);
                $takes->execute();
                
                $exists = $con->prepare("SELECT * FROM student_exam
                                            WHERE EQName = ?
                                            AND Course_Number = ?
                                            AND Course_Name = ?" );
                $exists->bind_param("sis", $_POST['aName'], $_POST['cnum'], $_POST['cname']);
                $exists->execute();
                $exists = $exists->get_result();

                if($exists->num_rows == 0){
                    $delete = $con->prepare("DELETE FROM exam_quiz
                                             WHERE Name_ = ?
                                             AND Course_Number = ?
                                             AND Course_Name = ?");
                    $delete->bind_param("sis", $_POST['aName'], $_POST['cnum'], $_POST['cname']);
                    $delete->execute();
                }

                    header("Location: exams.php");
                    die();
                ?>
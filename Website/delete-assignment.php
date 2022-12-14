<!DOCTYPE html>

<html>
    <head>
        <title>Assignments</title>

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
                echo $_POST['aName'];
                $takes = $con->prepare("DELETE FROM completes_assignments
                                                            WHERE SEmail = ?
                                                            AND AName = ?
                                                            AND CNumber = ?
                                                            AND CName = ?");
                $takes->bind_param("ssis", $_SESSION['user-email'],$_POST['aName'], $_POST['cnum'], $_POST['cname']);
                $takes->execute();
                
                $exists = $con->prepare("SELECT * FROM completes_assignments
                                            WHERE AName = ?
                                            AND CNumber = ?
                                            AND CName = ?" );
                $exists->bind_param("sis", $_POST['aName'], $_POST['cnum'], $_POST['cname']);
                $exists->execute();
                $exists = $exists->get_result();

                if($exists->num_rows == 0){
                    $delete = $con->prepare("DELETE FROM Assignment
                                             WHERE Name_ = ?
                                             AND CNumber = ?
                                             AND CName = ?");
                    $delete->bind_param("sis", $_POST['aName'], $_POST['cnum'], $_POST['cname']);
                    $delete->execute();

                }

                    header("Location: assignments.php");
                    die();
                ?>
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
            <a class="sidebar-link" href="assignments.php">
                <div class="sidebar-tab">
                    <div>Assignments</div>
                </div>
            </a>
            <a class="sidebar-link" href="exams.php">
                <div class="selected-sidebar-tab">
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
            ?>

            <h1> <?php
                echo "Viewing Exam ". $_POST['aName'];
            ?></h1>
                <?php
                    $view = $con->prepare("SELECT * FROM exam_quiz AS A, student_exam AS E
                                            WHERE A.Name_ = ?
                                            AND A.Course_Name = ? AND A.Course_Name = E.Course_Name
                                            AND A.Course_Number = ? AND A.Course_Number = E.Course_Number
                                            AND E.SEmail = ?");
                    $view->bind_param("ssis", $_POST['aName'], $_POST['cname'], $_POST['cnum'], $_SESSION['user-email']);
                    $view->execute();
                    $view = $view->get_result();
                ?>
                <h2>
                    <?php foreach($view as $exam){
                            echo "Class: ". $exam['Course_Name']. " ". $exam['Course_Number']. "<br>";
                            echo "Exam Weight: ".  $exam['Weight_']. "% <br>";
                            echo "Exam Date: ". $exam['Date_']. "<br>";
                            echo "Exam Location: ". $exam['Hall']. "<br>";
                            echo "Exam Start time: ". $exam['StartTime']. "<br>";
                            echo "Exam Length: ". $exam['Length_']. "<br>";
                            if(!empty($exam['Chapters'])){
                                echo "Exam Topic: ". $exam['Chapters']. "<br>";
                            }
                        }
                    ?>
                </h2>
        </main>
    </body>
</html>
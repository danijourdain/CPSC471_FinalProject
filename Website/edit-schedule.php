<!DOCTYPE html>

<html>
    <head>
        <title>Weekly Schedule</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/my-schedule-page.css">
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
            <div class="selected-sidebar-tab">
                <div>Weekly Schedule</div>
            </div>
            <a class="sidebar-link" href="to-do-list.php">
                <div class="sidebar-tab">
                    <div>To Do List</div>
                </div>
            </a>
            <a class="sidebar-link" href="assignments.php">
                <div class="sidebar-tab">
                    <div>Assigments</div>
                </div>
            </a>
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

        </main>
    </body>

    <?php
        session_start();
        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    ?>

    <h1> <?php 
        echo $_POST["SemName"]. " ". $_POST["Year_"]; ?>
    </h1>
        
    <?php
        $_SESSION['Semester'] = $_POST['SemName'];
        $_SESSION['Year'] = $_POST['Year_'];
    ?>

    <div class="center">
        <div class="existing-schedule">
            <?php
                $student_semester = $con->prepare("SELECT * FROM schedule_ WHERE StudentEmail=? AND Year_ = ? AND SemName = ? ");
                $student_semester->bind_param("sis", $_SESSION['user-email'], $_SESSION['Year'], $_SESSION['Semester']);
                $student_semester->execute();
                $student_semester = $student_semester->get_result();

                foreach($student_semester as $c) {
                    echo $c['MeetingName']. " ". $c['RoomNum']. " ". $c['Topic']. "<br>";
                }
            ?>
        </div>
        <div class="divider-bar"></div>
        <div class="new-meeting">
            <form method="post" action="add-meeting.php">
                <input class="add-meeting-input" type="text" name="meeting-name" placeholder="Meeting Name"><br>
                <input class="add-meeting-input" type="text" name="room-no" placeholder="Room #"><br>
                <input class="add-meeting-input" type="text" name="day" placeholder="Days of week (separated by a comma)"><br>
                <input class="add-meeting-input" type="text" name="time" placeholder="Time (hh:mm format)"><br>
                <input class="add-meeting-input" type="text" name="frequency" placeholder="Frequency (ex. weekly, biweekly)"><br>
                <input class="add-meeting-input" type="text" name="topic" placeholder="Topic"><br>
                <div>
                    <select class="dropdown-box" id="meeting-type" name="meeting-type">
                        <option value="none" selected disabled hidden>Select Class Type</option>
                        <option value="lab">Lab</option>
                        <option value="lecture">Lecture</option>
                        <option value="seminar">Seminar</option>
                        <option value="tutorial">Tutorial</option>
                    </select>
                </div>
                <input class="add-meeting-button" type="submit" value="Add New Meeting">
            </form>
        </div>
    </div>
    
    <div>
        <form method="post" action="delete-course.php">
            <input class="delete-course-button" type="submit" value="Delete Course">
        </form>
    </div>

    <div>
        <a href="courses.php"><button class="back-button">
            Back
        </button></a>
    </div>
</html>
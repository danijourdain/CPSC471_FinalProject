<!DOCTYPE html>

<html>
    <head>
        <title>Edit Course</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/edit-course.css">
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
            <a class="sidebar-link" href="to-do-list.php"> <div class="sidebar-tab">
                <div>To Do List</div>
            </div> </a>
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
            <a class="selected-link" href="courses.php">
                <div class="selected-sidebar-tab">
                    <div>Courses</div>
                </div>
            </a>
        </nav>


    </body>

    <?php
        session_start();
        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        ?>
        <div class="course-name"> <?php 
            echo $_POST["cname"]. " ". $_POST["cnum"]; ?>
        </div>

    <?php
        $_SESSION['course-name'] = $_POST['cname'];
        $_SESSION['course-number'] = $_POST['cnum'];
    ?>

    <div class="center">
        <div>
            <?php
                $student_class = $con->prepare("SELECT c.* FROM Attends_Class AS a, Student_Course AS s, Class_Meeting AS c WHERE s.SEmail=? AND c.Course_Name=s.CName AND c.Course_Number=s.CNumber AND a.CMeetingName=c.MeetingName AND a.SEmail=?");
                $student_class->bind_param("ss", $_SESSION['user-email'], $_SESSION['user-email']);
                $student_class->execute();
                $student_class = $student_class->get_result();
                echo "Hi";
                foreach($student_class as $c) {
                    echo $c['MeetingName']. " ". $c['RoomNum']. " ". $c['Topic'];
                }
            ?>
        </div>
        <div>
            <form method="post" action="add-meeting.php">
                <input class="add-meeting-input" type="text" name="meeting-name" placeholder="Meeting Name"><br>
                <input class="add-meeting-input" type="text" name="room-no" placeholder="Room #"><br>
                <input class="add-meeting-input" type="text" name="day" placeholder="Day of the week"><br>
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
</html>

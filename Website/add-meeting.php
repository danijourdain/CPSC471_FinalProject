<!DOCTYPE html>

<html>
    <head>
        <title>Add Meeting</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/add-course.css">
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

        <?php
            session_start();

            if(!empty($_POST["meeting-name"]) && !empty($_POST["day"]) && !empty($_POST["time"]) && !empty($_POST["frequency"])) {
                $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
                //create database connection

                if ($con->connect_error) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $days = explode(",", $_POST["day"]);
                //split the days into array elements

                $insert = $con->prepare("INSERT INTO Class_Meeting(MeetingName, RoomNum, Topic, Course_Name, Course_Number) VALUES (?, ?, ?, ?, ?)");
                $insert->bind_param("ssssi", $_POST["meeting-name"], $_POST["room-no"], $_POST["topic"], $_SESSION['course-name'], $_SESSION['course-number']);
                $insert->execute();
                //add the meeting into Class_Meeting
                echo "a";

                $get_id = $con->query("SELECT MAX(ID) AS max_id FROM Class_Meeting");
                $row = $get_id->fetch_array();
                $id = $row['max_id'];
                //get the id of the newly inserted tuple
                echo "b";

                echo strtoupper($_POST["frequency"]);

                echo "c1?";

                foreach($days as $id=>$day) {
                    echo $day;
                    $time = $con->prepare("INSERT INTO Scheduled_Time_Slot(ID, MeetingName_, DaysOFWeek, TimeOfDay, Frequency) VALUES(?, ?, ?, ?, ?)");
                    $time->bind_param("sssss", $id, $_POST["meeting-name"], $day, $_POST["time"], strtoupper($_POST["frequency"]));
                    $time->execute();
                    echo "c";
                }
                echo "c2";

                $insert = $con->prepare("INSERT INTO Attends_Class(CMeetingName, SEmail) VALUES (?, ?)");
                $insert->bind_param("ss", $_POST["meeting-name"], $_SESSION['user-email']);
                $insert->execute();
                //insert into the attends_class table
                echo "d";
            }
        ?>
    </body>
</html>
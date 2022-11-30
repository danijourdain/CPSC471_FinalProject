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
           echo "hi " .$_SESSION['user-email']. "! Welcome to your schedule!";
    ?>
    <div class="table-header">
            These are all the Schedules you have made so far
        </div>

        <div>
            <div class="separation-line"></div>

            <div>
            <div class="separation-line"></div>
            <?php
            
            $con = new mysqli("localhost", "admin", "cpsc471", "471_Final_Project");
            //create new database connection

            if($con->connect_error) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $schedule = $con->prepare("SELECT * FROM schedule_ AS C WHERE C.StudentEmail=?");
            $schedule->bind_param("s", $_SESSION['user-email']);
            $schedule->execute();
            $schedule = $schedule->get_result();
            //get all courses the student is currently taking from the database

            // $i = 0;
            // $_SESSION['cnames'] = array();
            // $_SESSION['cnums'] = array();

            foreach($schedule as $c):?>
                <div class="Schedule-box">
                    <div>
                        <?php echo $c['SemName']. "\t". $c['Year_'];?>
                    </div>

                    <div class="button-section"><form action="edit-schedule.php" method="post">
                        <input type="hidden" name="SemName" value="<?php echo $c['SemName']?>"/>
                        <input type="hidden" name="Year_" value="<?php echo $c['Year_']?>"/>
                        <input class="edit-button" type="submit" value='Edit Schedule'>
                    </form></div>
                </div>
                <div class="separation-line"></div>
            <?php endforeach;
            //print each course name and number the student is taking
            
        ?></div>
        <div class="other-button-section">
                <!-- add course section -->
                <div class="input-form"> <form method="post" action="add-schedule.php">
                    <input class="schedule-input-box" type="text" name="start_date" placeholder="yyyy-mm--dd (ex. 2022-04-02)"><br>
                    <input class="schedule-input-box" type="text" name="end_date" placeholder="yyyy-mm--dd (ex. 2022-10-21)"><br>
                    <input class="schedule-input-box" type="text" name="Year" placeholder="yyyy (ex. 2019)"><br>
                    <input class="schedule-input-box" type="text" name="Semester" placeholder="Semester (ex. Fall)"><br>
                    <input class="add-schedule-button" type="submit" value="Add Schedule">
                </form></div>
            </div>
    <?php
        include_once("zapcallib.php");
        // session_start();
        $con = new mysqli("localhost","select","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $icalobj = new ZCiCal();
        $start_date = $con->prepare("SELECT * FROM schedule_ WHERE StudentEmail = ?");
        $start_date->bind_param("s", $_SESSION['user-email']);
        $start_date->execute();
        $result = $start_date->get_result();
        $start_date->close();
        if($result->num_rows > 1) {
            echo "error! too many rows returned!";
            die();
            //if there is are multiple results, something has gone wrong, end the program
        }
        else if($result->num_rows == 1) {
            $res = $result->fetch_array();
            $start_date = $res['StartDate'];
            $end_date = $res['EndDate'];
        }
        $meeting_names = $con->prepare("SELECT * FROM student_course WHERE SEmail = ?");
        $meeting_names->bind_param("s", $_SESSION['user-email']);
        $meeting_names->execute();
        $result = $meeting_names->get_result();
        $meeting_names->close();
        while($res1 = $result->fetch_array()){
            $curr_meeting = $res1['CMeetingName'];
            $RoomNum = $con->prepare("SELECT * FROM class_meeting WHERE MeetingName = ?");
            $RoomNum->bind_param("s", $curr_meeting);
            $RoomNum->execute();
            $RoomResult = $RoomNum->get_result();
            $RoomNum->close();
            $Timing = $con->prepare("SELECT * FROM scheduled_time_slot WHERE MeetingName_ = ?");
            $Timing->bind_param("s", $curr_meeting);
            $Timing->execute();
            $TimingResult = $Timing->get_result();
            $Timing->close();
            $RoomInfo = $RoomResult->fetch_array();
            $TimingInfo = $TimingResult->fetch_array();

            // create the event within the ical object
            $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);

            // add title
            $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $RoomInfo['MeetingName']));

            $temp_start = ZCiCal::fromSqlDateTime($start_date . " ". $TimingInfo['TimeOfDay']);
            // $temp_start = $start_date . " ". $TimingInfo['TimeOfDay'];

            // add start date
            $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . $temp_start));
            $eventobj->addNode(new ZCiCalDataNode(" DURATION:" . "PT1H0M0S"));

            // add end date since no duration it is assumed to be 1 hr
            // $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));

            // UID is a required item in VEVENT, create unique string for this event
            // Adding your domain to the end is a good way of creating uniqueness
            $uid = $RoomInfo['MeetingName'] . $_SESSION['user-email'];
            $eventobj->addNode(new ZCiCalDataNode("UID:" . $uid));

            // DTSTAMP is a required item in VEVENT
            $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));

            // Add description
            $eventobj->addNode(new ZCiCalDataNode("Description:" . ZCiCal::formatContent($RoomInfo['Topic'])));
            $temp_end = ZCiCal::fromSqlDateTime($end_date . " ". $TimingInfo['TimeOfDay']);

            $eventobj->addNode(new ZCiCalDataNode("RRULE:FREQ=". $TimingInfo['Frequency'].";UNTIL=".$temp_end.";WKST=SU;BYDAY=".$TimingInfo['DaysOFWeek']));
        }
        //should be changed to Schedule ID
        $info =  rtrim($icalobj->export());
        $file = "./icalendar/calendars/".$_SESSION['user-email'].".ics";
        file_put_contents($file, $info);
 
        
    ?>
</html>
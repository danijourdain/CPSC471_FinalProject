<!DOCTYPE html>

<html>
    <head>
        <title>Weekly Schedule</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/download-schedule.css">
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


        <main>

        </main>
    </body>

    <?php
    session_start();

    if(!empty($_POST["Year"]) && !empty($_POST["Semester"])) {
        $year = $_POST["Year"];
        $semester = $_POST["Semester"];
        $ID = $_POST["ID"];
        $Email = $_POST["Email"];
        
        
        include_once("zapcallib.php");
        // session_start();
        $con = new mysqli("localhost","select","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $icalobj = new ZCiCal();
        $start_date = $con->prepare("SELECT * FROM schedule_ WHERE StudentEmail = ? AND SemName = ? AND ID = ?");
        $start_date->bind_param("ssi", $Email, $semester, $ID);
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
        
        $meeting_names = $con->prepare("SELECT * FROM class_meeting AS C,  section AS S WHERE C.SEmail = ? AND S.Semester = ? AND S.ID = ? AND C.Course_Name  = S.CName  AND C.Course_Number = CNumber");
        $meeting_names->bind_param("ssi", $Email, $semester, $ID);
        $meeting_names->execute();
        $result = $meeting_names->get_result();
        $meeting_names->close();
        while($res1 = $result->fetch_array()){
            $curr_meeting = $res1['MeetingName'];
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
            $eventobj->addNode(new ZCiCalDataNode("LOCATION:" . $RoomInfo['RoomNum']));
            $minutes = $TimingInfo['Duration'];
            $hours = "PT" . intdiv($minutes, 60).'H'. ($minutes % 60).'M0S';
            $eventobj->addNode(new ZCiCalDataNode(" DURATION:" . $hours));

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

            if (strcmp($TimingInfo['Frequency'], "WEEKLY")) {
                $eventobj->addNode(new ZCiCalDataNode("RRULE:FREQ=". $TimingInfo['Frequency'].";UNTIL=".$temp_end.";WKST=SU;BYDAY=".$TimingInfo['DaysOFWeek']));
            } else {
                
            }

            
        }
        $meeting_names = $con->prepare("SELECT * FROM exam_quiz AS C,  student_exam AS S WHERE S.SEmail = ?  AND C.Course_Name   = S.Course_Name   AND C.Course_Number  = S.Course_Number  AND C.Name_ = S.EQName");
        $meeting_names->bind_param("s", $Email);
        $meeting_names->execute();
        $result = $meeting_names->get_result();
        $meeting_names->close();
        $unique = 0;
        while($res1 = $result->fetch_array()){
            $curr_meeting = $res1['Name_'];
            $RoomNum = $con->prepare("SELECT * FROM exam_quiz WHERE Name_ = ?");
            $RoomNum->bind_param("s", $curr_meeting);
            $RoomNum->execute();
            $RoomResult = $RoomNum->get_result();
            $RoomNum->close();
            $RoomInfo = $RoomResult->fetch_array();

            // create the event within the ical object
            $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);

            // add title
            $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $RoomInfo['Name_']));

            $temp_start = ZCiCal::fromSqlDateTime($RoomInfo['Date_'] . " ". $RoomInfo['StartTime']);
            // $temp_start = $start_date . " ". $TimingInfo['TimeOfDay'];

            // add start date
            $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . $temp_start));
            $eventobj->addNode(new ZCiCalDataNode("LOCATION:" . $RoomInfo['Hall']));
            $minutes = $RoomInfo['Length_'];
            $hours = "PT" . intdiv($minutes, 60).'H'. ($minutes % 60).'M0S';
            $eventobj->addNode(new ZCiCalDataNode(" DURATION:" . $hours));

            // add end date since no duration it is assumed to be 1 hr
            // $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));

            // UID is a required item in VEVENT, create unique string for this event
            // Adding your domain to the end is a good way of creating uniqueness
            $uid = $RoomInfo['Name_'].$RoomInfo['Course_Name'] . $RoomInfo['Course_Number'] . $_SESSION['user-email'];
            $eventobj->addNode(new ZCiCalDataNode("UID:" . $uid . 'exam' .$unique));

            // DTSTAMP is a required item in VEVENT
            $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));

            // Add description
            $eventobj->addNode(new ZCiCalDataNode("Description:" . ZCiCal::formatContent($RoomInfo['Chapters'])));
            // $temp_end = ZCiCal::fromSqlDateTime($end_date . " ". $TimingInfo['TimeOfDay']);
        $unique = $unique + 1;

            
        }
        
        //should be changed to Schedule ID
        $info =  rtrim($icalobj->export());
        $file = "./icalendar/calendars/".$_SESSION['user-email']. $semester . $year.".ics";
        file_put_contents($file, $info);
    }
        
    ?>
        <p><a href=<?php echo $file?>>Download your icalendar file</a>
    Make sure to import the file to outlook or google calendar</p>
        <a href="my-schedule-weekly.php">Go Back to my schedule</a>
        </html>
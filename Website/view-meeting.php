<!DOCTYPE html>

<html>
    <head>
        <title>Edit Course</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/view-meeting.css">
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
            <a class="sidebar-link" href="exams.php">
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

            $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
            //create database connection

            if ($con->connect_error) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $meeting = $con->prepare("SELECT * FROM Class_Meeting WHERE SEmail=? AND Course_Name=? AND Course_Number=? AND MeetingName=?");
            $meeting->bind_param("ssis", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['name']);
            $meeting->execute();
            $meeting = $meeting->get_result();
            //get the meeting from the Class_Meeting table

            $times = $con->prepare("SELECT * FROM Scheduled_Time_Slot WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_=?");
            $times->bind_param("ssis", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['name']);
            $times->execute();
            $times = $times->get_result();
            //get the scheduled times for the meeting from the table
        ?>

        <div class="center"> <div class="header-section">
            <div class="header-label">Meeting Name</div>
            <div class="header-label">Meeting Type</div>
            <div class="header-label">Room Number</div>
            <div class="header-label">Topic</div>
            <div class="header-label">Day(s)</div>
            <div class="header-label">Time</div>
            <div class="header-label">Duration (minutes)</div>
            <div class="header-label">Frequency</div>
            
        <?php if($_POST['type'] == 'lab') { ?>
                <div class="header-label">Lab Topic</div>
                <div class="header-label">Due Date</div>
                <div class="header-label">TA Name</div>
        <?php 
                $lab = $con->prepare("SELECT * FROM Lab WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_Lab=?");
                $lab->bind_param("ssis", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['name']);
                $lab->execute();
                $lab = $lab->get_result();
                //if the meeting is a lab, get the extra info from the lab table
            }
            else if($_POST['type'] == 'lecture') { ?>
                <div class="header-label">Learning Objective</div>
                <div class="header-label">Chapter Discussed</div>
                <div class="header-label">Instructor Name</div>
        <?php 
                $lecture = $con->prepare("SELECT * FROM Lecture WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_Lec=?");
                $lecture->bind_param("ssis", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['name']);
                $lecture->execute();
                $lecture = $lecture->get_result();
                //if the meeting is a lecture, get the extra info from the lecture table
            }
            else if($_POST['type'] == 'seminar') { ?>
                <div class="header-label">Speaker(s)</div>
        <?php }
            else if($_POST['type'] == 'tutorial') { ?>
                <div class="header-label">TA Name</div>
        <?php 
                $tutorial = $con->prepare("SELECT * FROM Tutorial WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_Tut=?");
                $tutorial->bind_param("ssis", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['name']);
                $tutorial->execute();
                $tutorial = $tutorial->get_result();
                //if the meeting is a tutorial, get the extra info from the tutorial table
            } ?>
        </div>  

        <?php $mname;
        foreach($meeting as $m) { ?>
        <div class="content-section">
            <div class="content"><?php $mname = $m['MeetingName']; echo $mname ?></div>
            <div class="content"><?php echo ucwords($m['MeetingType']) ?></div>
            <div class="content"><?php echo $m['RoomNum'] ?></div>
            <div class="content"><?php echo $m['Topic']?: "N/A" ?></div>
        <?php } 
        
        foreach($times as $t) { ?>
            <div class="content"><?php echo $t['DaysOFWeek'] ?></div>
            <div class="content"><?php echo $t['TimeOfDay'] ?></div>
            <div class="content"><?php echo $t['Duration'] ?></div>
            <div class="content"><?php echo ucwords($t['Frequency']) ?></div>
        <?php } 
        
        if($_POST['type'] == 'lab') {
            foreach($lab as $l) { ?>
                <div class="content"><?php echo $l['Lab_topic']?: "N/A" ?></div>
                <div class="content"><?php echo $l['Due_Date']?: "N/A" ?></div>
                <div class="content"><?php echo $l['TA_Name']?: "N/A" ?></div>
            <?php }
        }
        else if($_POST['type'] == 'lecture') {
            foreach($lecture as $le) { ?>
                <div class="content"><?php echo $le['Learning_Obj']?: "N/A" ?></div>
                <div class="content"><?php echo $le['Ch_discussed']?: "N/A" ?></div>
                <div class="content"><?php echo $le['InstructorName']?: "N/A" ?></div>
            <?php }
        }
        else if($_POST['type'] == 'seminar') { 
            $speakers = $con->prepare("SELECT * FROM Speaker WHERE MeetingName_Sp=? AND SEmail=? AND CName=? AND CNumber=?");
            $speakers->bind_param("sssi", $mname, $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
            $speakers->execute();
            $speakers = $speakers->get_result();
            if($speakers->num_rows == 0) { ?>
                <div class="content">N/A</div>
            <?php }
            foreach($speakers as $sp) { ?>
                <div class="speaker-section"><div class="speaker-content"><?php echo $sp['Name_'] ?></div>
                <div class="speaker-content"><?php echo $sp['Organization'] ?></div>
                <div class="speaker-content"><?php echo $sp['Credentials'] ?></div></div>
            <?php }
            ?>
            
        <?php }
        else if($_POST['type'] == 'tutorial') {
            foreach($tutorial as $ti) { ?>
                <div class="content"><?php echo $ti['TA_Name']?: "N/A" ?></div>
        <?php } 
        }?>
        </div>

        <?php
        if($_POST['type'] == 'seminar') { ?>
            <div class="add-speaker"><form action="add-speaker.php" method="post">
                <input type="hidden" name="mname" value="<?php echo $mname;?>"/>
                <input class="speaker-input" type="text" name="name" placeholder="Speaker name"><br>
                <input class="speaker-input" type="text" name="org" placeholder="Speaker organization"><br>
                <input class="speaker-input" type="text" name="creds" placeholder="Speaker credentials"><br>
                <input class="speaker-button" type="submit" value="Add Speaker">
            </form></div>
        <?php }
        ?>
        </div>

        <div class="button-section"><form class="view-form" action="edit-course.php" method="post">
            <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
            <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
            <input class="back-button" type="submit" value='Back'>
        </form></div>
    </body>
</html>


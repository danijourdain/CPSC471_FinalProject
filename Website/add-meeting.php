<!DOCTYPE html>

<html>
    <head>
        <title>Add Meeting</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/add-meeting.css">
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

            $days = array();
            if(@$_POST["monday"]=="MO") {
                $days[] ="MO";
            }
            if(@$_POST["tuesday"]=="TU") {
                $days[]="TU";
            }
            if(@$_POST["wednesday"]=="WE") {
                $days[]="WE";
            }
            if(@$_POST["thursday"]=="TH") {
                $days[]="TH";
            }
            if(@$_POST["friday"]=="FR") {
                $days[]="FR";
            }
            $days = implode(",", $days);
            //turn the days into a list of values separated by commas

            if(!empty($_POST["meeting-name"]) && !empty($_POST["time"]) && !empty($_POST["frequency"]) && !empty($_POST["meeting-type"]) && !empty($days) && !empty($_POST['duration'])) {
                $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
                //create database connection

                if ($con->connect_error) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                if($_POST['meeting-type'] != 'group') {
                    $insert = $con->prepare("INSERT INTO Class_Meeting(MeetingName, SEmail, RoomNum, Topic, Course_Name, Course_Number, MeetingType) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insert->bind_param("sssssis", $_POST["meeting-name"], $_SESSION['user-email'], $_POST["room-no"], $_POST["topic"], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['meeting-type']);
                    $insert->execute();
                    //add the meeting into Class_Meeting

                    $time = $con->prepare("INSERT INTO Scheduled_Time_Slot(MeetingName_, SEmail, CName, CNumber, DaysOFWeek, TimeOfDay, Frequency, Duration) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                    $frequency = strtoupper($_POST["frequency"]);
                    $time->bind_param("sssisssi", $_POST["meeting-name"], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $days, $_POST["time"],$frequency , $_POST["duration"]);
                    $time->execute();
                    //insert each day into the scheduled time slot table 
                }

                $_SESSION['meeting-name'] = $_POST['meeting-name'];

                if($_POST['meeting-type'] == 'lab') {
                    //get extra information needed about labs
                    echo "Extra Info for Lab:"; ?>

                    <div class="input-area"><form method="post" action="add-lab.php">
                        <input class="text-field-lab" type="text" name="topic" placeholder="Lab Topic"><br>
                        <label class="field-label" for="due">Due Date: </label>
                        <input class="date-field" type="date" name="due" placeholder="Due Date"><br>
                        <input class="text-field-lab" type="text" name="ta" placeholder="TA Name"><br>
                        <input class="submit-button" type="submit" value="Add Lab">
                    </form></div>
                    
            <?php }
                else if($_POST['meeting-type'] == 'lecture') {
                    echo "Extra Info for Lecture:"; ?>

                    <div class="input-area"><form method="post" action="add-lecture.php">
                        <input class="text-field" type="text" name="objective" placeholder="Learning Objective"><br>
                        <input class="text-field" type="text" name="chapter" placeholder="Chapter Discussed"><br>
                        <input class="text-field" type="text" name="instructor" placeholder="Instructor Name"><br>
                        <input class="submit-button" type="submit" value="Add Lecture">
                    </form></div>
                    
            <?php }
                else if($_POST['meeting-type'] == 'seminar') {
                    $insert = $con->prepare("INSERT INTO Seminar(MeetingName_Sem, SEmail, CName, CNumber) VALUES (?, ?, ?, ?)");
                    $insert->bind_param("sssi", $_SESSION['meeting-name'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
                    $insert->execute();
                    ?>

                    <form id="form" action="edit-course.php" method="post">
                    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
                    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
                    </form>

                    <script type="text/javascript"> 
                    document.getElementById("form").submit();
                    </script>
                    
            <?php  }
                else if($_POST['meeting-type'] == 'tutorial') {
                    echo "Extra Info for Tutorial:"; ?>

                    <div class="input-area"><form method="post" action="add-tutorial.php">
                        <input class="text-field" type="text" name="ta" placeholder="TA Name"><br>
                        <input class="submit-button" type="submit" value="Add Tutorial">
                    </form></div>
                    
            <?php  }
                else if($_POST['meeting-type'] == 'group') {
                    echo "Extra Info for Group Meeting:"; ?>

                    <div class="input-area"><form method="post" action="add-group-meeting.php">
                        <input class="text-field" type="text" name="gname" placeholder="Group Name"><br>
                        <input class="text-field" type="text" name="id" placeholder="Group ID (leave blank if unknown)"><br>
                        <input class="submit-button" type="submit" value="Add Group Meeting">
                    </form></div>
                <?php }
            }
        ?>
    </body>
</html>
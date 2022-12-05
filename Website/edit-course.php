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


    </body>

    <?php
        session_start();
        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // if(($_SESSION['course-name'] == null && $_SESSION['course-number'] == null) || ($_SESSION['course-name'] != $_POST['cname'] && $_SESSION['course-number'] != $_POST['cnum'])) {
        //     
        // }
        $_SESSION['course-name'] = $_POST['cname'];
        $_SESSION['course-number'] = $_POST['cnum']; 
        ?>

    <h1> <?php 
        echo $_SESSION["course-name"]. " ". $_SESSION["course-number"]; 
        ?>
    </h1>

    <div class="grade-section">
        <?php
            $grade = $con->prepare("SELECT Grade FROM Student_Course WHERE SEmail=? AND CName=? AND CNumber=?");
            $grade->bind_param("ssi", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
            $grade->execute();
            $grade = $grade->get_result();

            foreach($grade as $g) {
                echo "Current Grade: ". $g['Grade'];
            }
        ?>
        <form action="update-grade.php" method="post">
            <input type="number" class="grade-input" name="grade" placeholder="Enter your grade">
            <input type="submit" class="grade-button" value="Update Grade">
        </form>
    </div>

    <div class="center">
        <div class="existing-meetings">
            <div class="meeting-header">
                <div class="header-label">Meeting Name</div>
                <div class="header-label">Meeting Type</div>
                <div class="header-label"></div>
                <div class="header-label"></div>
            </div>

            <?php
                $student_class = $con->prepare("SELECT c.* FROM Student_Course AS s, Class_Meeting AS c WHERE s.SEmail=? AND c.Course_Name=s.CName AND c.Course_Number=s.CNumber AND s.SEmail=c.SEmail AND s.CName=? AND s.CNumber=?");
                $student_class->bind_param("ssi", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
                $student_class->execute();
                $student_class = $student_class->get_result();

                foreach($student_class as $c) { ?>
                <div class="meeting">
                    <div class="table"> <?php echo $c['MeetingName'];?></div>
                    <div class="table"> <?php echo ucwords($c['MeetingType']);?></div>


                    <div class="button-section"><form class="view-form" action="view-meeting.php" method="post">
                        <input type="hidden" name="name" value="<?php echo $c['MeetingName'];?>"/>
                        <input type="hidden" name="type" value="<?php echo $c['MeetingType'];?>"/>
                        <input class="edit-button" type="submit" value='View Meeting Details'>
                    </form></div>
                    <div class="button-section"><form class="delete-form" action="delete-meeting.php" method="post">
                        <input type="hidden" name="name" value="<?php echo $c['MeetingName'];?>"/>
                        <input class="edit-button" type="submit" value='Delete Meeting'>
                    </form></div>
                </div>
                <?php }
            
                $group_meeting = $con->prepare("SELECT G.* FROM Group_Meeting AS G, Attends_Group_Meeting AS A WHERE G.ID=A.MeetingID AND G.Name_=A.GroupName AND A.SEmail=? AND G.CName=? AND G.CNumber=?");
                $group_meeting->bind_param("ssi", $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
                $group_meeting->execute();
                $group_meeting = $group_meeting->get_result();

                if($group_meeting->num_rows != 0) { ?>
                    <div class="meeting-header">
                    <div class="header-label">Group Name</div>
                    <div class="header-label"></div>
                    <div class="header-label"></div>
                    <div class="header-label"></div>
                    </div> 
                    <?php
                    foreach($group_meeting as $g) { ?>
                        <div class="meeting">
                            <div class="table"> <?php echo $g['Name_'];?></div>
                            <div class="table">Group Meeting</div>
        
        
                            <div class="button-section"><form class="view-form" action="view-group-meeting.php" method="post">
                                <input type="hidden" name="name" value="<?php echo $g['Name_'];?>"/>
                                <input type="hidden" name="id" value="<?php echo $g['ID'];?>"/>
                                <input class="edit-button" type="submit" value='View Meeting Details'>
                            </form></div>
                            <div class="button-section"><form class="delete-form" action="delete-group-meeting.php" method="post">
                                <input type="hidden" name="name" value="<?php echo $g['Name_'];?>"/>
                                <input type="hidden" name="id" value="<?php echo $g['ID'];?>"/>
                                <input class="edit-button" type="submit" value='Delete Meeting'>
                            </form></div>
                        </div>
                    <?php }
                }
            ?>
        </div>
        <div class="divider-bar"></div>
        <div class="new-meeting">
            <form method="post" action="add-meeting.php">
                <input class="add-meeting-input" type="text" name="meeting-name" placeholder="Meeting Name"><br>
                <input class="add-meeting-input" type="text" name="room-no" placeholder="Room #"><br>
                <input class="add-meeting-input" type="time" name="time" placeholder="Time (hh:mm format)"><br>
                <input class="add-meeting-input" type="number" name="duration" placeholder="Duration (Minutes)"><br>
                <div class="days-header">Meeting Days:</div>
                <div class="days-section">
                    <label><input class="checkbox" type="checkbox" value="MO" name="monday">Monday</label>
                    <label><input class="checkbox" type="checkbox" value="TU" name="tuesday">Tuesday</label><br>
                    <label><input class="checkbox" type="checkbox" value="WE" name="wednesday">Wednesday</label>
                    <label><input class="checkbox" type="checkbox" value="TH" name="thursday">Thursday</label>
                    <label><input class="checkbox" type="checkbox" value="FR" name="friday">Friday</label>
                </div>
                <!-- <input class="add-meeting-input" type="text" name="frequency" placeholder="Frequency (ex. weekly, biweekly)"><br> -->
                <div>
                    <select class="dropdown-box" id="frequency" name="frequency">
                        <option value="none" selected disabled hidden>Select Freqency</option>
                        <option value="WEEKLY">Weekly</option>
                    </select>
                </div>
                <input class="add-meeting-input" type="text" name="topic" placeholder="Topic"><br>
                <div>
                    <select class="dropdown-box" id="meeting-type" name="meeting-type">
                        <option value="none" selected disabled hidden>Select Class Type</option>
                        <option value="lab">Lab</option>
                        <option value="lecture">Lecture</option>
                        <option value="seminar">Seminar</option>
                        <option value="tutorial">Tutorial</option>
                        <option value="group">Group Meeting</option>
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

<!DOCTYPE html>

<html>
    <head>
        <title>Add Meeting</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/add-meeting.css">
        <link rel="stylesheet" href="styles/add-group-meeting.css">
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

            $dates = $con->prepare("SELECT * FROM Group_Meeting_Date WHERE GroupID=? AND GroupName=?");
            $dates->bind_param("is", $_POST['id'], $_POST['name']);
            $dates->execute();
            $dates = $dates->get_result();
        ?>


        <h1><?php echo $_POST['name']; ?> Dates</h1>
        <div class="center">
            <div class="existing-meetings">
                <div class="meeting-header">
                    <div class="header-label">Date</div>
                    <div class="header-label"></div>
                </div>

                <?php 
                    foreach($dates as $d) { ?>
                        <div class="date">
                            <div class="table"> <?php echo $d['Date_'];?></div>

                        <div class="button-section"><form class="delete-form" action="delete-date.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $d['GroupID'];?>"/>
                        <input type="hidden" name="name" value="<?php echo $d['GroupName'];?>"/>
                        <input class="edit-button" type="submit" value='Delete Meeting'>
                        </form></div>
                        </div>
                    <?php }
                ?>
            </div>  

            <div class="separation-bar"></div>
            
            <div class="add-dates">
                <form method="post" action="add-group-meeting-date.php">
                    <input type="hidden" name="id" value="<?php echo $_POST['id'];?>">
                    <input type="hidden" name="gname" value="<?php echo $_POST['name'];?>">
                    <input class="add-date-input" type="date" name="date"><br>
                    <input class="add-date-button" type="submit" value="Add New Date">
                </form>
            </div>

        </div>
        
        <form method="post" action="edit-course.php">
            <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>">
            <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-num'];?>">
            <input class="back-button" type="submit" value="Back">
        </form>
    </body>
</html>
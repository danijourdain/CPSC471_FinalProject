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
                <div class="button-section"><form action="download-schedule.php" method="post">
                    <input type="hidden" name="Semester" value="<?php echo $c['SemName']?>"/>
                    <input type="hidden" name="Year" value="<?php echo $c['Year_']?>"/>
                    <input class="download-button" type="submit" value='Download Schedule'>
                </form></div>
        </div>
            <div class="separation-line"></div>
        <?php endforeach;
        //print each course name and number the student is taking
        
    ?></div>
    <div class="other-button-section">
            <!-- add course section -->
            <div class="input-form"> <form method="post" action="add-schedule.php">
                <input class="schedule-input-box" type="date" name="start_date" ><br>
                <input class="schedule-input-box" type="date" name="end_date"><br>
                <input class="schedule-input-box" type="number" name="Year" placeholder="yyyy (ex. 2019)"><br>
                <input class="schedule-input-box" type="text" name="Semester" placeholder="Semester (ex. Fall)"><br>
                <input class="add-schedule-button" type="submit" value="Add Schedule">
            </form></div>
        </div>

</html>
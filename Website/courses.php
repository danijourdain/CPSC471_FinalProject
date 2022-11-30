<!DOCTYPE html>

<html>
    <head>
        <title>Courses</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/course.css">
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
            <div class="selected-sidebar-tab">
                <div>Courses</div>
            </div>
        </nav>

        <div class="table-header">
            These are all the courses you are currently taking
        </div>

        <div>
            <div class="separation-line"></div>
            <?php
            session_start();
            $con = new mysqli("localhost", "admin", "cpsc471", "471_Final_Project");
            //create new database connection

            if($con->connect_error) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            
            $courses = $con->prepare("SELECT * FROM Course AS C, Student_Course AS S WHERE S.SEmail=? AND S.CName = C.CName AND C.CNumber = S.CNumber");
            $courses->bind_param("s", $_SESSION['user-email']);
            $courses->execute();
            $courses = $courses->get_result();
            //get all courses the student is currently taking from the database

            foreach($courses as $c):?>
                <div class="course-box">
                    <div>
                        <?php echo $c['CName']. "\t". $c['CNumber'];?>
                    </div>

                    <div class="button-section"><form action="edit-course.php" method="post">
                        <input type="hidden" name="cname" value="<?php echo $c['CName']?>"/>
                        <input type="hidden" name="cnum" value="<?php echo $c['CNumber']?>"/>
                        <input class="edit-button" type="submit" value='Edit Course'>
                    </form></div>
                </div>
                <div class="separation-line"></div>
            <?php endforeach;
            //print each course name and number the student is taking
            
        ?></div>

        <div class="other-button-section">
            <!-- add course section -->
            <div class="input-form"> <form method="post" action="add-course.php">
                <input class="course-input-box" type="text" name="name" placeholder="Course Name (ex. CPSC)"><br>
                <input class="course-input-box" type="text" name="number" placeholder="Course Number (ex. 471)"><br>
                <input class="course-input-box" type="text" name="lecture-section" placeholder="Lecture Section (ex. L01)"><br>
                <input class="course-input-box" type="text" name="semester" placeholder="Semester (ex. Fall 2022)"><br>
                <input class="add-course-button" type="submit" value="Add Course">
            </form></div>
        </div>
    </body>
</html>
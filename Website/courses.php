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

            $i = 0;
            $_SESSION['cnames'] = array();
            $_SESSION['cnums'] = array();

            foreach($courses as $c):?>
                <div class="course-box">
                    <?php 
                        echo $c['CName']. "\t". $c['CNumber']; 
                        $_SESSION['cnames'][$i] = $c['CName'];
                        $_SESSION['cnums'][$i] = $c['CNumber'];
                        $i += 1;
                    ?>
                </div>
                <div class="separation-line"></div>
            <?php endforeach;
            //print each course name and number the student is taking
            
        ?></div>

        <div class="other-button-section">
            <!-- <button class="add-course-button">
                Add New Course
            </button></a> -->
            <!-- add course section -->
            <div class="input-form"> <form method="post">
                <input class="course-input-box" type="text" name="name" placeholder="Course Name (ex. CPSC)"><br>
                <input class="course-input-box" type="text" name="number" placeholder="Course Number (ex. 471)"><br>
                <input class="add-course-button" type="submit" value="Add Course">
            </form></div>

            <!-- edit course form -->
            <div class="input-form"><form method="post" action="edit-course.php">
                <input class="course-input-box" type="text" name="name" placeholder="Course Name (ex. CPSC)"><br>
                <input class="course-input-box" type="text" name="number" placeholder="Course Number (ex. 471)"><br>
                <input class="add-course-button" type="submit" value="Edit Course">
            </form></div>
        </div>
    </body>

    <?php
        if(!empty($_POST["name"]) && !empty($_POST["number"])) {
            $name = $_POST["name"];
            $number = $_POST["number"];

            $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
            //create database connection

            if ($con->connect_error) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $course = $con->prepare("SELECT * FROM Course WHERE CName=? AND CNumber=?");
            $course->bind_param("ss", $name, $number);
            $course->execute();
            $course = $course->get_result();
            //check if the new course already exists in the course table

            if($course->num_rows == 0) {
                $insert = $con->prepare("INSERT INTO Course(CName, CNumber) VALUES (?, ?)");
                $insert->bind_param("si", $name, $number);
                $insert->execute();
            }

            $student_course = $con->query("SELECT * FROM Student_Course WHERE SEmail='". $_SESSION['user-email']. "' AND CName='". $name. "' AND CNumber=". $number);
            //check if the student is already taking the course

            if($student_course->num_rows == 0) {
                $insert_student = $con->prepare("INSERT INTO Student_Course(SEmail, CName, CNumber) VALUES (?, ?, ?)");
                $insert_student->bind_param("ssi", $_SESSION['user-email'], $name, $number);
                $insert_student->execute();
                //if the student is not already taking the course, add them to the Student_Course table
            }

            header("Refresh:0");
        }
    ?>
</html>
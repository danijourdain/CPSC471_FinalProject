<!DOCTYPE html>

<html>
    <head>
        <title>Add Course</title>

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
            <a class="sidebar-link" href="to-do-list.php"> <div class="sidebar-tab">
                <div>To Do List</div>
            </div> </a>
            <a class="sidebar-link" href="assignments.html">
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
        
       <main>
            <div class="user-input-section">
                <form method="post">
                    <input class="course-input-box" type="text" name="name" placeholder="Course Name (ex. CPSC)"><br>
                    <input class="course-input-box" type="text" name="number" placeholder="Course Number (ex. 471)"><br>
                    <input class="add-course-button" type="submit" value="Add Course">
                </form>
            </div>
       </main>
    </body>


    <?php
        session_start();

        $name = $_POST["name"];
        $number = $_POST["number"];

        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        echo "hi";

        $course = $con->query("SElECT * FROM Course WHERE CName='". $name. "' AND CNumber=". $number);
        //check if the new course already exists in the course table

        // $course = $con->prepare("SELECT * FROM Course WHERE CName=? AND CNumber=?");
        // $course->bind_param("ss", $name, $number);
        // $course->exectute();
        // $course = $course->get_result();
        //also doesn't work for some reason :(((((

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
    ?>
</html>
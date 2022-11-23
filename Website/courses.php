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
            <div class="selected-sidebar-tab">
                <div>Courses</div>
            </div>
        </nav>

        <main>
            <a  href="add-course.php"> <button class="add-course-button">
                Add New Course
            </button></a>
        </main>
    </body>

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

        echo $courses->num_rows;

        foreach($courses as $c):?>
            <div class="course-box">
                <?php echo $c['CName']. "\t". $c['CNumber']; ?>
            </div>
        <?php endforeach;
        //print each course name and number the student is taking
        
    ?>
</html>
<!DOCTYPE html>

<html>
    <head>
        <title>To Do</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/to-do-list.css">
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
            <div class="selected-sidebar-tab">
                <div>To Do List</div>
            </div>
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
            <a class="sidebar-link" href="courses.html">
                <div class="sidebar-tab">
                    <div>Courses</div>
                </div>
            </a>
        </nav>

        <main>
            <a  href="add-task.php"> <button class="add-task-button">
                Add Task
            </button></a>

            <?php 
                session_start();
                $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
                //create database connection
                if ($con->connect_error) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $to_do = $con->query("SELECT * FROM To_Do_List WHERE SEmail='". $_SESSION['user-email']. "';");
                //for some reason this literally WILL NOT WORK when using a prepared statement
                //try and fix later I guess?

                if($to_do->num_rows == 0) {
                    $insert_todo = $con->prepare("INSERT INTO To_Do_List (SEmail) VALUES (?)");
                    $insert_todo->bind_param("s", $_SESSION['user-email']);
                    $insert_todo->execute();
                    //insert the new to do list into the table

                    $to_do = $con->query("SELECT * FROM To_Do_List WHERE SEmail='". $_SESSION['user-email']. "';");
                    //select the newly inserted tuple
                }
                else if($to_do->num_rows != 1){
                    die();
                    //something has gone wrong, end the program
                }

                $row = $to_do->fetch_array(MYSQLI_ASSOC);
                //echo "<br><br> List ID = ". $row['ListID'];
                $allTasks = 'SELECT t.Task FROM Tasks  AS t WHERE ListID = ' . $_SESSION['to-do-list-id'];
                $allTasks = mysqli_query($con, $allTasks);
                foreach($allTasks as $item){
                    echo $item['Task'];
                    echo '<br>';
                }
                $_SESSION['to-do-list-id'] = $row['ListID'];

            ?> 

        </main>
    </body>
</html>

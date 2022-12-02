<!DOCTYPE html>

<html>
    <head>
        <title>Assignments</title>

        <link rel="stylesheet" href="styles/general.css">
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
            <div class="selected-sidebar-tab">
                <div>Assignments</div>
            </div>
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
            <?php 
                session_start();
                $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
                //create database connection
                if ($con->connect_error) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
            ?>

            <h1> <?php
                echo "Viewing assignment ". $_POST['aName'];
            ?></h1>
                <?php
                    $view = $con->prepare("SELECT * FROM Assignment AS A
                                            WHERE A.Name_ = ?
                                            AND A.CName = ?
                                            AND A.CNumber = ?
                                            AND A.ListID = ?");
                    $view->bind_param("ssii", $_POST['aName'], $_POST['cname'], $_POST['cnum'], $_SESSION['to-do-list-id']);
                    $view->execute();
                    $view = $view->get_result();
                ?>
                <h2>
                    <?php foreach($view as $assign){
                            echo "Class: ". $assign['CName']. " ". $assign['CNumber']. "<br>";
                            echo "Assignment Weight: ".  $assign['Weight_']. "% <br>";
                            echo "Assignment Due Date: ". $assign['Due_Date']. "<br>";
                            if(!empty($assign['Descrip'])){
                                echo "Assignment Description: ". $assign['Descrip']. "<br>";
                            }
                            if(!empty($assign['Contact'])){
                                echo "Assignment Support Contact: ". $assign['Contact'];
                            }
                        }
                    ?>
                </h2>
        </main>
    </body>
</html>
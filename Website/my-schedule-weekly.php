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
            <a class="sidebar-link" href="to-do-list.html">
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
            <a class="sidebar-link" href="courses.html">
                <div class="sidebar-tab">
                    <div>Courses</div>
                </div>
            </a>
        </nav>

        <main>

        </main>
    </body>
</html>

<?php
    session_start();
    echo "hi " .$_SESSION['user-email']. "! Welcome to your schdule!";
?>
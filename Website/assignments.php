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

                $courses = $con->prepare("SELECT * FROM Course AS C, Student_Course AS S WHERE S.SEmail=? AND S.CName = C.CName AND C.CNumber = S.CNumber");
                $courses->bind_param("s", $_SESSION['user-email']);
                $courses->execute();
                $courses = $courses->get_result();
                ?>

                <?php if($courses->num_rows == 0): ?>
                <div class="card my-3 w-75">
                <div class="card-body text-center">
                    <p class="lead mt3"> Add a class first before adding assignements</p>
                </div>
                </div>
                <?php else: ?>
                    

                    <?php foreach($courses as $item): ?>
                        <h2>
                            <?php echo ($item['CName']. " " . $item['CNumber']); ?>
                        </h2>
                        <?php 
                            $CAssign = $con->prepare("SELECT * FROM Course AS C, Student_Course AS S, Assignment AS A WHERE S.SEmail=? AND S.CName = C.CName AND C.CNumber = S.CNumber AND S.CName = ? AND S.CNumber = ?");
                            $CAssign-> bind_param("ssi", $_SESSION['user-email'], $item['CName'], $item['CNumber']);
                            $CAssign-> execute();
                            $CAssign = $CAssign->get_result();
                        ?>
                        <?php if($CAssign->num_rows == 0): ?>
                        <p class="lead mt3"> No Assignments for this class yet</p>
                        

                        <?php else: ?>
                            <form method="post">
                            <?php foreach($CAssign as $assign): ?>
                                <p class="lead mt3"> <?php echo $iassign['Name_'] ?></p>
                                <input type="submit" name="Edit" value="Edit"> 
                                <input type="submit" name="Delete" value="Delete"> 
                            <?php endforeach; ?>
                            </form>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <form>
                        <input class="add-task-box" type="text" name="Name" placeholder="Assignment Name"><br>
                        <input class="add-task-box" type="text" name="Weight" placeholder="Weight"><br>
                        <input class="add-task-box" type="text" name="DueDate" placeholder="Due Date (mm/dd/yy)"><br>
                        <input class="add-task-box" type="text" name="Description" placeholder="Description (Optional)"><br>
                        <input class="add-task-box" type="text" name="Contact" placeholder="Contact (Optional)"><br>
                        <br>
                        <label for="courses"></label>
                        <select name="courses" id="courseNum">
                            <option value= "none" selected disabled hidden> Select a course </option>
                            <?php foreach($courses as $item): ?>
                                <option value=<?php echo ($item['CName']. " " . $item['CNumber']); ?>><?php echo ($item['CName']. " " . $item['CNumber']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
                        <input class="add-task-button" type="add" value="Add Assignment">
                    </form>
                <?php endif; ?>


                

        </main>
    </body>
</html>
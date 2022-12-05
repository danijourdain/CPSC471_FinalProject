<!DOCTYPE html>

<html>
    <head>
        <title>Assignments</title>

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/assignment.css">
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
            <a class="sidebar-link" href="exams.php">
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
                    
                <div class="content">
                    <div class="existing-assignments"><?php foreach($courses as $item): ?>
                        <div class="course-name">
                            <?php echo ($item['CName']. " " . $item['CNumber']); ?>
                        </div>
                        <?php 
                            $CAssign = $con->prepare("SELECT * FROM Course AS C, Student_Course AS S, completes_assignments AS A , assignment AS Assign
                                                        WHERE S.SEmail=? 
                                                        AND S.CName = C.CName AND C.CNumber = S.CNumber 
                                                        AND A.CName = ? AND A.CNumber = ? 
                                                        AND A.CName=C.CName AND A.CNumber =C.CNumber
                                                        AND A.SEmail = ?
                                                        AND A.AName = Assign.Name_
                                                        AND A.CName = Assign.CName AND A.CNumber = Assign.CNumber");
                            $CAssign-> bind_param("ssis", $_SESSION['user-email'], $item['CName'], $item['CNumber'], $_SESSION['user-email']);
                            $CAssign-> execute();
                            $CAssign = $CAssign->get_result();

                        ?>
                        <?php if($CAssign->num_rows == 0): ?>
                            <p class="lead mt3"> No Assignments for this class yet</p>
                        <?php else: ?>
                            <?php foreach($CAssign as $assign): ?>

                                <div class="course-box"><div class="assign-name">
                                <?php echo $assign['AName']. " Due on ". $assign['Due_Date'];?>
                                </div>

                                <div class="button-section"><form action="view-assignment.php" method="post">
                                <input type="hidden" name="cname" value="<?php echo $item['CName']?>"/>
                                <input type="hidden" name="cnum" value="<?php echo $item['CNumber']?>"/>
                                <input type="hidden" name="aName" value="<?php echo $assign['AName']?>"/>
                                <input class="edit-button" type="submit" value='View'>
                                </form></div>
                                <div class="button-section"><form action="delete-assignment.php" method="post">
                                <input type="hidden" name="cname" value="<?php echo $item['CName']?>"/>
                                <input type="hidden" name="cnum" value="<?php echo $item['CNumber']?>"/>
                                <input type="hidden" name="aName" value="<?php echo $assign['AName']?>"/>
                                <input class="edit-button" type="submit" value='Delete'>
                                </form></div>
                                </div>
                                <div class="separation-line"></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>

                    <div class="separation-bar"></div>

                    <div class="add-assignment-form">
                        <div class="table-header"> Add a new assignment: </div>
                        <form method="post">
                        <input class="add-task-box" type="text" name="Name" placeholder="Assignment Name"><br>
                        <input class="add-task-box" type="number" name="Weight" placeholder="Weight (percentage)"><br>
                        <label class="field-label" for="due">Due Date: </label>
                        <input class="date-field" type="date" name="due" placeholder="Due Date"><br>
                        <input class="add-task-box" type="text" name="Description" placeholder="Description (Optional)"><br>
                        <input class="add-task-box" type="text" name="Contact" placeholder="Contact (Optional)"><br><br>
                        <select class="dropdown-box" name="courses" id="courseNum">
                            <option value= "none" selected disabled hidden> Select a course </option>
                            <?php foreach($courses as $item): ?>
                                <option value= <?php echo ("'".$item['CName']. " " . $item['CNumber']."';"); ?>><?php echo ($item['CName']. " " . $item['CNumber']); ?></option>
                            <?php endforeach; ?> 
                        </select>
                        <br><br>
                        <input class="add-assignment-button" type="Submit" name="addTask" value="Add Assignment">
                    </form></div>
                <?php endif; ?>
                <?php if(!empty($_POST['addTask'])){
                        if(empty($_POST['Name'])){
                            echo "Assignment name is required";
                        }
                        else if(empty($_POST['Weight'])){
                            echo "Assignment weight is required";
                        }
                        else if(empty($_POST['due'])){
                            echo "Assignment due date is required";
                        }
                        else{
                            $course = explode(" ", $_POST['courses']);
                            $assignExists = $con->prepare("SELECT * FROM Assignment
                                                            WHERE Name_ = ?
                                                            AND CNumber = ?
                                                            AND CName = ?");
                            $assignExists->bind_param("sis", $_POST['Name'], $course[1], $course[0]);
                            $assignExists->execute();
                            $assignExists = $assignExists->get_result();
                            if($assignExists->num_rows == 0){
                                $task = $con->prepare("INSERT INTO Assignment (Name_, CNumber, CName, Weight_, Due_Date, Descrip, Contact, ListID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                $task->bind_param("sisisssi", $_POST['Name'], $course[1], $course[0], $_POST['Weight'], $_POST['due'], $_POST['Description'], $_POST['Contact'],$_SESSION['to-do-list-id']);
                                $task->execute();
                            }
                            $takes = $con->prepare("SELECT * FROM completes_assignments
                                                            WHERE SEmail = ?
                                                            AND AName = ?
                                                            AND CNumber = ?
                                                            AND CName = ?");
                            $takes->bind_param("ssis", $_SESSION['user-email'],$_POST['Name'], $course[1], $course[0]);
                            $takes->execute();
                            $takes = $takes->get_result();
                            if($takes->num_rows == 0){
                                $task = $con->prepare("INSERT INTO completes_assignments (SEmail, AName, CName, CNumber) VALUES (?, ?, ?, ?)");
                                $task->bind_param("sssi", $_SESSION['user-email'], $_POST['Name'], $course[0], $course[1]);
                                $task->execute();
                                echo "<meta http-equiv='refresh' content='0'>";
                            }
                            else{
                                echo "This assignment is already added for this class";
                            }
                            
                        }
                }

                ?>


                

        </main>
    </body>
</html>
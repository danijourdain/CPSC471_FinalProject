<!DOCTYPE html>

<html>
    <head>
        <title>Exams</title>

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
            <a class="sidebar-link" href="assignments.php">
                <div class="sidebar-tab">
                    <div>Assigments</div>
                </div>
            </a>
            <div class="selected-sidebar-tab">
                <div>Exams</div>
            </div>
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
                    <p class="lead mt3"> Add a class first before adding Exams</p>
                </div>
                </div>
                <?php else: ?>
                    
                <div class="content">
                    <div class="existing-assignments"><?php foreach($courses as $item): ?>
                        <h2>
                            <?php echo ($item['CName']. " " . $item['CNumber']); ?>
                        </h2>
                        <?php 
                            $CExam = $con->prepare("SELECT * FROM Course AS C, Student_Course AS S, Exam_Quiz AS  E
                                                        WHERE S.SEmail=? 
                                                        AND S.CName = C.CName AND C.CNumber = S.CNumber 
                                                        AND E.Course_Name = ? AND E.Course_Number = ? 
                                                        AND E.Course_Name=C.CName AND E.Course_Number =C.CNumber");
                            $CExam-> bind_param("ssi", $_SESSION['user-email'], $item['CName'], $item['CNumber']);
                            $CExam-> execute();
                            $CExam = $CExam->get_result();

                        ?>
                        <?php if($CExam->num_rows == 0): ?>
                            <p class="lead mt3"> No Exams for this class yet</p>
                        <?php else: ?>
                            <?php foreach($CExam as $exam): ?>

                                <div class="course-box"><div>
                                <?php echo $exam['Name_']. " On ". $exam['Date_']. " at ". $exam['StartTime'];?>
                                </div>

                                <div class="button-section"><form action="view-exams.php" method="post">
                                <input type="hidden" name="cname" value="<?php echo $item['CName']?>"/>
                                <input type="hidden" name="cnum" value="<?php echo $item['CNumber']?>"/>
                                <input type="hidden" name="aName" value="<?php echo $assign['Name_']?>"/>
                                <input class="edit-button" type="submit" value='Details'>
                                </form></div>
                                <div class="button-section"><form action="delete-exams.php" method="post">
                                <input type="hidden" name="cname" value="<?php echo $item['CName']?>"/>
                                <input type="hidden" name="cnum" value="<?php echo $item['CNumber']?>"/>
                                <input type="hidden" name="aName" value="<?php echo $assign['Name_']?>"/>
                                <input class="delete-button" type="submit" value='Delete'>
                                </form></div>
                                </div>
                                <div class="separation-line"></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                    <h2> Add a new Exam: </h2>
                    <form method="post">
                        <input class="add-task-box" type="text" name="Name" placeholder="Exam Name"><br>
                        <input class="add-task-box" type="number" name="Weight" placeholder="Weight (percentage)"><br>
                        <label class="field-label" for="due">Exam Date: </label>
                        <input class="date-field" type="date" name="due" placeholder="Due Date"><br>
                        <label class="field-label" for="STime">Exam Start: </label>
                        <input class="add-task-box" type="Time" name="STime" placeholder="Exam Start Time"><br>
                        <input class="add-task-box" type="number" name="Length" placeholder="Exam length (minutes)"><br>
                        <input class="add-task-box" type="text" name="Location" placeholder="Exam Location"><br>
                        <input class="add-task-box" type="text" name="Chapters" placeholder="Exam Topic (Optional)"><br><br>
                        <label for="courses"></label>
                        <select name="courses" id="courseNum">
                            <option value= "none" selected disabled hidden> Select a course </option>
                            <?php foreach($courses as $item): ?>
                                <option value= <?php echo ("'".$item['CName']. " " . $item['CNumber']."';"); ?>><?php echo ($item['CName']. " " . $item['CNumber']); ?></option>
                            <?php endforeach; ?> 
                        </select>
                        <br><br>
                        <input class="add-task-button" type="Submit" name="addTask" value="Add Assignment">
                    </form>
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
                            echo $course[0];
                            echo $course[1];
                            $task = $con->prepare("INSERT INTO Exam_Quiz(Name_, Course_Name, Course_Number, Weight_, Chapters, Hall, Date_, StartTime, Length_) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $task->bind_param("ssiissssi", $_POST['Name'], $course[0], $course[1], $_POST['Weight'], $_POST['Chapters'], $_POST['Location'], $_POST['due'], $_POST['STime'],$_POST['Length']);
                            $task->execute();
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                }

                if(!empty($_POST['Edit'])){
                    echo "hi";
                }
                ?>

        </main>
    </body>
</html>
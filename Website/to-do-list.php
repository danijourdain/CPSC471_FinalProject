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
                
                $email = $_SESSION['user-email'];
                $to_do = $con->prepare("SELECT * FROM To_Do_List WHERE SEmail=?");
                $to_do ->bind_param("s", $email);
                $to_do ->execute();
                $to_do = $to_do ->get_result();
                
                
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

                $id = $con->prepare("SELECT ListID FROM To_Do_List WHERE SEmail=?");
                $id ->bind_param("s", $email);
                $id ->execute();
                $id = $id ->get_result();
                foreach($id as $i) {
                    $_SESSION['to-do-list-id'] = $i['ListID'];
                }
                //set the listID for the session

            ?> 
            <?php
            $allTasks = $con->prepare("SELECT * FROM Tasks  AS t WHERE ListID = ? AND isDone = 0;");
            $allTasks -> bind_param("i", $_SESSION['to-do-list-id']);
           // $allTasks -> bindValue(1, $_SESSION['to-do-list-id'], PDO::PARAM_INT);
            //$allTasks -> bindValue(2, false, PDO::PARAM_BOOL);
            $allTasks -> execute();
            $allTasks = $allTasks->get_result();
            ?>
        <main>
            <h2>To Do List:</h2>
            <?php if($allTasks->num_rows == 0): ?>
                <div class="card my-3 w-75">
                <div class="card-body text-center">
                    <p class="lead mt3"> There are no items on your to do list</p>
                </div>
                </div>
            <?php else: ?>
            <form method="post">
            <?php foreach($allTasks as $item): ?>
                <?php if(!$item['isDone']): ?>
                <div class="card my-3 w-75">
                    <div class="card-body text-center">
                        
                            <input class="task-checkbox" id="task-checkbox" type="checkbox" name="chk1[ ]" value=<?php echo "'". $item['Task']. "';"; ?>>
                            <label for="task-checkbox"> <?php echo $item['Task']; ?></label><br>
                            
                        
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
                <input type="submit" name="Submit" value="Complete Selected Tasks"> 
            </form>
            <?php endif; ?>
            <form method="post">
                <input class="add-task-box" type="text" name="task" placeholder="Task Name"><br>
                <input class="add-task-button" type="submit" value="Add Task">
            </form>
    <?php
        $allTasks = 'SELECT t.Task FROM Tasks AS t WHERE ListID = ' . $_SESSION['to-do-list-id'];
        $allTasks = mysqli_query($con, $allTasks);
        $dupFlag = 0;
        if(!empty($_POST['task'])){
            foreach($allTasks as $item){
                if(strtolower($item['Task']) == strtolower($_POST['task'])){
                    $dupFlag = 1;
                    echo "Duplicate Entry";
                    
                }
            }
            if(!$dupFlag){
                $allTasks = mysqli_fetch_all($allTasks, MYSQLI_ASSOC);
                $task = $con->prepare("INSERT INTO Tasks (ListID, Task) VALUES (?, ?)");
                $task->bind_param("ss", $_SESSION['to-do-list-id'], $_POST['task']);
                $task->execute();
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }  
        if (!empty($_POST['Submit']) && $_POST['Submit'] == "Complete Selected Tasks"){  
            if(!empty($_POST['chk1'])){
                foreach($_POST['chk1'] as $selected){
                    //echo $selected . " has been completed!";
                    $complete = $con->prepare("DELETE FROM Tasks WHERE ListID = ? AND Task = ?");
                    $complete ->bind_param("is", $_SESSION['to-do-list-id'], $selected);
                    $complete ->execute();
                    echo "<meta http-equiv='refresh' content='0'>";
                }
               
            }
        }

    ?>
        </main>
    </body>
</html>
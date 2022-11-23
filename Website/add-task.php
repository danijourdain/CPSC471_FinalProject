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
            <a class="selected-link" href="to-do-list.php"> <div class="selected-sidebar-tab">
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
            <a class="sidebar-link" href="courses.php">
                <div class="sidebar-tab">
                    <div>Courses</div>
                </div>
            </a>
        </nav>
        
        
        </main>
    </body>

    <?php
        session_start();
        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    ?>
    <?php
        $allTasks = 'SELECT t.Task FROM Tasks  AS t WHERE ListID = ' . $_SESSION['to-do-list-id'];
        $allTasks = mysqli_query($con, $allTasks);
        ?>
        <main>
            <h2>To Do List:</h2>
            <?php if(empty($allTasks)): ?>
                <p class="lead mt3"> There are no items on your to do list</p>
            <?php endif; ?>

            <?php foreach($allTasks as $item): ?>
                <div class="card my-3 w-75">
                    <div class="card-body text-center">
                        <!-- <?php echo $item['Task']; ?>
                        <input type="checkbox" name="checkboc_name" values="checkbox_value"> -->
                        <form method="post">
                            <input class="task-checkbox" id="task-checkbox" type="checkbox" name="checkbox_name" values="checkbox_value">
                            <label for="task-checkbox"> <?php echo $item['Task']; ?></label><br>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <form method="post">
                <input class="add-task-box" type="text" name="task" placeholder="Task Name"><br>
                <input class="add-task-button" type="submit" value="Add Task">
            </form>
    <?php
        $allTasks = 'SELECT t.Task FROM Tasks  AS t WHERE ListID = ' . $_SESSION['to-do-list-id'];
        $allTasks = mysqli_query($con, $allTasks);
        $dupFlag = 0;
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
        }
    ?>
</html>

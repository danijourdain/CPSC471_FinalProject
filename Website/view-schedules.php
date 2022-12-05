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
        </header>


        <main>

        </main>
    </body>
    <?php
            session_start();
           echo "hi " .$_SESSION['user-email']. "! Welcome to your schedule viewer!";
    ?>
    <div class="table-header">
        These are all the Schedules you have access to
    </div>

    <div>
        <div class="separation-line"></div>

        <div>
            <div class="separation-line"></div>
            <?php
            
            $con = new mysqli("localhost", "admin", "cpsc471", "471_Final_Project");
            //create new database connection

            if($con->connect_error) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $email = $_SESSION['user-email'];
            $guest = $con->prepare("SELECT * FROM viewer AS C WHERE C.Email=?");
            $guest->bind_param("s", $_SESSION['user-email']);
            $guest->execute();
            $guest = $guest->get_result();

            foreach ($guest as $g) {
                $schedule = $con->prepare("SELECT * FROM schedule_ AS C WHERE C.StudentEmail=? AND C.ID = ?");
                $schedule->bind_param("si", $g['SEmail'], $g['SchedID']);
                $schedule->execute();
                $schedule = $schedule->get_result();
                //get all courses the student is currently taking from the database
            
                // $i = 0;
                // $_SESSION['cnames'] = array();
                // $_SESSION['cnums'] = array();
            
                foreach ($schedule as $c): ?>
                <div class="Schedule-box">
                    <div>
                        <?php echo $c['StudentEmail']."'s ". $c['SemName'] . "\t" . $c['Year_']; ?>
                    </div>

                </div>
                <div class="button-section"><form action="download-schedule-viewer.php" method="post">
                        <input type="hidden" name="Semester" value="<?php echo $c['SemName'] ?>"/>
                        <input type="hidden" name="Year" value="<?php echo $c['Year_'] ?>"/>
                        <input type="hidden" name="ID" value="<?php echo $c['ID'] ?>"/>
                        <input type="hidden" name="Email" value="<?php echo $c['StudentEmail'] ?>"/>
                        <input class="download-button" type="submit" value='Download Schedule'>
                    </form></div>
                </div>
                <div class="separation-line"></div>
            <?php endforeach;
                //print each course name and number the student is taking
            }
        ?></div>

<div class="other-button-section">
            <!-- add course section -->
            <div class="input-area"><form method="post" action="add-schedule-viewer.php">
                        <input class="text-field" type="text" name="Femail" placeholder="Friend Email"><br>
                        <input class="text-field" type="number" name="ID" placeholder="Schedule ID"><br>
                        <input type="hidden" name="email" value="<?$email?>"/>
                        <input class="submit-button" type="submit" value="Submit Information">
                    </form></div>

            

</html>
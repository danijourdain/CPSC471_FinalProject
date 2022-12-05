<!DOCTYPE html>
    <html>
        <head>
            <title>Create Account</title>
            <link rel="stylesheet" href="styles/general.css">
            <link rel="stylesheet" href="styles/new-user.css">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        </head>
        <body>
        <div class="input-area">
            <form method="post" action="add-viewer.php">
                <input class="text-field" type="text" name="Femail" placeholder="Friend Email"><br>
                <input class="text-field" type="text" name="ID" placeholder="Schedule ID"><br>
                <input type="hidden" name="email" value="<?$email?>"/>
                <input class="submit-button" type="submit" value="Submit Information">
            </form></div>
        </body>
    </html>

<?php 
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    
    $insert_viewer = $con->prepare("INSERT INTO Viewer (Email, SEmail, SchedID) VALUES (?, ?, ?)");
    $insert_viewer->bind_param("ssi", $_SESSION['user-email'], $_POST['Femail'], $_POST['ID']);
    $insert_viewer->execute();
    header("Location: view-schedules.php");
    die();
    //move to the weekly schedule page
?>


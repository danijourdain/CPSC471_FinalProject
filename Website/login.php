<?php
    $email = $_POST["email"];
    $password = $_POST["password"];

    session_start();
    $_SESSION['user-email'] = $email;

    $con=mysqli_connect("localhost","cpsc471","cpsc471","test-adding-user");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con, "SELECT * FROM Users where Email='".$email. "' AND Password_ = '" .$password. "';");

    if(mysqli_num_rows($result) > 1) {
        echo "error! too many rows returned!";
        die();
    }

    while($row = mysqli_fetch_array($result)) {
        echo $row['Email']. "\t". $row['Password_']. "<br>";
    }

    header("Location: my-schedule-weekly.php");
    die();
?>
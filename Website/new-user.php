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
        <main>
            <div class="center-box">
                <div class="box-header">Create New User</div>
                <div class="user-input-section">
                    <form method="post">
                        <input class="input-box" type="text" name="fname" placeholder="First Name"><br>
                        <input class="input-box" type="text" name="lname" placeholder="Last Name"><br>
                        <div>
                            <select class="dropdown-box" id="user-type" name="user-type">
                                <option value="none" selected disabled hidden>Select User Type</option>
                                <option value="student">Student</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <input class="input-box" type="text" name="email" placeholder="E-mail"><br>
                        <input class="input-box" type="password" name="password1" placeholder="Password"><br>
                        <input class="input-box" type="password" name="password2" placeholder="Confirm Password"><br>
                        <input class="create-user-button" type="submit" value="Create User">
                    </form>
                </div>
                <div class="back-button-section">
                    <a href="index.php"><button class="back-button">
                        Back to Login
                    </button></a>
                </div>
            </div>
        </main>
    </body>


    <?php
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $type = $_POST["user-type"];
        $email = $_POST["email"];
        $password1 = hash('md5', $_POST["password1"]);
        $password2 = hash('md5', $_POST["password2"]);
        //get the user input using POST

        session_start();
        $_SESSION['user-email'] = $email;
        $_SESSION['user-fname'] = $fname;
        $_SESSION['user-lname'] = $lname;
    
        $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
        //create database connection

        if ($con -> connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $check_email = $con->prepare("SELECT * FROM User_ WHERE Email=?");
        $check_email->bind_param("s", $email);
        $check_email->execute();;
        //check if a user already exists with this email

        $email_result = $check_email->get_result();

        if($email_result->num_rows != 0) {
            echo '<script>alert("Email already exists for this user!")</script>';
            //alert the user if this email is already in use
        }
        else if($fname != null && $lname !=null && $type != null &&
            $email != null && $password1 != null && $password1 == $password2) {

            $create_user = $con->prepare("INSERT INTO User_ (Email, FName, LName, Password_, UserType) VALUES (?, ?, ?, ?, ?)");
            $create_user->bind_param("sssss", $email, $fname, $lname, $password1, $type);
            $create_user->execute();
            //create the new user tuples

            if($type == 'student') {
                header("Location: my-schedule-weekly.php");
                die();
                //move to the weekly schedule page
            }
            else {
                header("Location: view-schedules.php");
                die();
                //move to the weekly schedule page
            }
         }
        else if ($password1 != $password2) {
            echo '<script>alert("Passwords must match!")</script>';
            //alert the user that their passwords do not match
        }
        else {
            echo '<script>alert("Please fill in all fields")</script>';
            //alert the user that they must fill in all fields
        }

        $con->close();
    ?>
</html>
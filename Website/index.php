<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/index.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    </head>

    <body>
        <main>
            <div class="center-login-box">
                <div class="login-box-header">Log In</div>
                <div class="user-input-login-section">
                    <form method="post">
                        <input class="login-input-box" type="text" name="email" placeholder="E-mail"><br>
                        <input class="login-input-box" type="password" name="password" placeholder="Password"><br>
                        <input class="login-button" type="submit" name="Login" value="Login">
                    </form>
                </div>
                <div class="other-login-links-section">
                    <div class="new-user-link">
                        <a href = "new-user.php">New User?</a>
                    </div>
                    <div class="forgot-password-link">
                        <a href = "forgot-password.php">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </main>
    </body>


    <?php
        //require_once("zapcallib.php");
        //for some reason mine does not work with this line
        if(!empty($_POST['Login'])){
            if(empty($_POST["email"]) || empty($_POST["password"])) {
                echo '<script>alert("Must fill in all fields!")</script>';
                die();
                //if there is no match, give the user an error message
            }

        $email = $_POST["email"];
        $password = hash('md5', $_POST["password"]);
        //get the user input using POST

        session_start();
        $_SESSION['user-email'] = $email;

        $con = new mysqli("localhost","select","cpsc471","471_Final_Project");
        //create database connection

        if ($con->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $select_user = $con->prepare("SELECT * FROM User_ WHERE Email=? AND Password_=?");
        $select_user->bind_param("ss", $email, $password);
        $select_user->execute();
        //use a prepared statment to check username and passwords


        $result = $select_user->get_result();
        $select_user->close();
        //get the result and close the statements

        if($result->num_rows > 1) {
            echo "error! too many rows returned!";
            die();
            //if there is are multiple results, something has gone wrong, end the program
        }
        else if($result->num_rows == 1) {
            $res = $result->fetch_array();
            if($res['UserType'] == 'student') {
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
        else{
            echo '<script>alert("Incorrect E-mail or Password!")</script>';
            //if there is no match, give the user an error message
        }
        $con->close();
        //close the conncection to the database
    }
    ?>
</html>

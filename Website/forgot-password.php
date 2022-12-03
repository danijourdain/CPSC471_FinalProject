<!DOCTYPE html>

<html>
    <head>
        <title>Reset Password</title>
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/reset-password.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="center-box">
                <div class="box-header">Reset Password</div>
                <div class="user-input-section">
                    <form method="post">
                        <input class="input-box" type="text" name="email" placeholder="E-mail"><br>
                        <input class="input-box" type="password" name="password1" placeholder="New Password"><br>
                        <input class="input-box" type="password" name="password2" placeholder="Confirm Password"><br>
                        <input class="change-password-button" type="submit" name="change" value="Change Password">
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
    if(!empty($_POST['change'])){
        if(empty($_POST["email"]) || empty($_POST["password1"]) || empty($_POST["password2"])) {
            echo '<script>alert("Must fill in all fields!")</script>';
            die();
            //if there is no match, give the user an error message
        }

        $email = $_POST["email"];
        $password1 = hash('md5', $_POST["password1"]);
        $password2 = hash('md5', $_POST["password2"]);
        //get user input using POST

        $connection = new mysqli("localhost", "admin", "cpsc471", "471_Final_Project");
        //create database connection 

        if ($con -> connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        if ($password1 != $password2) {
            echo '<script>alert("Passwords must match!")</script>';
            //alert the user that their passwords do not match
        }
        else {
            $check_email = $connection->prepare("SELECT * FROM User_ WHERE Email=?");
            $check_email->bind_param("s", $email);
            $check_email->execute();
            //check if a user already exists with this email
            $email_result = $check_email->get_result();

            if($email_result->num_rows == 0) {
                echo '<script>alert("No user with this email")</script>';
            }
            else {
                $statement = $connection->prepare("UPDATE User_ SET Password_=? WHERE Email=?");
                $statement->bind_param("ss", $password1, $email);
                $statement->execute();
                //update the password in the database
    
                header("Location: index.php");
                die();
                //return to the login page
            }
        }

        $con->close();
    }

    ?>
</html>
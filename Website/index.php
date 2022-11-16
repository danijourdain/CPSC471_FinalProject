<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/login.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    </head>

    <body>
        <main>
            <div class="center-login-box">
                <div class="login-box-header">Log In</div>
                <div class="user-input-login-section">
                    <form action="add.php" method="post">
                        <input class="login-input-box" type="text" name="email" placeholder="E-mail"><br>
                        <input class="login-input-box" type="password" name="password" placeholder="Password"><br>
                        <input class="login-button" type="submit" value="Login">
                    </form>
                </div>
                <div class="other-login-links-section">
                    <div class="new-user-link">
                        <a href = "new-user.php">New User?</a>
                    </div>
                    <div class="forgot-password-link">
                        <a href = "forgot-password.html">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>


<!--<div class="login-button-section">
    <a href="my-schedule-weekly.html"><button class="login-button">
        Log In
    </button></a>
</div>--> 
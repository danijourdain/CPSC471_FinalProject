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
                    <form action="add-user.php" method="post">
                        <input class="input-box" type="text" name="email" placeholder="E-mail"><br>
                        <input class="input-box" type="password" name="password1" placeholder="Password"><br>
                        <input class="input-box" type="password" name="password2" placeholder="Confirm Password"><br>
                        <input class="create-user-button" type="submit" value="Create User">
                    </form>
                </div>
                <div class="back-button-section">
                    <a href="index.html"><button class="back-button">
                        Back to Login
                    </button></a>
                </div>
            </div>
        </main>
    </body>
</html>
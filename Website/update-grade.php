<?php
    session_start();
    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $update = $con->prepare("UPDATE Student_Course SET Grade=? WHERE SEmail=? AND CName=? AND CNumber=?");
    $update->bind_param("issi", $_POST['grade'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
    $update->execute();
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
<?php
    session_start();
    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $delete = $con->prepare("DELETE FROM Class_Meeting WHERE MeetingName=? AND SEmail=? AND Course_Name=? AND Course_Number=?");
    $delete->bind_param("sssi", $_POST['name'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number']);
    $delete->execute();

    ?>
    
<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
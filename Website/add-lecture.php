<?php 
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $insert = $con->prepare("INSERT INTO Lecture(MeetingName_Lec, SEmail, CName, CNumber, Learning_Obj, Ch_discussed, InstructorName) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssisss", $_SESSION['meeting-name'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['objective'], $_POST['chapter'], $_POST['instructor']);
    $insert->execute();
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
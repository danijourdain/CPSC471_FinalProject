<?php 
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    echo "??";

    $date = $_POST['due']?: null;

    $insert = $con->prepare("INSERT INTO Lab(MeetingName_Lab, SEmail, CName, CNumber, Lab_Topic, Due_Date, TA_Name) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssisss", $_SESSION['meeting-name'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['topic'], $due, $_POST['ta']);
    $insert->execute();
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
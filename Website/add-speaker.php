<?php
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if(!empty($_POST['name']) && !empty($_POST['org']) && !empty($_POST['creds'])) {
        $insert = $con->prepare("INSERT INTO Speaker(MeetingName_Sp, SEmail, CName, CNumber, Name_, Organization, Credentials) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssisss", $_POST['mname'], $_SESSION['user-email'], $_SESSION['course-name'], $_SESSION['course-number'], $_POST['name'], $_POST['org'], $_POST['creds']);
        $insert->execute();
    }
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
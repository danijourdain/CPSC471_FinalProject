<?php
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if(!empty($_POST['date'])) {
        $insert_date = $con->prepare("INSERT INTO Group_Meeting_Date(GroupID, GroupName, Date_) VALUES(?, ?, ?)");
        $insert_date->bind_param("iss", $_POST['id'], $_POST['gname'], $_POST['date']);
        $insert_date->execute();
    }
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
<?php 
    session_start();
    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $delete = $con->prepare("DELETE FROM Attends_Group_Meeting WHERE SEmail=? AND MeetingID=? AND GroupName=?");
    $delete->bind_param("sis", $_SESSION['user-email'], $_POST['id'],$_POST['name']);
    $delete->execute();

    $check_meeting = $con->prepare("SELECT * FROM Attends_Group_Meeting WHERE MeetingID=? AND GroupName=?");
    $check_meeting->bind_param("si", $_SESSION['course-name'], $_SESSION['course-number']);
    $check_meeting->execute();
    $check_meeting = $check_meeting->get_result();

    if($check_meeting->num_rows == 0) {
        $delete = $con->prepare("DELETE FROM Group_Meeting WHERE ID=? AND Name_=?");
        $delete->bind_param("is", $_POST['id'], $_POST['name']);
        $delete->execute();
        //if there are no students taking the course, delete the course from the Course table
    }
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
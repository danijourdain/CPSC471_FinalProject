<?php
    session_start();

    $con = new mysqli("localhost","admin","cpsc471","471_Final_Project");
    //create database connection

    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if(!empty($_POST['gname'])) {
        if(empty($_POST['id'])) {
            $meeting = $con->prepare("INSERT INTO Group_Meeting(Name_, CName, CNumber) VALUES (?, ?, ?)");
            $meeting->bind_param("ssi", $_POST['gname'], $_SESSION['course-name'], $_SESSION['course-number']);
            $meeting->execute();
        }

        $get_id = $con->prepare("SELECT ID FROM Group_Meeting WHERE Name_=? AND CName=? AND CNumber=?");
        $get_id->bind_param("ssi", $_POST['gname'], $_SESSION['course-name'], $_SESSION['course-number']);
        $get_id->execute();
        $get_id = $get_id->get_result();

        foreach($get_id as $g) {
            $id = $g['ID'];
        }

        $student = $con->prepare("SELECT * FROM Attends_Group_Meeting WHERE SEmail=? AND MeetingID=? AND GroupName=?");
        $student->bind_param("sis", $_SESSION['user-email'], $id, $_POST['gname']);
        $student->execute();
        $student = $student->get_result();

        if($student->num_rows == 0) {
            $insert_student = $con->prepare("INSERT INTO Attends_Group_Meeting(MeetingID, GroupName, SEmail) VALUES(?, ?, ?)");
            $insert_student->bind_param("iss", $id, $_POST['gname'], $_SESSION['user-email']);
            $insert_student->execute();
        }
    }
?>

<form id="form" action="edit-course.php" method="post">
    <input type="hidden" name="cname" value="<?php echo $_SESSION['course-name'];?>"/>
    <input type="hidden" name="cnum" value="<?php echo $_SESSION['course-number'];?>"/>
</form>

<script type="text/javascript"> 
    document.getElementById("form").submit();
</script>
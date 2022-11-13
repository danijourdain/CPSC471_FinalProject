--all empty quotation marks indicate the value will be set by a user input

DELETE FROM Assignment WHERE Name_ = "" AND CNumber =  AND CName = "";

DELETE FROM Group_Meeting WHERE ID = ;

DELETE FROM Tasks WHERE Task = "" AND ListID = (SELECT ListID from To_Do_List WHERE Curr_User.StuEmail = StuEmail);

DELETE FROM COURSE WHERE Cname = "" AND CNumber = "";

DELETE FROM Exam_Quiz WHERE Cname = "" AND CNumber = "" AND Name_ = "";

DELETE FROM Class_Meeting WHERE MeetingName = "";

DELETE FROM Student_Course where Cname = "" AND CNumber = "" AND SEmail = ""

DELETE FROM Schedule WHERE ID = ;

DELETE FROM STUDENT WHERE Email = "";

DELETE FROM Viewer WHERE Email = "";


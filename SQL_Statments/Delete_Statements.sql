DELETE FROM Assignment WHERE Name_ = "" AND CNumber =  AND CName = "";

DELETE FROM Group_Meeting WHERE ID = ;

DELETE FROM Class_Meeting WHERE MeetingName = "";

-- add cascades to avoid issues

DELETE FROM Tasks WHERE Task = "" AND ListID = (SELECT ListID from To_Do_List WHERE Curr_User.StuEmail = StuEmail);

DELETE FROM COURSE WHERE Cname = userInputName AND CNumber = userInputNum;

DELETE FROM Exam_Quiz WHERE Cname = userInputName AND CNumber = userInputNum AND Name_ = userInputExName;

DELETE FROM Class_Meeting WHERE MeetingName = "";

DELETE FROM Schedule WHERE ID = ;

DELETE FROM STUDENT WHERE Email = "";

DELETE FROM Viewer WHERE Email = "";


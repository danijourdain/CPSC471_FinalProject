DELETE FROM completes_assignments WHERE SEmail = ? AND AName = ? AND CNumber = ? AND CName = ?

DELETE FROM Assignment WHERE Name_ = ? AND CNumber = ? AND CName = ?

DELETE FROM Student_Course WHERE SEmail=? AND CName=? AND CNumber=?

DELETE FROM Course WHERE CName=? AND CNumber=?

DELETE FROM Group_Meeting_Date WHERE GroupID=? AND GroupName=?

DELETE FROM student_exam WHERE SEmail = ? AND EQName = ? AND Course_Number = ? AND Course_Name = ?

DELETE FROM exam_quiz WHERE Name_ = ? AND Course_Number = ? AND Course_Name = ?

DELETE FROM Attends_Group_Meeting WHERE SEmail=? AND MeetingID=? AND GroupName=?

DELETE FROM Group_Meeting WHERE ID=? AND Name_=?

DELETE FROM Class_Meeting WHERE MeetingName=? AND SEmail=? AND Course_Name=? AND Course_Number=?

DELETE FROM schedule_ WHERE StudentEmail=? AND ID=? AND SemName=?

DELETE FROM Course WHERE CName=? AND CNumber=?

DELETE FROM Tasks WHERE ListID = ? AND Task = ?
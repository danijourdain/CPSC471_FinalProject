SELECT * FROM Course WHERE CName=? AND CNumber=?

SELECT * FROM Section WHERE CName=? AND CNumber=? AND LectureSection=? AND Semester=? AND ID=?

SELECT * FROM Student_Course WHERE SEmail=? AND CName=? AND CNumber=?

SELECT ID FROM Group_Meeting WHERE Name_=? AND CName=? AND CNumber=?

SELECT * FROM Attends_Group_Meeting WHERE SEmail=? AND MeetingID=? AND GroupName=?

SELECT * FROM schedule_ WHERE StudentEmail=? AND SemName=? AND Year_=?

SELECT t.Task FROM Tasks  AS t WHERE ListID = ' . $_SESSION['to-do-list-id']'

SELECT * FROM Course AS C, Student_Course AS S WHERE S.SEmail=? AND S.CName = C.CName AND C.CNumber = S.CNumber

SELECT * FROM Course AS C, Student_Course AS S, completes_assignments AS A , assignment AS Assign
                                                        WHERE S.SEmail=? 
                                                        AND S.CName = C.CName AND C.CNumber = S.CNumber 
                                                        AND A.CName = ? AND A.CNumber = ? 
                                                        AND A.CName=C.CName AND A.CNumber =C.CNumber
                                                        AND A.SEmail = ?
                                                        AND A.AName = Assign.Name_
                                                        AND A.CName = Assign.CName AND A.CNumber = Assign.CNumber

SELECT * FROM Assignment WHERE Name_ = ? AND CNumber = ? AND CName = ?

SELECT * FROM completes_assignments WHERE SEmail = ? AND AName = ? AND CNumber = ? AND CName = ?

SELECT * FROM Course AS C, Student_Course AS S WHERE S.SEmail=? AND S.CName = C.CName AND C.CNumber = S.CNumber

SELECT * FROM schedule_ WHERE StudentEmail = ?

SELECT * FROM completes_assignments WHERE AName = ? AND CNumber = ? AND CName = ?

SELECT * FROM Student_Course WHERE CName=? AND CNumber=?

SELECT * FROM student_exam WHERE EQName = ? AND Course_Number = ? AND Course_Name = ?

SELECT * FROM Attends_Group_Meeting WHERE MeetingID=? AND GroupName=?

SELECT * FROM Student_Course WHERE CName=? AND CNumber=?

SELECT * FROM schedule_ WHERE StudentEmail = ? AND SemName = ? AND ID = ?

SELECT * FROM class_meeting AS C,  section AS S WHERE C.SEmail = ? AND S.Semester = ? AND S.ID = ? AND C.Course_Name  = S.CName  AND C.Course_Number = CNumber

SELECT * FROM class_meeting WHERE MeetingName = ?

SELECT * FROM scheduled_time_slot WHERE MeetingName_ = ?

SELECT * FROM exam_quiz AS C,  student_exam AS S WHERE S.SEmail = ?  AND C.Course_Name   = S.Course_Name   AND C.Course_Number  = S.Course_Number  AND C.Name_ = S.EQName

SELECT * FROM exam_quiz WHERE Name_ = ?

SELECT Grade FROM Student_Course WHERE SEmail=? AND CName=? AND CNumber=?

SELECT c.* FROM Student_Course AS s, Class_Meeting AS c WHERE s.SEmail=? AND c.Course_Name=s.CName AND c.Course_Number=s.CNumber AND s.SEmail=c.SEmail AND s.CName=? AND s.CNumber=?

SELECT G.* FROM Group_Meeting AS G, Attends_Group_Meeting AS A WHERE G.ID=A.MeetingID AND G.Name_=A.GroupName AND A.SEmail=? AND G.CName=? AND G.CNumber=?

SELECT * FROM schedule_ WHERE StudentEmail=? AND Year_ = ? AND SemName = ? 

SELECT * FROM Course AS C, Student_Course AS S WHERE S.SEmail=? AND S.CName = C.CName AND C.CNumber = S.CNumber

SELECT * FROM Course AS C, Student_Course AS S, student_exam AS E, exam_quiz as Q
                                                        WHERE S.SEmail=? 
                                                        AND S.CName = C.CName AND C.CNumber = S.CNumber 
                                                        AND E.Course_Name = ? AND E.Course_Number = ? 
                                                        AND E.Course_Name=C.CName AND E.Course_Number =C.CNumber
                                                        AND E.SEmail = ?
                                                        AND E.Course_Name = Q.Course_Name AND E.Course_Number = Q.Course_Number
                                                        AND E.EQName = Q.Name_

SELECT * FROM exam_quiz WHERE Name_ = ? AND Course_Number = ? AND Course_Name = ?

SELECT * FROM student_exam WHERE SEmail = ? AND EQName = ? AND Course_Number = ? AND Course_Name = ?

SELECT * FROM User_ WHERE Email=?

SELECT * FROM User_ WHERE Email=? AND Password_=?

SELECT * FROM schedule_ AS C WHERE C.StudentEmail=?

SELECT * FROM User_ WHERE Email=?

SELECT * FROM To_Do_List WHERE SEmail=?

SELECT * FROM To_Do_List WHERE SEmail='". $_SESSION['user-email']'

SELECT ListID FROM To_Do_List WHERE SEmail=?

SELECT * FROM Tasks  AS t WHERE ListID = ? AND isDone = 0;

SELECT t.Task FROM Tasks AS t WHERE ListID = ' . $_SESSION['to-do-list-id']'

SELECT A.AName FROM completes_assignments AS A WHERE SEmail = ?

SELECT * FROM Assignment AS A, completes_assignments AS C
                                            WHERE A.Name_ = ? AND A.Name_ = C.AName
                                            AND A.CName = ? AND A.CName = C.CName
                                            AND A.CNumber = ? AND A.CNumber = C.CNumber
                                            AND C.SEmail = ?

SELECT * FROM exam_quiz AS A, student_exam AS E
                                            WHERE A.Name_ = ?
                                            AND A.Course_Name = ? AND A.Course_Name = E.Course_Name
                                            AND A.Course_Number = ? AND A.Course_Number = E.Course_Number
                                            AND E.SEmail = ?
                                            AND A.Name_ = E.EQName
                    
SELECT * FROM Group_Meeting_Date WHERE GroupID=? AND GroupName=?

SELECT * FROM Class_Meeting WHERE SEmail=? AND Course_Name=? AND Course_Number=? AND MeetingName=?

SELECT * FROM Scheduled_Time_Slot WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_=?

SELECT * FROM Lab WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_Lab=?

SELECT * FROM Lecture WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_Lec=?

SELECT * FROM Tutorial WHERE SEmail=? AND CName=? AND CNumber=? AND MeetingName_Tut=?

SELECT * FROM Speaker WHERE MeetingName_Sp=? AND SEmail=? AND CName=? AND CNumber=?

SELECT * FROM viewer AS C WHERE C.Email=?

SELECT * FROM schedule_ AS C WHERE C.StudentEmail=? AND C.ID = ?
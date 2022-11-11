--all empty quotation marks indicate user input will be used

SELECT Password_ FROM Admin WHERE Email="";
SELECT Password_ FROM User WHERE Email="";
--both of these are used to verify login information

SELECT  S.ID
FROM    Schedule AS S, Viewer AS V
WHERE   V.SchedID = S.ID;
--get all schedules the viewer has access to

SELECT  Sc.ID
FROM    Schedule AS Sc, Student as St
WHERE   St.StudentEmail = S.Email;
--get the student's schedule(s)

SELECT  C.CName, Se.LectureSection, Le.Semester
FROM    Course AS C, Student_Takes AS ST, Student AS S, Section AS Se
WHERE   C.CName = ST.CName AND S.Email = ST.StuEmail AND Se.CName = C.CName;

SELECT  A.Name, A.Weight, A.Due_Date, A.Descrip, A.Contact
FROM    Assignment AS A, Completes_Assignmetns AS CA, Student AS S,
WHERE   A.Name = CA.Name AND A.CName = CA.CName AND S.Email = CA.SEmail;

SELECT  E.Name, E.Weight, E.Chapters, E.Hall, E.Date, E.Length_
FROM    Exam_Quiz AS E, Student_Exam AS SE, Student AS S
WHERE   E.Name = SE.Name AND E.CName = SE.CName AND S.Email = SE.SEmail;

SELECT  C.MeetingName, C.Room#, C.Topic, C.CName, L.Learning_Obj, L.Ch_dicussed, STS.Dayofweek, STS.TimeOfDay, STS.Frequency
FROM    Class_Meeting AS C, Lecture AS L, Course AS Co, Attends_Class AS AC, Student AS S, Scheduled_Time_Slot AS STS
WHERE   C.CName = Co.CName AND L.MeetingName = C.MeetingName AND AC.CMeetingName = C.MeetingName 
        AND AC.SEmail = S.Email AND STS.MeetingName = C.MeetingName;

SELECT  C.MeetingName, C.Room#, C.Topic, C.CName, L.LabTopic, L.Due_Date, L.TA_Name, STS.Dayofweek, STS.TimeOfDay, STS.Frequency
FROM    Class_Meeting AS C, Lab AS L, Course AS Co, Attends_Class AS AC, Student AS S, Scheduled_Time_Slot AS STS
WHERE   C.CName = Co.CName AND L.MeetingName = C.MeetingName AND AC.CMeetingName = C.MeetingName 
        AND AC.SEmail = S.Email AND STS.MeetingName = C.MeetingName;

SELECT  C.MeetingName, C.Room#, C.Topic, C.CName, T.TA_Name, STS.Dayofweek, STS.TimeOfDay, STS.Frequency
FROM    Class_Meeting AS C, Tutorial AS T, Course AS Co, Attends_Class AS AC, Student AS S, Scheduled_Time_Slot AS STS
WHERE   C.CName = Co.CName AND T.MeetingName = C.MeetingName AND AC.CMeetingName = C.MeetingName 
        AND AC.SEmail = S.Email AND STS.MeetingName = C.MeetingName;

SELECT  C.MeetingName, C.Room#, C.Topic, C.CName, Sp.Name, Sp.Organization, Sp.Credentials, STS.Dayofweek, STS.TimeOfDay, STS.Frequency
FROM    Class_Meeting AS C, Seminar AS Se, Course AS Co, Attends_Class AS AC, Student AS S, Speaker AS Sp, Scheduled_Time_Slot AS STS
WHERE   C.CName = Co.CName AND Se.MeetingName = C.MeetingName AND AC.CMeetingName = C.MeetingName 
        AND AC.SEmail = S.Email AND Sp.mname = Se.MeetingName AND STS.MeetingName = C.MeetingName;

SELECT  G.Name, GD.Date, GMM.Members
FROM    Group_Meeting AS G, Group_Meeting_Date AS GD, Group_Meeting_Members AS GMM, Course AS C, Student AS S, Attends_Group_Meeting AS AGM
WHERE   G.CName = C.CName AND GD.GroupID = G.ID AND GMM.GroupID = G.ID AND AGM.MeetingID = G.ID
        AND AGM.SEmail = S.Email;
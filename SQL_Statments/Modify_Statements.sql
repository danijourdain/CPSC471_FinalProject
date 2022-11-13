--all empty quotation marks indicate the value will be set by a user input

UPDATE  User 
SET     Password_ = "", UserType = ""
WHERE   Email = "";


UPDATE  Student 
SET     Major = "", Year_ = ""
WHERE   Email = "";

UPDATE  Student_Takes 
SET     CName = "", CNumber = ""
WHERE   StuEmail = "";

UPDATE Assignment
SET Name_ = "",  CName = "", CNumber = "", Weight_ = "", Due_Date = "", Descrip = "", Contact = ""
WHERE Name_ = "";

UPDATE Exam_Quiz
SET Weight_ = "", Chapters = "", Hall, Date_ = "", Length_ = ""
WHERE Cname = "" AND CNumber = "" AND Name_ = "";

UPDATE Exam_Topic
SET Topic = ""
WHERE ExamName = "" ;

UPDATE  Lecture
SET     Learning_Obj = "", Ch_dicussed = ""
WHERE   MeetingName_Lec = "";

UPDATE  Lab
SET     Lab_topic = "", Due_Date = "", TA_Name = ""
WHERE   MeetingName_Lab = "";

UPDATE  Tutorial
SET     TA_Name = ""
WHERE   MeetingName_Tut = "";


UPDATE  Speaker
SET     Name_ = "", Organization = "", Credentials = ""
WHERE   MeetingName_Sp = "";

UPDATE  Scheduled_Time_Slot
SET     TimeOfDay = "", DaysOFWeek = "", Frequency = ""
WHERE   MeetingName_ = "";

UPDATE Tasks
SET Task = ""
WHERE ListID = "", Task = "";

UPDATE Group_Meeting
SET  Name_ = "", CName = "", CNumber = ""
WHERE ID = "";

UPDATE Group_Meeting_Date
SET  Date_ = ""
WHERE GroupID = "";

UPDATE Group_Meeting_Members
SET  Member = ""
WHERE GroupID = "";

UPDATE Assignment
SET Name_ = "",  CName = "", CNumber = "", Weight_ = "", Due_Date = "", Descrip = "", Contact = ""
WHERE Name_ = "";

UPDATE Tasks
SET Task = "", isDone = ""
WHERE ListID = "", Task = "";
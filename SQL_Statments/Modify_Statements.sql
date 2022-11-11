--all empty quotation marks indicate the value will be set by a user input

UPDATE  User 
SET     Password_ = ""
WHERE   Email = "";

UPDATE  Class_Meeting
SET     Room# = "", Topic = "", CName = ""
WHERE   MeetingName = "";

UPDATE Assignment
SET Name_ = "",  CName = "", CNumber = "", Weight_ = "", Due_Date = "", Descrip = "", Contact = ""
WHERE Name_ = "";

UPDATE Tasks
SET Task = ""
WHERE ListID = "", Task = "";

UPDATE Group_Meeting
SET  Name_ = "", CName = "", CNumber = ""
WHERE ID = "";

UPDATE Exam_Quiz
SET Weight_ = "", Chapters = "", Hall, Date_ = "", Length_ = ""
WHERE Cname = "" AND CNumber = "" AND Name_ = "";

WHERE   MeetingName = ""

UPDATE Assignment
SET Name_ = "",  CName = "", CNumber = "", Weight_ = "", Due_Date = "", Descrip = "", Contact = ""
WHERE Name_ = "";

UPDATE Tasks
SET Task = ""
WHERE ListID = "", Task = "";
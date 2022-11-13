INSERT INTO Admin_ ('example@gmail.com', 'CPSC471', 'Main Admin', 'Admin');
--why does admin have role?
-- guessing it implies the head admin cannot be deleted - M.Alshoura

INSERT INTO Admin_ ();
--need user input

INSERT INTO User_();
--need specific input

INSERT INTO Student(Email, Major, Year_)

INSERT INTO Schedule_(ID, StartDate, EndDate, Year_, SemName, StudentEmail)

INSERT INTO Viewer(Email, SEmail, SchedID)

INSERT INTO Course(CName, Descrip) VALUES ('". $cname. "','". $description ."');
--where $cname and $description are user input

INSERT INTO Student_Takes(StuEmail, CName, CNUmber, Grade)

INSERT INTO Student_Course(SEmail, CName, CNUmber)

SELECT(Course_Name, Course_Number FROM Course WHERE Cname = userInput AND CNumber = userInput) INTO @some_input_var
INSERT INTO Exam_Quiz (Name_, Course_Name, Course_Number, Weight_, Chapters, Hall, Date_, Length_)
VALUES ('". $Name_."', '". Course_Name."', '". Course_Number."', '". Weight_."', '". Chapters."', '". Hall."', '". Date_."', '".Length_ ."')

INSERT INTO Exam_Topic(ExamName, Topic)

INSERT INTO To_Do_List(ListID, SEmail)

SELECT ListID from To_Do_List WHERE some_input_var.StuEmail = StuEmail));
INSERT INTO Task(ListID, Task)

INSERT INTO Assignment(Name_, CNumber, CName, Weight_, Due_Date, Descrip, Contact, ListID)

INSERT INTO Completes_Assignments(SEmail, AName, CName. CNumber)

SELECT (CName, CNumber FROM COURSE WHERE CName = userInput AND CNumber = userInput) INTO @some_input_var
INSERT INTO Class_Meeting (MeetingName, Room#, Topic, Course_Name, Course_Number) 
VALUES ('". $MeetingName."','". $Room#."','". $Topic. "', '". $Cname."','". CNum."');

INSERT INTO Lecture(MeetingName_Lec, Learning_Obj, Ch_dicussed)

INSERT INTO Lab(MeetingName_Lab, Lab_topic, Due_Date, TA_Name)

INSERT INTO Tutorial(MeetingName_Tut, TA_Name)

INSERT INTO Seminar(MeetingName_Sem)

INSERT INTO Speaker(MeetingName_Sp, Name_, Organization, Credentials)

INSERT INTO Scheduled_Time_Slot(MeetingName_, DaysOFWeek, TimeOfDay, Frequency)

INSERT INTO Attends_Class(CMeetingName, SEmail)

INSERT INTO Section(CName, CNumber, LectureSection, Semester)

SELECT (CName, CNumber from Course Where Cname = userInputName AND CNumber = userInputNum) INTO @some_input_var;
INSERT Into Group_Meeting (Name_, CName, CNumber)
Values (temp_name, some_input_var.CName, some_input_var.CNumber);

INSERT INTO Group_Meeting_Date(GroupID, Date_)

INSERT INTO Group_Meeting_Members(GroupID, Member)

INSERT INTO Attends_Group_Meeting(GroupID, Member)

INSERT INTO Student_Exam(SEmail, Course_Name, Course_Number, EQName)

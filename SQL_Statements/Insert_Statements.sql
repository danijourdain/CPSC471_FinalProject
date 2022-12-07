INSERT INTO User_ (Email, FName, LName, Password_, UserType) VALUES (?, ?, ?, ?, ?);

INSERT INTO Student (Email, Major, Year_) VALUES (?, ?, ?);

INSERT INTO Viewer (Email, SEmail, SchedID) VALUES (?, ?, ?);

INSERT INTO Course(CName, CNumber) VALUES (?, ?);

INSERT INTO Section(CName, CNumber, LectureSection, Semester, ID) VALUES (?, ?, ?, ?, ?);

INSERT INTO Student_Course(SEmail, CName, CNumber) VALUES (?, ?, ?);

INSERT INTO Group_Meeting_Date(GroupID, GroupName, Date_) VALUES(?, ?, ?)

INSERT INTO Group_Meeting(Name_, CName, CNumber) VALUES (?, ?, ?)

INSERT INTO Attends_Group_Meeting(MeetingID, GroupName, SEmail) VALUES(?, ?, ?)

INSERT INTO Lab(MeetingName_Lab, SEmail, CName, CNumber, Lab_Topic, Due_Date, TA_Name) VALUES (?, ?, ?, ?, ?, ?, ?)

INSERT INTO Lecture(MeetingName_Lec, SEmail, CName, CNumber, Learning_Obj, Ch_discussed, InstructorName) VALUES (?, ?, ?, ?, ?, ?, ?)

INSERT INTO Class_Meeting(MeetingName, SEmail, RoomNum, Topic, Course_Name, Course_Number, MeetingType) VALUES (?, ?, ?, ?, ?, ?, ?)

INSERT INTO Scheduled_Time_Slot(MeetingName_, SEmail, CName, CNumber, DaysOFWeek, TimeOfDay, Frequency, Duration) VALUES(?, ?, ?, ?, ?, ?, ?, ?)

INSERT INTO Viewer (Email, SEmail, SchedID) VALUES (?, ?, ?)

INSERT INTO schedule_(StartDate, EndDate, Year_, SemName, StudentEmail) VALUES (?, ?, ?, ?, ?)

INSERT INTO Speaker(MeetingName_Sp, SEmail, CName, CNumber, Name_, Organization, Credentials) VALUES (?, ?, ?, ?, ?, ?, ?)

INSERT INTO Tutorial(MeetingName_Tut, SEmail, CName, CNumber, TA_Name) VALUES (?, ?, ?, ?, ?)

INSERT INTO Assignment (Name_, CNumber, CName, Weight_, Due_Date, Descrip, Contact, ListID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)

INSERT INTO completes_assignments (SEmail, AName, CName, CNumber) VALUES (?, ?, ?, ?);

INSERT INTO Exam_Quiz(Name_, Course_Name, Course_Number, Weight_, Chapters, Hall, Date_, StartTime, Length_) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);

INSERT INTO student_exam (SEmail, EQName, Course_Name, Course_Number) VALUES (?, ?, ?, ?);

INSERT INTO Student (Email, Major, Year_) VALUES (?, 'fill_later', 0);

INSERT INTO To_Do_List (SEmail) VALUES (?)

INSERT INTO Tasks (ListID, Task) VALUES (?, ?)
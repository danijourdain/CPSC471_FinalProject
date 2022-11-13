INSERT INTO Admin_ ('example@gmail.com', 'CPSC471', 'Main Admin', 'Admin');

INSERT INTO Admin_ (@Email, @Password_, @Name_, @Role_);

INSERT INTO User_(@Email, @FName, @LName, @Password_, @UserType, @AdminEmail);

INSERT INTO Student(@Email, @Major, @Year_);

INSERT INTO Schedule_(@ID, @StartDate, @EndDate, @Year_, @SemName, @StudentEmail);

INSERT INTO Viewer(@Email, @SEmail, @SchedID);

INSERT INTO Course(@CName, @CNumber, @Descrip);

INSERT INTO Student_Takes(@StuEmail, @CName, @CNUmber, @Grade);

INSERT INTO Student_Course(@SEmail, @CName, @CNumber);

INSERT INTO Exam_Quiz (@Name_, @Course_Name, @Course_Number, @Weight_, @Chapters, @Hall, @Date_, @Length_);

INSERT INTO Exam_Topic(@ExamName, @Topic);

INSERT INTO To_Do_List(@ListID, @SEmail);

INSERT INTO Task(@ListID, @Task);

INSERT INTO Assignment(@Name_, @CNumber, @CName, @Weight_, @Due_Date, @Descrip, @Contact, @ListID);

INSERT INTO Completes_Assignments(@SEmail, @AName, @CName. @CNumber);

INSERT INTO Class_Meeting (@MeetingName, @RoomNum, @Topic, @Course_Name, @Course_Number);

INSERT INTO Lecture(@MeetingName_Lec, @Learning_Obj, @Ch_dicussed);

INSERT INTO Lab(@MeetingName_Lab, @Lab_topic, @Due_Date, @TA_Name);

INSERT INTO Tutorial(@MeetingName_Tut, @TA_Name);

INSERT INTO Seminar(@MeetingName_Sem);

INSERT INTO Speaker(@MeetingName_Sp, @Name_, @Organization, @Credentials);

INSERT INTO Scheduled_Time_Slot(@MeetingName_, @DaysOFWeek, @TimeOfDay, @Frequency);

INSERT INTO Attends_Class(@CMeetingName, @SEmail);

INSERT INTO Section(@CName, @CNumber, @LectureSection, @Semester);

INSERT Into Group_Meeting (@Name_, @CName, @CNumber);

INSERT INTO Group_Meeting_Date(@GroupID, @Date_);

INSERT INTO Group_Meeting_Members(@GroupID, @Member);

INSERT INTO Attends_Group_Meeting(@GroupID, @Member);

INSERT INTO Student_Exam(@SEmail, @Course_Name, @Course_Number, @EQName)

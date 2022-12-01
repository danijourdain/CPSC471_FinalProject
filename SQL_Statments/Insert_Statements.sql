INSERT INTO Admin_ ('example@gmail.com', 'CPSC471', 'Main Admin', 'Admin');
<<<<<<< Updated upstream
=======
--why does admin have role?
-- guessing it implies the head admin cannot be deleted - M.Alshoura
>>>>>>> Stashed changes

INSERT INTO Admin_ (@Email, @Password_, @Name_, @Role_);

INSERT INTO User_(@Email, @FName, @LName, @Password_, @UserType, @AdminEmail);

INSERT INTO Student(@Email, @Major, @Year_);

<<<<<<< Updated upstream
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
=======
INSERT INTO Class_Meeting ();

SELECT (CName, CNumber from Course Where Cname = userInputName AND CNumber = userInputNum) INTO @some_input_var;
INSERT Into Group_Meeting (Name_, CName, CNumber)
Values (temp_name, some_input_var.CName, some_input_var.CNumber);
-- user input needed from front end


SELECT (CName, CNumber, StuEmail from Course Where Cname = userInputName AND CNumber = userInputNum, StuEmail = userInputEmail) INTO @some_input_var;
INSERT Into Assignment
Values (Name_, some_input_var.CName, some_input_var.CNumber, Weight_, Due_Date, Descrip, Contact, (SELECT ListID from To_Do_List WHERE some_input_var.StuEmail = StuEmail));
>>>>>>> Stashed changes

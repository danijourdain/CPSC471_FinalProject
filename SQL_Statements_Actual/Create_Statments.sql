DROP DATABASE IF EXISTS `471_Final_Project`;
CREATE DATABASE `471_Final_Project`;

CREATE TABLE User_
    (Email      VARCHAR(32)     NOT NULL,
    FName       VARCHAR(15)     NOT NULL,
    LName       VARCHAR(15)     NOT NULL,
    Password_    VARCHAR(32)     NOT NULL,
    UserType    VARCHAR(15)     NOT NULL,
    AdminEmail  VARCHAR(32)     NULL,
    PRIMARY KEY (Email)
    );
    
CREATE TABLE Student
    (Email      VARCHAR(32)     NOT NULL,
    Major       VARCHAR(15)     NOT NULL,
    Year_        INT             NOT NULL,
    PRIMARY KEY(Email),
    FOREIGN KEY(Email) REFERENCES User_(Email)
    ON DELETE CASCADE       ON UPDATE CASCADE
    );
    
CREATE TABLE Schedule_
(
    ID              INT             NOT NULL AUTO_INCREMENT,
    StartDate       DATE            NOT NULL,
    EndDate         DATE            NOT NULL,
    Year_           INT             NOT NULL,
    SemName         VARCHAR(10)     NOT NULL,
    StudentEmail    VARCHAR(32)     NOT NULL,
    PRIMARY KEY(ID, SemName),
    FOREIGN KEY(StudentEmail) REFERENCES Student(Email)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Viewer
    (Email      VARCHAR(32)     NOT NULL,
    SEmail      VARCHAR(32)     NOT NULL,
    SchedID     INT             NOT NULL,
    PRIMARY KEY(Email, SchedID),
    FOREIGN KEY(Email) REFERENCES User_ (Email)
      ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(SchedID) REFERENCES Schedule_(ID)
       ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
       ON DELETE CASCADE       ON UPDATE CASCADE
    );

CREATE TABLE Course
    (CName      CHAR(4)     NOT NULL,
    CNumber        INT             NOT NULL,
    Descrip     VARCHAR(15)		DEFAULT NULL,
    PRIMARY KEY(CName, CNumber)
    );
    
CREATE TABLE Student_Course
    (SEmail   VARCHAR(32)     NOT NULL,
    CName       CHAR(4)     NOT NULL,
    CNumber       INT             NOT NULL,
    Grade       INT				DEFAULT NULL,
    PRIMARY KEY(CName, CNumber, SEmail),
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
      ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(CName, CNumber) REFERENCES Course(CName, CNumber)
      ON DELETE CASCADE       ON UPDATE CASCADE
    );

CREATE TABLE Exam_Quiz
(
    Name_           VARCHAR(32)     NOT NULL,
    Course_Name     CHAR(4)         NOT NULL,
    Course_Number   INT             NOT NULL,
    Weight_         FLOAT           ,
    -- can it be null, how to account for dropping lowest quiz
    Chapters        VARCHAR(128)     ,
    Hall            VARCHAR(32)     NOT NULL,
    -- does that already account for online quizzes?
    Date_           DATE            NOT NULL,
    Length_         INT             NOT NULL,
    PRIMARY KEY(Name_, Course_Name, Course_Number),
    FOREIGN KEY(Course_Name, Course_Number) REFERENCES Course(CName, CNumber)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Exam_Topic
    (ExamName   VARCHAR(15)     NOT NULL,
    Topic       VARCHAR(15)     NOT NULL,
    PRIMARY KEY(ExamName, Topic),
    FOREIGN KEY(ExamName) REFERENCES Exam_Quiz(Name_)
      ON DELETE CASCADE       ON UPDATE CASCADE
    );

CREATE TABLE To_Do_List
(
    ListID          INT             NOT NULL AUTO_INCREMENT,
    SEmail          VARCHAR(32)     NOT NULL,
    PRIMARY KEY(ListID),
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Tasks
(
    ListID          INT             NOT NULL,
    Task            VARCHAR(50)     NOT NULL,
    isDone          BOOLEAN         NOT NULL DEFAULT 0,
    PRIMARY KEY(ListID, Task),
    FOREIGN KEY(ListID) REFERENCES To_Do_List(ListID)
     ON DELETE CASCADE       ON UPDATE CASCADE
);


CREATE TABLE Assignment
    (Name_      VARCHAR(15)     NOT NULL,
    CNumber     INT 	        NOT NULL,
    CName       CHAR(4)     	NOT NULL,
    Weight_     INT             NOT NULL,
    Due_Date    DATE            NOT NULL,
    Descrip     VARCHAR(15),
    Contact     VARCHAR(15),
    ListID      INT             NOT NULL,
    PRIMARY KEY(Name_, CNumber, CName),
    FOREIGN KEY(CName, CNumber) REFERENCES Course(CName, CNumber)
      ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(ListID) REFERENCES To_Do_List(ListID)
    );



CREATE TABLE Completes_Assignments
    (SEmail     VARCHAR(32)     NOT NULL,
    AName       VARCHAR(15)     NOT NULL,
    CName       CHAR(4)     	NOT NULL,
    CNumber     INT 	        NOT NULL,
    PRIMARY KEY(SEmail, AName, CName, CNumber),
    FOREIGN KEY(CName, CNumber) REFERENCES Course(CName, CNumber)
      ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(AName) REFERENCES Assignment(Name_)
      ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
      ON DELETE CASCADE       ON UPDATE CASCADE
    );



CREATE TABLE Class_Meeting
(
    MeetingName     VARCHAR(32)     NOT NULL,
    Course_Name     CHAR(4)         NOT NULL,
    Course_Number   INT             NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    MeetingType     VARCHAR(8)      NOT NULL,
    RoomNum         VARCHAR(32)     DEFAULT NULL,
    Topic           VARCHAR(32)     DEFAULT NULL,
    PRIMARY KEY(MeetingName, SEmail, Course_Name, Course_Number),
    CONSTRAINT unique_meeting UNIQUE (MeetingName, RoomNum, Course_Name, Course_Number),
    FOREIGN KEY(Course_Name, Course_Number, SEmail) REFERENCES Student_Course(CName, CNumber, SEmail)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Lecture
(
    MeetingName_Lec  VARCHAR(32)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    CName     CHAR(4)         NOT NULL,
    CNumber   INT             NOT NULL,
    Learning_Obj    VARCHAR(256),
    Ch_discussed     VARCHAR(32),
    InstructorName  VARCHAR(32)    DEFAULT NULL,
    
    PRIMARY KEY(MeetingName_Lec, SEmail, CName, CNumber),
    FOREIGN KEY(MeetingName_Lec, SEmail, CName, CNumber) REFERENCES Class_Meeting(MeetingName, SEmail, Course_Name, Course_Number)
    ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Lab
(
    MeetingName_Lab  VARCHAR(32)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    CName     CHAR(4)         NOT NULL,
    CNumber   INT             NOT NULL,
    Lab_topic        VARCHAR(256),
    Due_Date         DATE            NOT NULL,
    TA_Name          VARCHAR(64),
    
    PRIMARY KEY(MeetingName_Lab, SEmail, CName, CNumber),
    FOREIGN KEY(MeetingName_Lab, SEmail, CName, CNumber) REFERENCES Class_Meeting(MeetingName, SEmail, Course_Name, Course_Number)
    ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Tutorial
(
    MeetingName_Tut  VARCHAR(32)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    CName     CHAR(4)         NOT NULL,
    CNumber   INT             NOT NULL,
    TA_Name          VARCHAR(64),
    
    PRIMARY KEY(MeetingName_Tut, SEmail, CName, CNumber),
    FOREIGN KEY(MeetingName_Tut, SEmail, CName, CNumber) REFERENCES Class_Meeting(MeetingName, SEmail, Course_Name, Course_Number)
    ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Seminar
(
    MeetingName_Sem  VARCHAR(32)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    CName     CHAR(4)         NOT NULL,
    CNumber   INT             NOT NULL,
    
    PRIMARY KEY(MeetingName_Sem, SEmail, CName, CNumber),
    FOREIGN KEY(MeetingName_Sem, SEmail, CName, CNumber) REFERENCES Class_Meeting(MeetingName, SEmail, Course_Name, Course_Number)
    ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Speaker
(
    MeetingName_Sp  VARCHAR(32)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    CName     CHAR(4)         NOT NULL,
    CNumber   INT             NOT NULL,
    Name_           VARCHAR(64)     NOT NULL,
    Organization    VARCHAR(32)     NOT NULL,
    Credentials     VARCHAR(256)    NOT NULL,
    -- are all of these supposed to be a key, review ER
    PRIMARY KEY(MeetingName_Sp, SEmail, CName, CNumber, Name_, Organization, Credentials),
    FOREIGN KEY(MeetingName_Sp, SEmail, CName, CNumber) REFERENCES Seminar(MeetingName_Sem, SEmail, CName, CNumber)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Scheduled_Time_Slot
(
    MeetingName_     VARCHAR(32)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    CName     CHAR(4)         NOT NULL,
    CNumber   INT             NOT NULL,
    DaysOFWeek       VARCHAR(64)     NOT NULL,
    -- not sure about not null/ primary key on Dayofweek
    TimeOfDay        VARCHAR(32)     NOT NULL,
    -- format so refers to time and duration?
    Duration         INT            NOT NULL,
    Frequency        VARCHAR(16)     NOT NULL,
    
    PRIMARY KEY(MeetingName_, SEmail, CName, CNumber, DaysOFWeek, TimeOfDay, Frequency),
    FOREIGN KEY(MeetingName_, SEmail, CName, CNumber) REFERENCES Class_Meeting(MeetingName, SEmail, Course_Name, Course_Number)
     ON DELETE CASCADE       ON UPDATE CASCADE
);


CREATE TABLE Section 
(
    CName           CHAR(4)         NOT NULL,
    CNumber         INT             NOT NULL,
    LectureSection  CHAR(3)         NOT NULL,
    Semester        VARCHAR(10)     NOT NULL,
    ID              INT             NOT NULL,
    PRIMARY KEY(CName, CNumber, LectureSection, Semester),
    FOREIGN KEY(CName, CNumber) REFERENCES Course(CName, CNumber)
    ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(ID, Semester) REFERENCES Schedule_(ID, SemName)
     ON DELETE CASCADE       ON UPDATE CASCADE
);


CREATE TABLE Group_Meeting
(
    ID              INT             NOT NULL,
    Name_           VARCHAR(15)     NOT NULL,
    CName           CHAR(4)         NOT NULL,
    CNumber         INT             NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY(CName, CNumber) REFERENCES Course(CName, CNumber)
     ON DELETE CASCADE       ON UPDATE CASCADE
);


CREATE TABLE Group_Meeting_Date
(
    GroupID         INT             NOT NULL,
    Date_           DATE            NOT NULL,
    PRIMARY KEY(GroupID, Date_),
    FOREIGN KEY(GroupID) REFERENCES Group_Meeting(ID)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Group_Meeting_Members
(
    GroupID         INT             NOT NULL,
    Member          VARCHAR(50)     NOT NULL,
    PRIMARY KEY(GroupID, Member),
    FOREIGN KEY(GroupID) REFERENCES Group_Meeting(ID)
     ON DELETE CASCADE       ON UPDATE CASCADE
);

CREATE TABLE Attends_Group_Meeting
(
    MeetingID       INT             NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    PRIMARY KEY(MeetingID, SEmail),
    FOREIGN KEY(MeetingID) REFERENCES Group_Meeting(ID)
     ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
     ON DELETE CASCADE       ON UPDATE CASCADE
);


CREATE TABLE Student_Exam
(
    SEmail          VARCHAR(32)     NOT NULL,
    Course_Name     CHAR(4)         NOT NULL,
    Course_Number   INT             NOT NULL,
    EQName           VARCHAR(32)     NOT NULL,
    PRIMARY KEY(SEmail, Course_Name, Course_Number, EQName),
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
     ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(Course_Name, Course_Number) REFERENCES Course(CName, CNumber)
     ON DELETE CASCADE       ON UPDATE CASCADE,
    FOREIGN KEY(EQName) REFERENCES Exam_Quiz(Name_)
     ON DELETE CASCADE       ON UPDATE CASCADE
);
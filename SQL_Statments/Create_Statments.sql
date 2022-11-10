DROP DATABASE IF EXISTS '471_Final_Project';
CREATE DATABASE '471_Final_Project';
--remove the database if it already exists, and create a new database


CREATE TABLE User
    (Email      VARCHAR(32)     NOT NULL,
    FName       VARCHAR(15)     NOT NULL,
    LName       VARCHAR(15)     NOT NULL,
    Password_    VARCHAR(15)     NOT NULL,
    UserType    VARCHAR(15)     NOT NULL,
    AdminEmail  VARCHAR(15)     NOT NULL,
    PRIMARY KEY (Email)
    );

CREATE TABLE Admin_
    (Email      VARCHAR(32)     NOT NULL,
    Password_   VARCHAR(15)     NOT NULL,
    Name_       VARCHAR(15)     NOT NULL,
    Role_       VARCHAR(15)     NOT NULL,
    PRIMARY KEY(Email)
    );

CREATE TABLE Viewer
    (Email      VARCHAR(32)     NOT NULL,
    SEmail      VARCHAR(15)     NOT NULL,
    SchedID     INT,            NOT NULL,
    PRIMARY KEY(Email)
    );

CREATE TABLE Student
    (Email      VARCHAR(32)     NOT NULL,
    Major       VARCHAR(15)     NOT NULL,
    Year_        INT             NOT NULL,
    PRIMARY KEY(Email)
    );


CREATE TABLE Course
    (CName      VARCHAR(15)     NOT NULL,
    CNumber     INT             NOT NULL,
    Descrip     VARCHAR(15),
    PRIMARY KEY(CName, CNumber),
    ON DELETE CASCADE       ON UPDATE CASCADE;
    );

CREATE TABLE Student_Takes
    (StuEmail   VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    CNumber     INT             NOT NULL,
    Grade       INT,
    PRIMARY KEY(StuEmail, CName, CNumber),
    FOREIGN KEY(StuEmail) REFERENCES Student(Email),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber)
    );

CREATE TABLE Student_Course
    (SEmail     VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    CNumber     INT             NOT NULL,
    PRIMARY KEY(SEmail, CName, CNumber),
    FOREIGN KEY(SEmail) REFERENCES Student(Email),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber)
    );

CREATE TABLE Exam_Topic
    (ExamName   VARCHAR(15)     NOT NULL,
    Topic       VARCHAR(15)     NOT NULL,
    PRIMARY KEY(ExamName, Topic),
    FOREIGN KEY(ExamName) REFERENCES Exam(Name_)
    );

CREATE TABLE Assignment
    (Name_      VARCHAR(15)     NOT NULL,
    CNumber     VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    Weight_     INT             NOT NULL,
    Due_Date    DATE            NOT NULL,
    Descrip     VARCHAR(15),
    Contact     VARCHAR(15),
    ListID      INT             NOT NULL,
    PRIMARY KEY(Name_, CNumber, CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(ListID) REFERENCES To_Do_List(ListID),
    ON DELETE CASCADE       ON UPDATE CASCADE;
    );

CREATE TABLE Completes_Assignmetns
    (SEmail     VARCHAR(15)     NOT NULL,
    AName       VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    CNumber     VARCHAR(15)     NOT NULL,
    PRIMARY KEY(SEmail, AName, CName, CNumber),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(AName) REFERENCES Assignment(Name_)
    );

CREATE TABLE Attends_Class
(
    CMeetingName    VARCHAR(25)     NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    PRIMARY KEY(CMeetingName, SEmail),
    FOREIGN KEY(CMeetingName) REFERENCES Class_Meeting(MeetingName),
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
);
--NEED TO ADD UPDATE/DELETE CASCAE/SET NULL/SET DEFAULT THING

CREATE TABLE Schedule
(
    ID              INT             NOT NULL,
    StartDate       DATE            NOT NULL,
    EndDate         DATE            NOT NULL,
    Year_           INT             NOT NULL,
    --is year really needed when we have start date and end date as actual date type?
    SemName         VARCHAR(20)     NOT NULL,
    StudentEmail    VARCHAR(32)     NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY(StudentEmail) REFERENCES Student(Email)
);

CREATE TABLE To_Do_List
(
    ListID          INT             NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    PRIMARY KEY(ListID),
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
);

CREATE TABLE Tasks
(
    ListID          INT             NOT NULL,
    Task            VARCHAR(50)     NOT NULL,
    PRIMARY KEY(ListID, Task),
    FOREIGN KEY(ListID) REFERENCES To_Do_List(ListID)
);

CREATE TABLE Section 
(
    CName           CHAR(4)         NOT NULL,
    CNumber         INT             NOT NULL,
    LectureSection  CHAR(3)         NOT NULL,
    Semester        VARCHAR(10)     NOT NULL,
    PRIMARY KEY(CName, CNumber, LectureSection, Semester),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber)
);

CREATE TABLE Group_Meeting
(
    ID              INT             NOT NULL,
    Name_           VARCHAR(15)     NOT NULL,
    CName           CHAR(4)         NOT NULL,
    CNumber         INT             NOT NULL,
    PRIMARY KEY(ID),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber)
);

CREATE TABLE Group_Meeting_Date
(
    GroupID         INT             NOT NULL,
    Date_           DATE            NOT NULL,
    PRIMARY KEY(GroupID, Date_),
    FOREIGN KEY(GroupID) REFERENCES Group_Meeting(ID)
);

CREATE TABLE Group_Meeting_Members
(
    GroupID         INT             NOT NULL,
    Member          VARCHAR(50)     NOT NULL,
    PRIMARY KEY(GroupID, Member),
    FOREIGN KEY(GroupID) REFERENCES Group_Meeting(ID)
);

CREATE TABLE Attends_Group_Meeting
(
    MeetingID       INT             NOT NULL,
    SEmail          VARCHAR(32)     NOT NULL,
    PRIMARY KEY(MeetingID, SEmail),
    FOREIGN KEY(MeetingID) REFERENCES Group_Meeting(ID),
    FOREIGN KEY(SEmail) REFERENCES Student(Email)
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
    FOREIGN KEY(Course_Name) REFERENCES Course(CName),
    FOREIGN KEY(Course_Number) REFERENCES Course(CNumber)             
);

CREATE TABLE Student_Exam
(
    SEmail          VARCHAR(32)     NOT NULL,
    Course_Name     CHAR(4)         NOT NULL,
    Course_Number   INT             NOT NULL,
    EQName           VARCHAR(32)     NOT NULL,

    --not sure about having a primary key made entirely out of foreign keys
    --would sql be able to run it, maybe move tables with dependencies to the bottom
    PRIMARY KEY(SEmail, Course_Name, Course_Number, EQName),
    FOREIGN KEY(SEmail) REFERENCES Student(Email),
    FOREIGN KEY(Course_Name) REFERENCES Course(CName),
    FOREIGN KEY(Course_Number) REFERENCES Course(CNumber)
    FOREIGN KEY(EQName) REFERENCES Exam_Quiz(Name_)
);

CREATE TABLE Class_Meeting
(
    MeetingName     VARCHAR(32)     NOT NULL,
    Room#           VARCHAR(32)     NOT NULL,
    -- maybe allow null for room# and replace null with "online"
    Topic           VARCHAR(32),
    Course_Name     CHAR(4)         NOT NULL,
    Course_Number   INT             NOT NULL,
    PRIMARY KEY(MeetingName),
    FOREIGN KEY(Course_Name) REFERENCES Course(CName),
    FOREIGN KEY(Course_Number) REFERENCES Course(CNumber)
);

CREATE TABLE Lecture
(
    MeetingName_Lec  VARCHAR(32)     NOT NULL,
    Learning_Obj    VARCHAR(256),
    Ch_dicussed     VARCHAR(32),
    
    PRIMARY KEY(MeetingName_Lec),
    FOREIGN KEY(MeetingName_Lec) REFERENCES Class_Meeting(MeetingName)
);

CREATE TABLE Lab
(
    MeetingName_Lab  VARCHAR(32)     NOT NULL,
    Lab_topic        VARCHAR(256),
    Due_Date         DATE            NOT NULL,
    TA_Name          VARCHAR(64),
    
    PRIMARY KEY(MeetingName_Lab),
    FOREIGN KEY(MeetingName_Lab) REFERENCES Class_Meeting(MeetingName)
);

CREATE TABLE Tutorial
(
    MeetingName_Tut  VARCHAR(32)     NOT NULL,
    TA_Name          VARCHAR(64),
    
    PRIMARY KEY(MeetingName_Tut),
    FOREIGN KEY(MeetingName_Tut) REFERENCES Class_Meeting(MeetingName)
);

CREATE TABLE Seminar
(
    MeetingName_Sem  VARCHAR(32)     NOT NULL,
    
    PRIMARY KEY(MeetingName_Sem),
    FOREIGN KEY(MeetingName_Sem) REFERENCES Class_Meeting(MeetingName)
);

CREATE TABLE Speaker
(
    MeetingName_Sp  VARCHAR(32)     NOT NULL,
    Name_           VARCHAR(64)     NOT NULL,
    Organization    VARCHAR(32)     NOT NULL,
    Credentials     VARCHAR(256)    NOT NULL,
    -- are all of these supposed to be a key, review ER
    PRIMARY KEY(MeetingName_Sp, Name_, Organization, Credentials),
    FOREIGN KEY(MeetingName_Sp) REFERENCES Seminar(MeetingName_Sem)
);

CREATE TABLE Scheduled_Time_Slot
(
    MeetingName_     VARCHAR(32)     NOT NULL,
    DaysOFWeek       VARCHAR(64)     NOT NULL,
    -- not sure about not null/ primary key on Dayofweek
    TimeOfDay        VARCHAR(32)     NOT NULL,
    -- format so refers to time and duration?
    Frequency        VARCHAR(16)     NOT NULL
    
    PRIMARY KEY(MeetingName_, DaysOFWeek, TimeOfDay, Frequency),
    FOREIGN KEY(MeetingName_) REFERENCES Class_Meeting(MeetingName)
);


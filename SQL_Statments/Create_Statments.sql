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
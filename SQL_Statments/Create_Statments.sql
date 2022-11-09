DROP DATABASE IF EXISTS '471_Final_Project';
CREATE DATABASE '471_Final_Project';
--remove the database if it already exists, and create a new database


CREATE TABLE User
    (Email      VARCHAR(15)     NOT NULL,
    FName       VARCHAR(15)     NOT NULL,
    LName       VARCHAR(15)     NOT NULL,
    Password_    VARCHAR(15)     NOT NULL,
    UserType    VARCHAR(15)     NOT NULL,
    AdminEmail  VARCHAR(15)     NOT NULL,
    PRIMARY KEY (Email)
    )

CREATE TABLE Admin_
    (Email      VARCHAR(15)     NOT NULL,
    Password_   VARCHAR(15)     NOT NULL,
    Name_       VARCHAR(15)     NOT NULL,
    Role_       VARCHAR(15)     NOT NULL,
    PRIMARY KEY(Email)
    )

CREATE TABLE Viewer
    (Email      VARCHAR(15)     NOT NULL,
    SEmail      VARCHAR(15)     NOT NULL,
    SchedID     INT,            NOT NULL,
    PRIMARY KEY(Email)
    )

CREATE TABLE Student
    (Email      VARCHAR(15)     NOT NULL,
    Major       VARCHAR(15)     NOT NULL,
    Year_        INT             NOT NULL,
    PRIMARY KEY(Email)
    )

CREATE TABLE Course
    (CName      VARCHAR(15)     NOT NULL,
    CNumber     INT             NOT NULL,
    Descrip     VARCHAR(15),
    PRIMARY KEY(CName, CNumber),
    ON DELETE CASCADE       ON UPDATE CASCADE;
    )

CREATE TABLE Student_Takes
    (StuEmail   VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    CNumber     INT             NOT NULL,
    Grade       INT,
    PRIMARY KEY(StuEmail, CName, CNumber),
    FOREIGN KEY(StuEmail) REFERENCES Student(Email),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber)
    )

CREATE TABLE Student_Course
    (SEmail     VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    CNumber     INT             NOT NULL,
    PRIMARY KEY(SEmail, CName, CNumber),
    FOREIGN KEY(SEmail) REFERENCES Student(Email),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber)
    )

CREATE TABLE Exam_Topic
    (ExamName   VARCHAR(15)     NOT NULL,
    Topic       VARCHAR(15)     NOT NULL,
    PRIMARY KEY(ExamName, Topic),
    FOREIGN KEY(ExamName) REFERENCES Exam(Name_)
    )

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
    )

CREATE TABLE Completes_Assignemtns
    (SEmail     VARCHAR(15)     NOT NULL,
    AName       VARCHAR(15)     NOT NULL,
    CName       VARCHAR(15)     NOT NULL,
    CNumber     VARCHAR(15)     NOT NULL,
    PRIMARY KEY(SEmail, AName, CName, CNumber),
    FOREIGN KEY(CNumber) REFERENCES Course(CNumber),
    FOREIGN KEY(CName) REFERENCES Course(CName),
    FOREIGN KEY(AName) REFERENCES Assignment(Name_)
    )
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
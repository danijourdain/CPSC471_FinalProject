INSERT INTO Admin_ ('example@gmail.com', 'CPSC471', 'Main Admin', 'Admin');
--why does admin have role?
-- guessing it implies the head admin cannot be deleted - M.Alshoura

INSERT INTO Admin_ ();
--need user input

INSERT INTO User();
--need specific input

INSERT INTO Course(CName, Descrip) VALUES ('". $cname. "','". $description ."');
--where $cname and $description are user input

INSERT INTO Class_Meeting(MeetingNamee, Room#, Topic, CName) VALUES ('". $mname. "','". $roomno ."','". $topic ."','". $cname ."');
--where are values beginning with "$" are user input

SELECT (CName, CNumber from Course Where Cname = userInputName AND CNumber = userInputNum) INTO @some_input_var;
INSERT Into Group_Meeting (Name_, CName, CNumber)
Values (temp_name, some_input_var.CName, some_input_var.CNumber);
-- user input needed from front end


INSERT Into Assignment
Values (Name_, some_input_var.CName, some_input_var.CNumber, Weight_, Due_Date, Descrip, Contact, (SELECT ListID from To_Do_List WHERE some_input_var.StuEmail = StuEmail));

SELECT (CName, CNumber FROM COURSE WHERE CName = userInput AND CNumber = userInput) INTO @some_input_var
INSERT INTO Class_Meeting (MeetingName, Room#, Topic, Course_Name, Course_Number) 
VALUES ('". $MeetingName."','". $Room#."','". $Topic. "', '". $Cname."','". CNum."');

SELECT(Course_Name, Course_Number FROM Course WHERE Cname = userInput AND CNumber = userInput) INTO @some_input_var
INSERT INTO Exam_Quiz (Name_, Course_Name, Course_Number, Weight_, Chapters, Hall, Date_, Length_)
VALUES ('". $Name_."', '". Course_Name."', '". Course_Number."', '". Weight_."', '". Chapters."', '". Hall."', '". Date_."', '".Length_ ."')

INSERT INTO Task();
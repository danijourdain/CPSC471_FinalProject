INSERT INTO Admin_ ('example@gmail.com', 'CPSC471', 'Main Admin', 'Admin');
--why does admin have role?
-- guessing it implies the head admin cannot be deleted - M.Alshoura

INSERT INTO Admin_ ();
--need user input

INSERT INTO User ();
--need specific input

INSERT INTO Course ();

INSERT INTO Class_Meeting ();

SELECT (CName, CNumber from Course Where Cname = userInputName AND CNumber = userInputNum) INTO @some_input_var;
INSERT Into Group_Meeting (Name_, CName, CNumber)
Values (temp_name, some_input_var.CName, some_input_var.CNumber);
-- user input needed from front end


SELECT (CName, CNumber, StuEmail from Course Where Cname = userInputName AND CNumber = userInputNum, StuEmail = userInputEmail) INTO @some_input_var;
INSERT Into Assignment
Values (Name_, some_input_var.CName, some_input_var.CNumber, Weight_, Due_Date, Descrip, Contact, (SELECT ListID from To_Do_List WHERE some_input_var.StuEmail = StuEmail));


INSERT INTO Class_Meeting ();

INSERT INTO Exam ();

INSERT INTO Task();
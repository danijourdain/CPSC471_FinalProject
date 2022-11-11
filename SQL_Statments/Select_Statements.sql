--all empty quotation marks indicate user input will be used

SELECT Password_ FROM Admin WHERE Email="";
SELECT Password_ FROM User WHERE Email="";
--both of these are used to verify login information

SELECT  S.ID
FROM    Schedule AS S, Viewer AS V
WHERE   V.SchedID = S.ID;
--get all schedules the viewer has access to

SELECT  Sc.ID
FROM    Schedule AS Sc, Student as St
WHERE   St.StudentEmail = S.Email;
--get the student's schedule(s)


CREATE TABLE Tests (
ID INT AUTO_INCREMENT PRIMARY KEY,
Testname VARCHAR(256) NOT NULL,
QuestionTotal INT NOT NULL,
FirstQuestionID INT NOT NULL,
LastQuestionID INT NOT NULL);

CREATE TABLE Questions (
ID INT AUTO_INCREMENT PRIMARY KEY,
TestID INT NOT NULL,
QuestionText VARCHAR(4096) NOT NULL,
CorrectAnswerID INT NOT NULL);

CREATE TABLE Answers (
ID INT AUTO_INCREMENT PRIMARY KEY,
QuestionID INT NOT NULL,
Answer VARCHAR(256) NOT NULL);

CREATE TABLE Users (
ID INT AUTO_INCREMENT PRIMARY KEY,
Username VARCHAR(64) NOT NULL);

CREATE TABLE UserRecords (
ID INT AUTO_INCREMENT PRIMARY KEY,
UserID INT NOT NULL,
TestID INT NOT NULL,
Result INT NOT NULL,
RecordID INT NOT NULL);

INSERT INTO Tests(Testname, QuestionTotal, FirstQuestionID, LastQuestionID)
VALUES ('Star Wars Quiz', 6, 1, 6);

INSERT INTO Questions(TestID, QuestionText, CorrectAnswerID)
VALUES (1, 'Which character is partially named after George Lucas son?', 1),
       (1, 'What is the Wookiee home world?', 6),
       (1, 'In how many languages is C-3P0 fluent?', 12),
       (1, 'What was the original name of the first Star Wars movie when it went into production?', 14),
       (1, 'Which species stole the plans to the Death Star?', 19),
       (1, 'Which character in The Empire Strikes Back is wearing an old costume from a Doctor Who episode?', 23);

INSERT INTO Answers(QuestionID, Answer)
VALUES (1, 'Dexter Jester'), (1, 'Princess Leia'), (1, 'Darth Vader'),
       (1, 'Storm Troopers'), (2, 'Azeroth'), (2, 'Kashyyk'),
       (2, 'Naboo'), (2, 'Middle-Earth'), (3, '500'),
       (3, '6'), (3, '100 000'), (3, 'Over 6 million'),
       (4, 'The Space Movie'), (4, 'Adventures of Luke Starkiller'), (4, 'The Solar Empire'),
       (4, 'The Death Star Trilogy'), (5, 'Elomins'), (5, 'Calamari'),
       (5, 'Bothans'), (5, 'Nautolan'), (6, 'Bobba Fett'),
       (6, 'R2-D2'), (6, 'Bossk'), (6, 'Yoda');

CREATE TABLE TestResults_1 (
ID INT AUTO_INCREMENT PRIMARY KEY,
UserID INT NOT NULL,
Answer_Question_1 INT DEFAULT NULL,
Answer_Question_2 INT DEFAULT NULL,
Answer_Question_3 INT DEFAULT NULL,
Answer_Question_4 INT DEFAULT NULL,
Answer_Question_5 INT DEFAULT NULL,
Answer_Question_6 INT DEFAULT NULL);


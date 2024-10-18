



-- ----------------------------------------------------------------
-- Leaderboard
INSERT INTO `leaderboard` () VALUES ();
SET @leaderboardQuizz1 = LAST_INSERT_ID();

-- private quizz
INSERT INTO `private_quiz` (`idQuiz`, `title`, `description`, `idLeaderboard`, `userName`) VALUES
('1234567890abcdef', 'Quizz about what i like', 'Test your knowledge', @leaderboardQuizz1, 'Pere');


-- question 1
INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is my favorite color?', '1234567890abcdef');
SET @questionQ1_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('Blue', @questionQ1_1),
('Red', @questionQ1_1),
('Green', @questionQ1_1),
('Yellow', @questionQ1_1);


INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ1_1);

-- question 2
INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is my favorite animal?', '1234567890abcdef');
SET @questionQ2_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('Dog', @questionQ2_1),
('Cat', @questionQ2_1),
('Bird', @questionQ2_1),
('Fish', @questionQ2_1);

INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ2_1);



-- question 3

INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is my favorite food?', '1234567890abcdef');
SET @questionQ3_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('Pizza', @questionQ3_1),
('Sushi', @questionQ3_1),
('Burger', @questionQ3_1),
('Pasta', @questionQ3_1);

INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ3_1);

-- question 4

INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is my dream travel destination?', '1234567890abcdef');
SET @questionQ4_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('Paris', @questionQ4_1),
('Bali', @questionQ4_1),
('New York', @questionQ4_1),
('Tokyo', @questionQ4_1);

INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ4_1);



-- question 5
INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is my favorite book?', '1234567890abcdef');
SET @questionQ5_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('To Kill a Mockingbird', @questionQ5_1),
('Harry Potter and the Sorcerer\'s Stone', @questionQ5_1),
('1984', @questionQ5_1),
('Pride and Prejudice', @questionQ5_1);

INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ5_1);

-- question 6
INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is my favorite hobby?', '1234567890abcdef');
SET @questionFriend6_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('Painting', @questionFriend6_1),
('Hiking', @questionFriend6_1),
('Playing the Guitar', @questionFriend6_1),
('Cooking', @questionFriend6_1);

INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionFriend6_1);


-- ----------------------------------------------------------------

-- Leaderboard
INSERT INTO `leaderboard` () VALUES (); -- Leaderboard for Friend 2
SET @leaderboardQuizz2 = LAST_INSERT_ID();

-- private quizz
INSERT INTO `private_quiz` (`idQuiz`, `title`, `description`, `idLeaderboard`, `userName`) VALUES
('ABC78954287HBGDT', 'Quizz about instant of life', 'Test your knowledge', @leaderboardQuizz2, 'Pere');

-- question 1

INSERT INTO `question` (`question`, `idQuiz`) VALUES
('What is the date of my most memorable childhood vacation?', 'ABC78954287HBGDT');
SET @questionQ2_1 = LAST_INSERT_ID();

INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('Summer 1998', @questionQ2_1),
('Winter 2005', @questionQ2_1),
('Spring 2010', @questionQ2_1),
('Fall 2013', @questionQ2_1);

INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ2_1);


-- question 2
INSERT INTO `question` (`question`, `idQuiz`) VALUES
('On which date did i graduate from high school?', 'ABC78954287HBGDT');
SET @questionQ2_2 = LAST_INSERT_ID();

-- Answers for Question 2
INSERT INTO `answer` (`answer`, `idQuestion`) VALUES
('June 2000', @questionQ2_2),
('May 2005', @questionQ2_2),
('July 2010', @questionQ2_2),
('March 2015', @questionQ2_2);

-- Set the correct answer for Question 2
INSERT INTO `correct_answer` (`idAns`, `idQuestion`) VALUES
(LAST_INSERT_ID(), @questionQ2_2);







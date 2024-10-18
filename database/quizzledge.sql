-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Okt 2023 um 21:56
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `quizzledge`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `answer`
--

CREATE TABLE `answer` (
  `idAns` int(11) NOT NULL,
  `answer` varchar(500) NOT NULL,
  `idQuestion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `correct_answer`
--

CREATE TABLE `correct_answer` (
  `idAns` int(11) NOT NULL,
  `idQuestion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `leaderboard`
--

CREATE TABLE `leaderboard` (
  `idLeaderboard` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `leaderboard`
--

INSERT INTO `leaderboard` (`idLeaderboard`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `online_quiz`
--

CREATE TABLE `online_quiz` (
  `categoryName` varchar(30) NOT NULL,
  `categoryIndex` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `idLeaderboard` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `online_quiz`
--

INSERT INTO `online_quiz` (`categoryName`, `categoryIndex`, `image`, `description`, `idLeaderboard`) VALUES
('Animals', 27, 'animals.jpg', 'Explore the animal kingdom with our quiz! From fierce predators to adorable pets, test your knowledge of Earth\'s diverse creatures.', 19),
('Anime & Manga', 31, 'anime.jpg', 'Immerse yourself in the world of anime and manga with our quiz! Test your knowledge of beloved series and iconic characters.', 23),
('Art', 25, 'art.jpg', 'Unleash your creativity with our art quiz! Explore famous artists, art movements, and diverse forms of artistic expression.', 17),
('Board Games', 16, 'boardgames.jpg', 'Roll the dice and challenge your board game expertise with our quiz! From classic to modern, test your tabletop gaming knowledge.', 10),
('Books', 10, 'books.jpg', 'Dive into the world of literature with our book quiz! Discover famous authors, classic novels, and literary trivia. Are you well-read?', 3),
('Cartoons & Animations', 32, 'cartoons.jpg', 'Step into the animated universe with our cartoons and animations quiz! Test your knowledge of classic and contemporary animated series.', 24),
('Celebrities', 26, 'celebrities.jpg', 'Test your celebrity knowledge with our quiz! From Hollywood icons to pop culture sensations, challenge your awareness of famous figures.', 18),
('Comics', 29, 'comics.jpg', 'Enter the colorful world of comics with our quiz! Explore iconic characters, superhero lore, and the art of graphic storytelling.', 21),
('Computers', 18, 'computers.jpg', 'Dive into tech with our computers quiz. Explore hardware, software, and digital concepts in this interactive challenge.', 12),
('Film', 11, 'film.jpg', 'Explore the magic of the silver screen with our film quiz! From classics to blockbusters, test your movie knowledge here.', 5),
('Gadgets', 30, 'gadgets.jpg', 'Dive into the world of gadgets with our quiz! Test your knowledge of tech innovations, smart devices, and cutting-edge technology.', 22),
('General Knowledge', 9, 'generalknowledge.jpg', 'Test your knowledge with our engaging general knowledge quiz! Explore a wide range of topics and challenge your intellect.', 1),
('Geography', 22, 'geography.jpg', 'Discover the world with our exciting geography quiz. Explore continents, countries, and landmarks in a global knowledge challenge.', 4),
('History', 23, 'history.jpg', 'Travel through time with our history quiz. Test your knowledge of historical events, figures, and eras.', 2),
('Mathematics', 19, 'mathematics.jpg', 'Sharpen your math skills with our quiz. Solve diverse problems and explore the world of numbers and logic.', 13),
('Music', 12, 'music.jpg', 'Get in tune with our music quiz! From rock \'n\' roll legends to chart-toppers, test your musical knowledge and groove on.', 6),
('Musical & Theaters', 13, 'musical.jpg', 'Get in tune with our music quiz! From rock \'n\' roll legends to chart-toppers, test your musical knowledge and groove on.', 7),
('Mythology', 20, 'mythology.jpg', 'Embark on a mythical journey with our quiz! Explore ancient gods, epic legends, and the fascinating world of mythology.', 14),
('Politics', 24, 'politics.jpg', 'Navigate the complex realm of politics with our quiz! Challenge your understanding of government systems, history, and current events.', 16),
('Science & Nature', 17, 'sciencenature.jpg', 'Explore the wonders of science and nature in our quiz! Test your knowledge of the natural world and scientific discoveries.', 11),
('Sports', 21, 'sports.jpg', 'Score big with our sports quiz! From iconic athletes to thrilling moments, test your knowledge of the wide world of sports.', 15),
('Television', 14, 'television.jpg', 'Dive into the world of television with our quiz! From classic sitcoms to binge-worthy dramas, test your TV show knowledge here.', 8),
('Vehicles', 28, 'vehicles.jpg', 'Rev up your engines with our vehicles quiz! Test your knowledge of cars, planes, and everything that moves on wheels or wings.', 20),
('Video Games', 15, 'videogames.jpg', 'Level up your knowledge in gaming. Join our video games quiz and test your gaming expertise today!', 9);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `private_quiz`
--

CREATE TABLE `private_quiz` (
  `idQuiz` varchar(16) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `creation_date` TIMESTAMP NOT NULL,
  `idLeaderboard` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question`
--

CREATE TABLE `question` (
  `idQuestion` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `idQuiz` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `score`
--

CREATE TABLE `score` (
  `idScore` int(11) NOT NULL,
  `correctAnswers` int(11) NOT NULL,
  `questionAmount` int(11) NOT NULL,
  `time` time NOT NULL,
  `idLeaderboard` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `score`
--

INSERT INTO `score` (`idScore`, `correctAnswers`, `questionAmount`, `time`, `idLeaderboard`, `userName`) VALUES
(12, 10, 10, '00:01:20', 1, 'Bird'),
(13, 9, 10, '00:02:30', 1, 'casio'),
(14, 8, 10, '00:04:50', 1, 'Clau'),
(15, 7, 10, '00:03:20', 1, 'Guasp'),
(16, 7, 10, '00:01:40', 1, 'Jordi'),
(17, 6, 10, '00:01:25', 1, 'Lexum'),
(18, 8, 10, '00:03:20', 1, 'Marti'),
(19, 4, 10, '00:02:20', 1, 'Mastic'),
(20, 2, 10, '00:11:30', 1, 'Otto'),
(21, 1, 10, '00:04:20', 1, 'Pere'),
(22, 0, 10, '00:07:20', 1, 'Seneca'),
(23, 9, 10, '00:01:20', 2, 'Bird'),
(24, 9, 10, '00:02:30', 2, 'Casio'),
(25, 10, 10, '00:04:50', 2, 'Clau'),
(26, 7, 10, '00:03:20', 2, 'Guasp'),
(27, 8, 10, '00:01:40', 2, 'Jordi'),
(28, 6, 10, '00:01:25', 2, 'Lexum'),
(29, 8, 10, '00:03:20', 2, 'Marti'),
(30, 4, 10, '00:02:20', 2, 'Mastic'),
(31, 2, 10, '00:11:30', 2, 'Otto'),
(32, 1, 10, '00:04:20', 2, 'Pere'),
(33, 0, 10, '00:07:20', 2, 'Seneca'),
(34, 10, 10, '00:00:00', 1, 'Bird'),
(35, 8, 10, '00:00:00', 1, 'Guasp'),
(36, 6, 10, '00:00:00', 1, 'Casio'),
(37, 4, 10, '00:00:00', 1, 'Pere'),
(38, 2, 10, '00:00:00', 1, 'Seneca'),
(39, 10, 10, '00:00:00', 2, 'Bird'),
(40, 8, 10, '00:00:00', 2, 'Guasp'),
(41, 6, 10, '00:00:00', 2, 'Casio'),
(42, 4, 10, '00:00:00', 2, 'Pere'),
(43, 2, 10, '00:00:00', 2, 'Seneca'),
(44, 10, 10, '00:00:00', 3, 'Bird'),
(45, 8, 10, '00:00:00', 3, 'Guasp'),
(46, 6, 10, '00:00:00', 3, 'Casio'),
(47, 4, 10, '00:00:00', 3, 'Pere'),
(48, 2, 10, '00:00:00', 3, 'Seneca'),
(49, 10, 10, '00:00:00', 4, 'Bird'),
(50, 8, 10, '00:00:00', 4, 'Guasp'),
(51, 6, 10, '00:00:00', 4, 'Casio'),
(52, 4, 10, '00:00:00', 4, 'Pere'),
(53, 2, 10, '00:00:00', 4, 'Seneca'),
(54, 10, 10, '00:00:00', 5, 'Bird'),
(55, 8, 10, '00:00:00', 5, 'Guasp'),
(56, 6, 10, '00:00:00', 5, 'Casio'),
(57, 4, 10, '00:00:00', 5, 'Pere'),
(58, 2, 10, '00:00:00', 5, 'Seneca'),
(59, 10, 10, '00:00:00', 6, 'Bird'),
(60, 8, 10, '00:00:00', 6, 'Guasp'),
(61, 6, 10, '00:00:00', 6, 'Casio'),
(62, 4, 10, '00:00:00', 6, 'Pere'),
(63, 2, 10, '00:00:00', 6, 'Seneca'),
(64, 10, 10, '00:00:00', 7, 'Bird'),
(65, 8, 10, '00:00:00', 7, 'Guasp'),
(66, 6, 10, '00:00:00', 7, 'Casio'),
(67, 4, 10, '00:00:00', 7, 'Pere'),
(68, 2, 10, '00:00:00', 7, 'Seneca'),
(69, 10, 10, '00:00:00', 8, 'Bird'),
(70, 8, 10, '00:00:00', 8, 'Guasp'),
(71, 6, 10, '00:00:00', 8, 'Casio'),
(72, 4, 10, '00:00:00', 8, 'Pere'),
(73, 2, 10, '00:00:00', 8, 'Seneca'),
(74, 10, 10, '00:00:00', 9, 'Bird'),
(75, 8, 10, '00:00:00', 9, 'Guasp'),
(76, 6, 10, '00:00:00', 9, 'Casio'),
(77, 4, 10, '00:00:00', 9, 'Pere'),
(78, 2, 10, '00:00:00', 9, 'Seneca'),
(79, 10, 10, '00:00:00', 10, 'Bird'),
(80, 8, 10, '00:00:00', 10, 'Guasp'),
(81, 6, 10, '00:00:00', 10, 'Casio'),
(82, 4, 10, '00:00:00', 10, 'Pere'),
(83, 2, 10, '00:00:00', 10, 'Seneca'),
(84, 10, 10, '00:00:00', 11, 'Bird'),
(85, 8, 10, '00:00:00', 11, 'Guasp'),
(86, 6, 10, '00:00:00', 11, 'Casio'),
(87, 4, 10, '00:00:00', 11, 'Pere'),
(88, 2, 10, '00:00:00', 11, 'Seneca'),
(89, 10, 10, '00:00:00', 12, 'Bird'),
(90, 8, 10, '00:00:00', 12, 'Guasp'),
(91, 6, 10, '00:00:00', 12, 'Casio'),
(92, 4, 10, '00:00:00', 12, 'Pere'),
(93, 2, 10, '00:00:00', 12, 'Seneca'),
(94, 10, 10, '00:00:00', 13, 'Bird'),
(95, 8, 10, '00:00:00', 13, 'Guasp'),
(96, 6, 10, '00:00:00', 13, 'Casio'),
(97, 4, 10, '00:00:00', 13, 'Pere'),
(98, 2, 10, '00:00:00', 13, 'Seneca'),
(99, 10, 10, '00:00:00', 14, 'Bird'),
(100, 8, 10, '00:00:00', 14, 'Guasp'),
(101, 6, 10, '00:00:00', 14, 'Casio'),
(102, 4, 10, '00:00:00', 14, 'Pere'),
(103, 2, 10, '00:00:00', 14, 'Seneca'),
(104, 10, 10, '00:00:00', 15, 'Bird'),
(105, 8, 10, '00:00:00', 15, 'Guasp'),
(106, 6, 10, '00:00:00', 15, 'Casio'),
(107, 4, 10, '00:00:00', 15, 'Pere'),
(108, 2, 10, '00:00:00', 15, 'Seneca'),
(109, 10, 10, '00:00:00', 16, 'Bird'),
(110, 8, 10, '00:00:00', 16, 'Guasp'),
(111, 6, 10, '00:00:00', 16, 'Casio'),
(112, 4, 10, '00:00:00', 16, 'Pere'),
(113, 2, 10, '00:00:00', 16, 'Seneca'),
(114, 10, 10, '00:00:00', 17, 'Bird'),
(115, 8, 10, '00:00:00', 17, 'Guasp'),
(116, 6, 10, '00:00:00', 17, 'Casio'),
(117, 4, 10, '00:00:00', 17, 'Pere'),
(118, 2, 10, '00:00:00', 17, 'Seneca'),
(119, 10, 10, '00:00:00', 18, 'Bird'),
(120, 8, 10, '00:00:00', 18, 'Guasp'),
(121, 6, 10, '00:00:00', 18, 'Casio'),
(122, 4, 10, '00:00:00', 18, 'Pere'),
(123, 2, 10, '00:00:00', 18, 'Seneca'),
(124, 10, 10, '00:00:00', 19, 'Bird'),
(125, 8, 10, '00:00:00', 19, 'Guasp'),
(126, 6, 10, '00:00:00', 19, 'Casio'),
(127, 4, 10, '00:00:00', 19, 'Pere'),
(128, 2, 10, '00:00:00', 19, 'Seneca'),
(129, 10, 10, '00:00:00', 20, 'Bird'),
(130, 8, 10, '00:00:00', 20, 'Guasp'),
(131, 6, 10, '00:00:00', 20, 'Casio'),
(132, 4, 10, '00:00:00', 20, 'Pere'),
(133, 2, 10, '00:00:00', 20, 'Seneca'),
(134, 10, 10, '00:00:00', 21, 'Bird'),
(135, 8, 10, '00:00:00', 21, 'Guasp'),
(136, 6, 10, '00:00:00', 21, 'Casio'),
(137, 4, 10, '00:00:00', 21, 'Pere'),
(138, 2, 10, '00:00:00', 21, 'Seneca'),
(139, 10, 10, '00:00:00', 22, 'Bird'),
(140, 8, 10, '00:00:00', 22, 'Guasp'),
(141, 6, 10, '00:00:00', 22, 'Casio'),
(142, 4, 10, '00:00:00', 22, 'Pere'),
(143, 2, 10, '00:00:00', 22, 'Seneca'),
(144, 10, 10, '00:00:00', 23, 'Bird'),
(145, 8, 10, '00:00:00', 23, 'Guasp'),
(146, 6, 10, '00:00:00', 23, 'Casio'),
(147, 4, 10, '00:00:00', 23, 'Pere'),
(148, 2, 10, '00:00:00', 23, 'Seneca'),
(149, 10, 10, '00:00:00', 24, 'Bird'),
(150, 8, 10, '00:00:00', 24, 'Guasp'),
(151, 6, 10, '00:00:00', 24, 'Casio'),
(152, 4, 10, '00:00:00', 24, 'Pere'),
(153, 2, 10, '00:00:00', 24, 'Seneca');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userName` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `avatar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userName`, `password`, `email`, `avatar`) VALUES
('Bird', '2', 'something@gmail.com', 'icon2.png'),
('Casio', '3', 'something@gmail.com', 'icon3.png'),
('Clau', '11', 'something@gmail.com', 'icon3.png'),
('Guasp', '10', 'something@gmail.com', 'icon2.png'),
('Jordi', '5', 'something@gmail.com', 'icon5.png'),
('Lexum', '4', 'something@gmail.com', 'icon4.png'),
('Marti', '8', 'something@gmail.com', 'icon8.png'),
('Mastic', '7', 'something@gmail.com', 'icon7.png'),
('Otto', '1', 'something@gmail.com', 'icon.png'),
('Pere', '6', 'something@gmail.com', 'icon6.png'),
('Seneca', '9', 'something@gmail.com', 'icon.png');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`idAns`),
  ADD KEY `idQuestion` (`idQuestion`);

--
-- Indizes für die Tabelle `correct_answer`
--
ALTER TABLE `correct_answer`
  ADD PRIMARY KEY (`idAns`,`idQuestion`),
  ADD KEY `idQuestion` (`idQuestion`),
  ADD KEY `idAns` (`idAns`);

--
-- Indizes für die Tabelle `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`idLeaderboard`);

--
-- Indizes für die Tabelle `online_quiz`
--
ALTER TABLE `online_quiz`
  ADD PRIMARY KEY (`categoryName`),
  ADD KEY `idLeaderboard` (`idLeaderboard`);

--
-- Indizes für die Tabelle `private_quiz`
--
ALTER TABLE `private_quiz`
  ADD PRIMARY KEY (`idQuiz`),
  ADD KEY `idLeaderboard` (`idLeaderboard`),
  ADD KEY `userName` (`userName`);

--
-- Indizes für die Tabelle `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`idQuestion`),
  ADD KEY `idQuiz` (`idQuiz`);

--
-- Indizes für die Tabelle `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`idScore`),
  ADD KEY `idLeaderboard` (`idLeaderboard`),
  ADD KEY `userName` (`userName`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userName`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answer`
--
ALTER TABLE `answer`
  MODIFY `idAns` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `idLeaderboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `question`
--
ALTER TABLE `question`
  MODIFY `idQuestion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `score`
--
ALTER TABLE `score`
  MODIFY `idScore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`idQuestion`) REFERENCES `question` (`idQuestion`);

--
-- Constraints der Tabelle `correct_answer`
--
ALTER TABLE `correct_answer`
  ADD CONSTRAINT `correct_answer_ibfk_1` FOREIGN KEY (`idQuestion`) REFERENCES `question` (`idQuestion`),
  ADD CONSTRAINT `correct_answer_ibfk_2` FOREIGN KEY (`idAns`) REFERENCES `answer` (`idAns`);

--
-- Constraints der Tabelle `online_quiz`
--
ALTER TABLE `online_quiz`
  ADD CONSTRAINT `online_quiz_ibfk_1` FOREIGN KEY (`idLeaderboard`) REFERENCES `leaderboard` (`idLeaderboard`);

--
-- Constraints der Tabelle `private_quiz`
--
ALTER TABLE `private_quiz`
  ADD CONSTRAINT `private_quiz_ibfk_1` FOREIGN KEY (`idLeaderboard`) REFERENCES `leaderboard` (`idLeaderboard`),
  ADD CONSTRAINT `private_quiz_ibfk_2` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`);

--
-- Constraints der Tabelle `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`idQuiz`) REFERENCES `private_quiz` (`idQuiz`);

--
-- Constraints der Tabelle `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`idLeaderboard`) REFERENCES `leaderboard` (`idLeaderboard`),
  ADD CONSTRAINT `userName` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Private quiz section
--

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
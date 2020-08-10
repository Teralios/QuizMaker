DROP TABLE IF EXISTS wcf1_quiz;
CREATE TABLE wcf1_quiz (
    quizID INT(10) NOT NULL auto_increment PRIMARY KEY,
    languageID INT(10) NULL,
    creationDate INT(10) NOT NULL DEFAULT 0,
    mediaID INT(10) NULL,
    type ENUM('fun', 'competition') DEFAULT 'fun',
    title VARCHAR(100) NOT NULL DEFAULT '',
    description TEXT,
    isActive TINYINT(1) NOT NULL DEFAULT 0,
    questions SMALLINT(3) NOT NULL DEFAULT 0,
    goals SMALLINT(3) NOT NULL DEFAULT 0,
    KEY (title),
    KEY (creationDate),
    KEY (languageID),
    KEY (languageID, isActive)
);

DROP TABLE IF EXISTS wcf1_quiz_game;
CREATE TABLE wcf1_quiz_game (
    gameID INT(10) NOT NULL auto_increment PRIMARY KEY,
    quizID INT(10) NOT NULL,
    userID INT(10) NOT NULL,
    playedTime INT(10) NOT NULL,
    score SMALLINT(4) NOT NULL DEFAULT 0,
    result MEDIUMTEXT,
    UNIQUE KEY (quizID, userID),
    KEY (quizID),
    KEY (score),
    KEY (userID),
    KEY (playedTime)
);

DROP TABLE IF EXISTS wcf1_quiz_goal;
CREATE TABLE wcf1_quiz_goal (
    goalID INT(10) NOT NULL auto_increment PRIMARY KEY,
    quizID INT(10) NOT NULL,
    points SMALLINT(10) NOT NULL DEFAULT 0,
    title VARCHAR(100),
    icon VARCHAR(50) NOT NULL DEFAULT '',
    description TEXT,
    KEY (quizID),
    KEY (quizID, points)
);

DROP TABLE IF EXISTS wcf1_quiz_question;
CREATE TABLE wcf1_quiz_question (
    questionID INT(10) NOT NULL auto_increment PRIMARY KEY,
    quizID INT(10) NOT NULL,
    position SMALLINT(3),
    question VARCHAR(100),
    optionA VARCHAR(100),
    optionB VARCHAR(100),
    optionC VARCHAR(100),
    optionD VARCHAR(100),
    explanation TEXT,
    answer ENUM('A', 'B', 'C', 'D'),
    KEY (quizID),
    KEY (position)
);

-- foreign keys
ALTER TABLE wcf1_quiz ADD FOREIGN KEY (languageID) REFERENCES wcf1_language (languageID) ON DELETE SET NULL;
ALTER TABLE wcf1_quiz ADD FOREIGN KEY (mediaID) REFERENCES wcf1_media (mediaID) ON DELETE SET NULL;
ALTER TABLE wcf1_quiz_game ADD FOREIGN KEY (quizID) REFERENCES wcf1_quiz (quizID) ON DELETE CASCADE;
ALTER TABLE wcf1_quiz_game ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE wcf1_quiz_goal ADD FOREIGN KEY (quizID) REFERENCES wcf1_quiz (quizID) ON DELETE CASCADE;
ALTER TABLE wcf1_quiz_question ADD FOREIGN KEY (quizID) REFERENCES wcf1_quiz (quizID) ON DELETE CASCADE;
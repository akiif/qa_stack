CREATE DATABASE IF NOT EXISTS qa_stack;
USE qa_stack;

CREATE TABLE IF NOT EXISTS users (
	user_id INTEGER NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    
    PRIMARY KEY(user_id)
    );
    
CREATE TABLE IF NOT EXISTS questions (
	q_id INTEGER NOT NULL AUTO_INCREMENT,
    content LONGTEXT,
    date_time DATETIME,
    user_id INTEGER NOT NULL,
    
    PRIMARY KEY(q_id),
    
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
    );
    
CREATE TABLE IF NOT EXISTS topics (
	topic_id INTEGER NOT NULL AUTO_INCREMENT,
	topic_name VARCHAR(100) UNIQUE,
        
	PRIMARY KEY (topic_id)
	);
    
CREATE TABLE IF NOT EXISTS answers (
	ans_id INTEGER NOT NULL AUTO_INCREMENT,
    q_id INTEGER NOT NULL,
    ans_content LONGTEXT,
    date_time DATETIME,
    likes INTEGER DEFAULT 0,
    dislikes INTEGER DEFAULT 0,
    user_id INTEGER NOT NULL,
    
    PRIMARY KEY (ans_id),
    
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
        
	CONSTRAINT FOREIGN KEY (q_id) REFERENCES questions (q_id)
        ON DELETE CASCADE ON UPDATE CASCADE
	);
    
    
    
    

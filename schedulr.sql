
CREATE TABLE USER(
	FIRST_NAME VARCHAR(30),
	LAST_NAME VARCHAR(30),
    EMAIL VARCHAR(60),
    PASSWORD VARCHAR(20),
    PRIMARY KEY (EMAIL)
)ENGINE=INNODB;

INSERT INTO USER VALUES("Mark", "Clinton", "mark@gmail.com", "12345");
INSERT INTO USER VALUES("john", "doe", "john@gmail.com", "12345");

CREATE TABLE TASKS (
	TASK_ID INTEGER AUTO_INCREMENT,
	TASK_NAME VARCHAR(30),
	ADMIN VARCHAR(60),
	TASK_INFO TEXT,
	TASK_DATE DATE,
	START_TIME TIME,
	END_TIME TIME,
	PRIMARY KEY(TASK_ID),
	FOREIGN KEY fk_task (ADMIN) REFERENCES USER (EMAIL) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

INSERT INTO TASKS VALUES (NULL, "Meeting", "mark@gmail.com", "Meeting with lawyer", "30-01-2017", "15:00", "16:00");
INSERT INTO TASKS VALUES (NULL, "Meeting", "mark@gmail.com", "Meeting with lawyer", "30-01-2017", "15:00", "16:00");
INSERT INTO TASKS VALUES (NULL, "Meeting", "mark@gmail.com", "Meeting with lawyer", "30-01-2017", "15:00", "16:00");
INSERT INTO TASKS VALUES (NULL, "Meeting", "mark@gmail.com", "Meeting with lawyer", "30-01-2017", "15:00", "16:00");
INSERT INTO TASKS VALUES (NULL, "Meeting", "john@gmail.com", "Meeting with lawyer", "30-01-2017", "15:00", "16:00");


CREATE TABLE SHARE (
	EMAIL VARCHAR(60),
	TASK_ID INTEGER,
	PRIMARY KEY (EMAIL, TASK_ID),
	FOREIGN KEY fk_task (TASK_ID) REFERENCES TASKS (TASK_ID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY fk_contributor (EMAIL) REFERENCES USER (EMAIL) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=INNODB;


INSERT INTO SHARE VALUES ("mark@gmail.com", 1);
INSERT INTO SHARE VALUES ("john@gmail.com", 1);




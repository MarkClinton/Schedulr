CREATE TABLE users(
	id INTEGER AUTO_INCREMENT,
	first_name VARCHAR(30),
	last_name VARCHAR(30),
    email VARCHAR(60),
    password VARCHAR(20),
    is_locked INTEGER,
    is_verified INTEGER,
    created_at DATETIME,
    updated_at DATETIME,
    last_accessed DATETIME,
    img_url VARCHAR(100),
    PRIMARY KEY (id, email),
    UNIQUE KEY users_email_unique (EMAIL)
)ENGINE=INNODB;

CREATE TABLE tasks (
	id INTEGER AUTO_INCREMENT,
	user_id INTEGER,
	name VARCHAR(30),
	info TEXT,
	task_date DATE,
	start_time TIME,
	end_time TIME,
	status INTEGER,
	created_at DATETIME,
	updated_at DATETIME,
	is_deleted INTEGER,
	PRIMARY KEY(id),
	FOREIGN KEY fk_task (user_id) REFERENCES users (id)
) ENGINE=INNODB;

CREATE TABLE task_status (
	id INTEGER,
	status VARCHAR(30)
) ENGINE=INNODB;

CREATE TABLE group_tasks (
	id INTEGER AUTO_INCREMENT,
	task_id INTEGER,
	shared_with INTEGER,
	is_deleted INTEGER,
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY (id),
	FOREIGN KEY fk_task_id (task_id) REFERENCES tasks (id),
	FOREIGN KEY fk_contributor (shared_with) REFERENCES users (id) 
)ENGINE=INNODB;

CREATE TABLE friends (
	user_id INTEGER,
	friend_id INTEGER,
	status INTEGER,
	created_at DATETIME,
	is_deleted INTEGER,
	PRIMARY KEY (user_id, friend_id),
	FOREIGN KEY fk_user_id (user_id) REFERENCES users (id),
	FOREIGN KEY fk_friend_id (friend_id) REFERENCES users (id)
)ENGINE=INNODB;

CREATE TABLE friends_status (
	id INTEGER,
	status VARCHAR(30)
) ENGINE=INNODB;

CREATE TABLE task_media (
	id INTEGER AUTO_INCREMENT,
	task_id INTEGER,
	user_id INTEGER,
	file_url VARCHAR(100),
	is_deleted INTEGER,
	created_at DATETIME,
	updated_at DATETIME,
	PRIMARY KEY (id),
	FOREIGN KEY fk_task_id_media (task_id) REFERENCES tasks (id),
	FOREIGN KEY fk_contributor_media (user_id) REFERENCES users (id) 
) ENGINE=INNODB;

CREATE TABLE location (
    id int AUTO_INCREMENT NOT NULL,
    name VARCHAR(60) NOT NULL ,
    address VARCHAR(80) NOT NULL ,
    lat DECIMAL(10, 8) NOT NULL,
    lng DECIMAL(11, 8) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE recover (
	id INTEGER,
	used INTEGER,
    token VARCHAR(100),
    expr_date DATETIME,
    PRIMARY KEY (id, token),
) ENGINE=INNODB;












CREATE TABLE users(
id int PRIMARY KEY AUTO_INCREMENT,
username varchar(100) not null,
password varchar(255) not null,
name varchar(100) not null,
role ENUM('user','admin') DEFAULT 'user',
photo varchar(255) NOT null
);

CREATE TABLE categories(
id int PRIMARY KEY AUTO_INCREMENT,
name varchar(200) not null,
color varchar(10) not null);

CREATE TABLE tasks(
id int PRIMARY KEY AUTO_INCREMENT,
description varchar(200) not null,
status ENUM('pending','in_progress','completed') DEFAULT 'pending',
comment text ,
id_user int not null,
id_category int not null,
FOREIGN KEY (id_user) REFERENCES users(id) on DELETE CASCADE on UPDATE CASCADE,
FOREIGN KEY (id_category) REFERENCES categories(id)on DELETE CASCADE on UPDATE CASCADE
);

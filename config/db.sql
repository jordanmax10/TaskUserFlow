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
    status ENUM('Pendiente','En_proceso','Completada') DEFAULT 'Pendiente',
    comment text ,
    id_user int not null,
    id_category int not null,
    FOREIGN KEY (id_user) REFERENCES users(id) on DELETE CASCADE on UPDATE CASCADE,
    FOREIGN KEY (id_category) REFERENCES categories(id)on DELETE CASCADE on UPDATE CASCADE
    );

    Insert into users(username,password,name,role,photo) values('admin','$2y$10$Euva77y7VrZyoohfNjIhkOX3sIv3c4//W/o0kLr.S/BwBOs9MgHEC','admin','admin','be16d1421133d28e2db63a14ffe6f04b.png');

    Insert into categories(name,color) values('Trabajo','#FF5733');
    Insert into categories(name,color) values('Personal','#33FF57');
    Insert into categories(name,color) values('Estudio','#5733FF');
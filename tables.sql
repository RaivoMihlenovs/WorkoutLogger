CREATE TABLE workout (
	id int not null AUTO_INCREMENT,
    name varchar(255) not null,
    userId int not null,
    PRIMARY KEY(id), FOREIGN KEY(userId) REFERENCES users (id)
);

CREATE TABLE exercise (
    id int not null AUTO_INCREMENT,
	name varchar(255) not null,
    sets int not null,
    reps int not null,
    weight int not null,
    workoutId int not null,
    PRIMARY KEY(id), FOREIGN KEY(workoutId) REFERENCES workout (id) ON DELETE CASCADE 
);
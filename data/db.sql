CREATE TABLE "User" (
    id SERIAL PRIMARY KEY ,
    login VARCHAR UNIQUE NOT NULL ,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    isAdmin boolean NOT NULL,
    ects integer NOT NULL
);

CREATE TABLE Game (
   id SERIAL PRIMARY KEY,
   createdAt date default now(),
   id_j1 integer REFERENCES "User"(id),
   id_j2 integer REFERENCES "User"(id),
   status VARCHAR NOT NULL,
   cards JSON,
   messages JSON,
   id_winner integer REFERENCES "User"(id),
   po integer NOT NULL
);

Create table Category (
	id serial primary key,
	attack integer NOT NULL,
	defence integer NOT NULL,
	type varchar NOT NULL,
	cost integer NOT NULL,
	chance float NOT NULL
);

Create table Unit(
	id integer primary key,
	name varchar NOT NULL,
	id_cat integer references category(id),
	AtckBonus integer default 0,
	DefBonus integer default 0,
	chanceBonus float default 0,
	description varchar NOT NULL
);

INSERT INTO Category(id,attack,defence,type,cost,chance) VALUES (1,0,8,'Mur',8,0.9);
INSERT INTO Category(id,attack,defence,type,cost,chance) VALUES (2,5,2,'Soldat',6,0.85);
INSERT INTO Category(id,attack,defence,type,cost,chance) VALUES (3,2,4,'Etudiant',7,0.9);
INSERT INTO Category(id,attack,defence,type,cost,chance) VALUES (4,7,5,'Professeur',7,0.6);

INSERT INTO Unit(id,name,id_cat,description) VALUES(1,'Mur',1,'Mur Description');
INSERT INTO Unit(id,name,id_cat,description) VALUES(3,'Soldat',2,'Soldat Description');
INSERT INTO Unit(id,name,id_cat,description) VALUES(5,'Eleve1',3,'Etudiant Description');
INSERT INTO Unit(id,name,id_cat,description) VALUES(6,'Eleve2',3,'Etudiant Description');
INSERT INTO Unit(id,name,id_cat,description) VALUES(9,'Prof1',4,'Professeur Description');
INSERT INTO Unit(id,name,id_cat,description) VALUES(10,'Prof2',4,'Professeur Description');



INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('kevin','test','test@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('toto','test','toto@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('paul','test','test@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('dragodia','test','toto@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('luke','test','test@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('omar','test','toto@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('immo','test','test@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('boulet','test','toto@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('michou','test','test@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('titi','test','toto@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('lili','test','test@gmail.com',true,0);
INSERT INTO "User"(login,password,email,isAdmin,ects) VALUES('bibicheDu28','test','toto@gmail.com',true,0);


INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(1,2,'terminé',2,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(1,2,'terminé',1,50);

INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(1,2,'terminé',2,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(1,2,'terminé',1,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(3,4,'terminé',4,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(5,8,'terminé',8,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(4,7,'terminé',4,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(5,8,'terminé',5,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(10,11,'terminé',11,50);
INSERT INTO Game(id_j1,id_j2,status,id_winner,po) VALUES(11,12,'terminé',11,50);


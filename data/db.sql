CREATE TABLE "User" (
    id SERIAL PRIMARY KEY ,
    login VARCHAR NOT NULL ,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    isAdmin boolean NOT NULL,
    ects integer NOT NULL
);

CREATE TABLE "Game" (
   id SERIAL PRIMARY KEY,
   id_j1 integer REFERENCES User(id),
   id_j2 integer REFERENCES User(id),
   status VARCHAR NOT NULL,
   cartes VARCHAR NOT NULL,
   message VARCHAR NOT NULL,
   id_winner integer REFERENCES User(id),
   po integer NOT NULL
);

Create table category (
	id serial primary key,
	attack integer,
	defence integer,
	type varchar,
	cost integer,
	chance float
);
Create table Unit(
	name varchar,
	id_cat integer references category(id),
	AtckBonus integer,
	DefBonus integer,
	chanceBonus float,
	description varchar
);
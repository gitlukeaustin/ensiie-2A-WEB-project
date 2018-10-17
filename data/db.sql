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

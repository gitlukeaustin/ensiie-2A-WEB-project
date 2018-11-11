CREATE TABLE "User" (
    id SERIAL PRIMARY KEY ,
    login VARCHAR UNIQUE NOT NULL ,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    isAdmin boolean NOT NULL,
    ects integer NOT NULL,
    isActif boolean NOT NULL
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



INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('kevin','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','test@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('toto','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','toto@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('paul','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','test@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('dragodia','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','toto@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('luke','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','test@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('omar','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','toto@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('immo','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','test@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('boulet','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','toto@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('michou','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','test@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('titi','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','toto@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('lili','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','test@gmail.com',true,0,true);
INSERT INTO "User"(login,password,email,isAdmin,ects, isActif) VALUES('bibicheDu28','$2y$10$m/tJzLfW/fMpA/fmeVSyuOFHOmsC7eLnLA3WmcHDQ76Cy9kV2L14i','toto@gmail.com',true,0,true);


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

CREATE OR REPLACE FUNCTION find_game(idj1 INTEGER) 
RETURNS TABLE (
   id integer,
   createdAt date,
   id_j1 integer,
   id_j2 integer,
   status VARCHAR,
   cards JSON,
   messages JSON,
   id_winner integer ,
   po integer
)
AS $$
DECLARE
    gid integer;
BEGIN
    DELETE FROM Game g WHERE g.id_j1 = idj1 AND g.id_j2 IS NULL;


    SELECT g.id INTO gid FROM Game g WHERE g.id_j2 IS NULL LIMIT 1 FOR UPDATE;
    IF gid is NULL THEN
        INSERT INTO Game (id_j1,status,po) values(idj1, ' ', 50 );
        SELECT g.id INTO gid FROM Game g WHERE g.id_j1 = idj1 AND g.id_j2 IS NULL;
    ELSE
        UPDATE Game SET id_j2 = idj1 WHERE Game.id = gid;
    END IF;
    RETURN QUERY SELECT 
    cast(g.id as integer),
    g.createdAt,
    g.id_j1,
    g.id_j2,
    g.status,
    g.cards,
    g.messages,
    g.id_winner,
    g.po  
    FROM Game g WHERE g.id = gid;
END;
$$ LANGUAGE plpgsql;

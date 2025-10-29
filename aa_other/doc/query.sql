use honoStephDB;

-- -------------------------------------
-- ----------- CREATE TABLES -----------
-- -------------------------------------

create table compte (
    id int not null auto_increment,
    uuid char(80) not null default (UUID()),
    nom varchar(255) not null,
    prenom varchar(255) not null,
    mail varchar(255) not null unique,
    naissance date not null,
    tel varchar(255) not null unique,
	adresse VARCHAR(255) not null,

	salt char(64) not null,
    password char(63) not null,

    created_at TIMESTAMP not null default CURRENT_TIMESTAMP,
    updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	last_connection TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY (uuid)
);

select * from compte;

create table type_adhesion (
    id int not null auto_increment,
    libelle varchar(255) not null,
    prix float(6,2) not null,
    description varchar(255) not null,
    duree int not null,

    created_at TIMESTAMP not null default CURRENT_TIMESTAMP,
    updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY(id)
    
);

CREATE TABLE famille (
    id int not null auto_increment,
    fk_compte int not null,


    created_at TIMESTAMP not null default CURRENT_TIMESTAMP,
    updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    primary key (id, fk_compte),

    FOREIGN KEY (fk_compte) REFERENCES compte(id) on delete cascade
);
drop table famille;

CREATE TABLE membre_famille(
    id int not null auto_increment,   
    uuid char(80) not null default (UUID()),
    nom varchar(255) not null,
    prenom varchar(255) not null,
    naissance date not null,

    fk_famille int not null,

    created_at TIMESTAMP not null default CURRENT_TIMESTAMP,
    updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY (uuid),

    FOREIGN KEY (fk_famille) REFERENCES famille(id) on delete cascade
);

drop table membre_famille;

CREATE TABLE adhesion(
    id int not null auto_increment,
    fk_type_adhesion int not null,
    fk_compte int not null,

    payed_at date default null,

    created_at TIMESTAMP not null default CURRENT_TIMESTAMP,
    updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    primary key (id),
    FOREIGN KEY (fk_type_adhesion) REFERENCES type_adhesion(id) on delete cascade,
    FOREIGN KEY (fk_compte) REFERENCES compte(id) on delete cascade
);


drop table adhesion_parrainee;
CREATE TABLE adhesion_parrainee(
    id int not null auto_increment,
    fk_type_adhesion int not null,
    fk_membre_famille int not null,
    fk_compte int not null,

	payed_at date default null,

    created_at TIMESTAMP not null default CURRENT_TIMESTAMP,
    updated_at TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    primary key (id),
    FOREIGN KEY (fk_type_adhesion) REFERENCES type_adhesion(id) on delete cascade,
    FOREIGN KEY (fk_membre_famille) REFERENCES membre_famille(id) on delete cascade,
    FOREIGN KEY (fk_compte) REFERENCES compte(id) on delete cascade
);

-- -------------------------------------
-- ----------- INSERT TABLES -----------
-- -------------------------------------

INSERT INTO compte (nom, prenom, mail, naissance, tel, password) 
VALUES  ("nomTest", "prenomTest", "emailTest@gmail.com", "2000-01-01", "0606060606", "123456"),
        ("nomTest2", "prenomTest2", "emailTest2@gmail.com", "2000-01-01", "0606060606", "123456"),
        ("nomTest3", "prenomTest3", "emailTest3@gmail.com", "2000-01-01", "0606060606", "123456"),
        ("nomTest4", "prenomTest4", "emailTest4@gmail.com", "2000-01-01", "0606060606", "123456");


INSERT INTO type_adhesion (libelle, prix, description, duree)
VALUES  ("Annuel Adulte", 50, "reserve au plus de 12 ans", 365),
        ("Annuel Enfant", 30, "reserve au moins de 12 ans", 365),
        ("Annuel Famille", 90, "4 personnes maximum", 365),
        ("Pass une jounee", 10, "une seule personne pour une journee", 1);

INSERT INTO famille (fk_compte)
VALUES  (1),
        (2);

INSERT INTO membre_famille (nom, prenom, naissance, fk_famille)
VALUES  ("nomTestMembre4", "prenomTestMembre4", "2000-01-01", 6);

INSERT INTO adhesion (fk_type_adhesion, fk_compte)
VALUES  (1, 3);

INSERT INTO adhesion_parrainee (fk_type_adhesion, fk_membre_famille, fk_compte)
VALUES  (2, 3, 2),
		(2, 4, 3);


-- -------------------------------------
-- --------- SELECT *  TABLES ----------
-- -------------------------------------

SELECT * from compte;
SELECT * from type_adhesion;
SELECT * from famille;
delete from famille where id between 0 and 10000000;
SELECT * from membre_famille;
SELECT * from adhesion;	
SELECT * from adhesion_parrainee;

describe adhesion;
-- -------------------------------------
-- -------- SPEC SELECT TABLES ---------
-- -------------------------------------

-- le compte id 1 est relié à la famille id 1 avec les membres id (1, 2) avec l adhesion id 3 (annuel famille)
-- le compte id 2 est relié à la famille id 2 avec les membres id (3, 4) avec l adhesion id 2 pour membre id 3 

-- compte id 1 => uuid "a278a511-a9fd-11f0-8844-00e04c36042d"
-- compte id 2 => uuid "b0683a47-a9fe-11f0-8844-00e04c36042d"

-- membre id 1 => uuid "2e07425d-a9ff-11f0-8844-00e04c36042d"
-- membre id 2 => uuid "2e074dee-a9ff-11f0-8844-00e04c36042d"
-- membre id 3 => uuid "2e075241-a9ff-11f0-8844-00e04c36042d"
-- membre id 4 => uuid "2e0755c0-a9ff-11f0-8844-00e04c36042d"

-- recupere l'ahdesion de la famille par l'uuid du compte id 1 ("a278a511-a9fd-11f0-8844-00e04c36042d")
Select c.id as compte, c.uuid, a.id as id_adhsion, fk_type_adhesion as type_id, nom, prenom, ta.libelle as nom_adhesion
from compte c
Join adhesion a on a.fk_compte = c.id 
Join type_adhesion ta on a.fk_type_adhesion = ta.id
where c.uuid = "a278a511-a9fd-11f0-8844-00e04c36042d";

-- recupere l'ahdesion de la famille par l'uuid du membre id 2 ("2e074dee-a9ff-11f0-8844-00e04c36042d") as son parrain
select mf.nom as nom_membre, mf.prenom as prenom_membre, mf.naissance as naissance_membre, mf.uuid, c.nom as parrain_nom, c.prenom as parrain_prenom, c.naissance as parrain_naissance, ta.libelle as nom_adhesion
from membre_famille mf
join famille f on f.id = mf.fk_famille
join compte c on c.id = f.fk_compte
join adhesion a on a.fk_compte = c.id
join type_adhesion ta on a.fk_type_adhesion = ta.id
where mf.uuid = "2e074dee-a9ff-11f0-8844-00e04c36042d";

-- recuperer tt les membres d'une famille par l'uuid du compte id 1 "a278a511-a9fd-11f0-8844-00e04c36042d"

(select nom, prenom, "pere" as role
from compte c
join famille f on f.fk_compte = c.id
where c.uuid = "a278a511-a9fd-11f0-8844-00e04c36042d")
union all
(select nom, prenom, "membre" as role
from membre_famille
where fk_famille = (select f.id 
from compte c
join famille f on f.fk_compte = c.id
where c.uuid = "a278a511-a9fd-11f0-8844-00e04c36042d"));

-- recupere l'ahdesion parrainee du membre id 3 "2e075241-a9ff-11f0-8844-00e04c36042d" et son parrain id 2

select mf.uuid, mf.nom as nomMembre, mf.prenom as prenomMembre, mf.naissance as naissMembre, ta.libelle as adhesion, 
		ap.payed_at as datePayement, verifyMembershipValidity(ap.payed_at, ta.duree) as validity, c.nom as nomCompte, 
        c.prenom as prenomCompte, c.naissance as naissCompte
from membre_famille mf
join adhesion_parrainee ap on ap.fk_membre_famille = mf.id
join type_adhesion ta on ta.id = ap.fk_type_adhesion
join compte c on c.id = ap.fk_compte
where mf.uuid = "2e075241-a9ff-11f0-8844-00e04c36042d";




    (select nom, prenom, 'vous' as role, calculateAge(naissance)
                            from compte c
                            join famille f on f.fk_compte = c.id
                            where c.id = 9)
                            union all
                            (select nom, prenom, 'membre' as role, calculateAge(naissance)
                            from membre_famille
                            where fk_famille = (select f.id 
                            from compte c
                            join famille f on f.fk_compte = c.id
                            where c.id = 9));


select count(mf.id) 
from membre_famille mf
join famille f on f.id = mf.fk_famille
join compte c on c.id = f.fk_compte
where c.id = 9;



(select c.id, nom, prenom, 'vous' as role, calculateAge(naissance) as age
from compte c
join famille f on f.fk_compte = c.id
where c.id = 9)
union all
(select mf.id, nom, prenom, 'membre' as role, calculateAge(naissance) as age
from membre_famille mf
where fk_famille = (select f.id 
from compte c
join famille f on f.fk_compte = c.id
where c.id = 9));

select a.id, t.libelle, a.created_at as date, verifyMemberShipValidity(a.payed_at, t.duree) as validity
from adhesion a 
join type_adhesion t on t.id = a.fk_type_adhesion
where fk_compte = 6;

select ap.id, t.libelle, mf.nom, mf.prenom, ap.created_at as date, verifyMemberShipValidity(ap.payed_at, t.duree) as validity
from adhesion_parrainee ap
join type_adhesion t on t.id = ap.fk_type_adhesion
join membre_famille mf on mf.id = ap.fk_membre_famille
where fk_compte = 6;

select mf.id
from compte c
join famille f on f.fk_compte = c.id
join membre_famille mf on mf.fk_famille = f.id 
where c.id = 6 and mf.id=110;

select id
from adhesion 
where fk_compte=6 and id = 188;




select verifyHashPassword("poipoi", salt, password) as validity
from compte
where id = 13;
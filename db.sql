create database Rev2;

drop table Rev2.user;
create table Rev2.user(
id int primary key not null auto_increment,
nom varchar(30),
prenom varchar(30),
email varchar(40) not null unique,
password varchar(40) ,
role enum("user","admin","superAdmin") default "user"
);
use user;
insert into Rev2.user(nom,prenom,email,password,role) values("Azzedine","zemmari","azzedine@gmail.com","azzedine2004","superAdmin");
insert into Rev2.user(nom,prenom,email,password,role) values("Ilyass","Bahsi","ilyass@gmail.com","ilyas2000","admin");

drop table Rev2.activite;
create table Rev2.activite(
idActivite int primary key not null auto_increment,
titre VARCHAR(150),
description text,
prix decimal(10,2) not null,
date_debut date,
date_fin date,
type enum("vols","hotel","circuits touristiques"),
places_disponibles int not null
);
insert into activite(titre,description,prix,date_debut,date_fin,type,places_disponibles) values("hotel 5","the best hotel in morocco",5000,'2024-12-2','2025-3-30',"hotel",100);
select * from activite;

drop table Rev2.reservation;
create table Rev2.reservation(
id_reservation int not null PRIMARY KEY  AUTO_INCREMENT,
id_user int,
id_activite int,
date_reservation timestamp,
status ENUM('En attente','Confirmee','Annulee') Not null default 'En attente',
FOREIGN KEY(id_user) REFERENCES user(id) on delete cascade,
FOREIGN KEY(id_activite) REFERENCES activite(idActivite) on delete cascade
)
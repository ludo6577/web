CREATE TABLE groupe (idgrp integer NOT NULL, libgrp character varying(20));
CREATE TABLE  usr(iduser serial primary key, loginuser varchar(30) NOT NULL, passwduser varchar(15) NOT NULL, emailuser varchar(100), dateinsuser date);

CREATE TABLE theme (idthm serial primary key, libthm varchar(100) NOT NULL default '', datecrthm date, iduserthm int NOT NULL, idsuperthm int, 
FOREIGN KEY (iduserthm) REFERENCES usr (iduser), FOREIGN KEY (idsuperthm) REFERENCES theme (idthm));

CREATE TABLE message ( idmsg serial PRIMARY KEY, titremsg varchar(100) NOT NULL, contenumsg text NOT NULL, datemsg date, idthmmsg int NOT NULL, idmsgsrc int, idusermsg int, lat decimal(10,7), lon decimal(10,7),
FOREIGN KEY (idthmmsg) REFERENCES theme (idthm),FOREIGN KEY (idmsgsrc) REFERENCES message(idmsg), FOREIGN KEY (idusermsg) REFERENCES usr (iduser));

CREATE TABLE accessthm (idgrp integer NOT NULL, idthm integer NOT NULL);

INSERT INTO groupe VALUES(1,'Administrateur');
INSERT INTO groupe VALUES(2,'Enseignant');
INSERT INTO groupe VALUES(3,'Etudiant');

INSERT INTO usr (loginuser, passwduser, emailuser, dateinsuser) VALUES('admin','admin','admin@esiee.fr','2013-02-10');
INSERT INTO usr (loginuser, passwduser, emailuser, dateinsuser) VALUES('tabc','ptabc','tabc@unvi-mlv.fr','2013-11-20');
INSERT INTO usr (loginuser, passwduser, emailuser, dateinsuser) VALUES('tdef','ptdef','tdef@univ-mlv.fr','2013-12-25');
INSERT INTO usr (loginuser, passwduser, emailuser, dateinsuser) VALUES('eabc','peabc','eabc@univ-mlv.fr','2013-12-10');
INSERT INTO usr (loginuser, passwduser, emailuser, dateinsuser) VALUES('edef','pedef','edef@univ-mlv.fr','2013-12-12');
INSERT INTO usr (loginuser, passwduser, emailuser, dateinsuser) VALUES('eghi','peghi','egi@univ-mlv.fr','2013-12-13');

INSERT INTO theme (libthm, datecrthm ,iduserthm , idsuperthm) VALUES ('Programmation','2013-02-10',1,null); 
INSERT INTO theme (libthm, datecrthm ,iduserthm , idsuperthm) VALUES ('BD','2013-02-10',2,null);
INSERT INTO theme (libthm, datecrthm ,iduserthm , idsuperthm) VALUES ('SGBDOO','2013-02-10',2,2);
INSERT INTO theme (libthm, datecrthm ,iduserthm , idsuperthm) VALUES ('Prog Java','2013-02-10',1,1);
INSERT INTO theme (libthm, datecrthm ,iduserthm , idsuperthm) VALUES ('Prog Lisp','2013-02-10',1,1);

INSERT INTO accessthm VALUES(1,1);
INSERT INTO accessthm VALUES(1,2);
INSERT INTO accessthm VALUES(1,3);
INSERT INTO accessthm VALUES(1,4);
INSERT INTO accessthm VALUES(1,5);
INSERT INTO accessthm VALUES(2,1);
INSERT INTO accessthm VALUES(2,2);
INSERT INTO accessthm VALUES(2,3);
INSERT INTO accessthm VALUES(3,4);
INSERT INTO accessthm VALUES(3,4);

INSERT INTO message ( titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES ('Super les BD','Super les BD','2013-02-21',2,null,3,48.520, 2.1959);
INSERT INTO message (titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES ('moi je trouve cela "null"','moi je trouve cela "null"','2013-02-21',2,1,4,45.450, 4.510);
INSERT INTO message ( titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES ('What ??','What ??','2013-02-22',3,null,3,48.4059, 1.60 );
INSERT INTO message ( titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES ('Java vs C# ??!','Java vs C# ??!','2013-02-22',4,null,4,48.3159,2.400);
INSERT INTO message ( titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES ('Je prefere Java.','Je prefere Java.','2013-02-23',4,4,3, 48.570,2.520);
INSERT INTO message ( titremsg, contenumsg, datemsg, idthmmsg, idmsgsrc, idusermsg, lat, lon) VALUES ('prog.','prog.','2013-02-27',1,null,1,43.420,7.150);

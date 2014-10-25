SET NAMES 'utf8';

/***************************************************************************/
/* Odstran tabulky a sekvencie, ktore mohli existovat pred spustenim.
/***************************************************************************/
drop table if exists PolozkaObjednavky cascade;
drop table if exists Uzivatel cascade;
drop table if exists Varka cascade;
drop table if exists Caj cascade;
drop table if exists Dodavatel cascade;
drop table if exists CajovaOblast cascade;
drop table if exists Objednavka cascade;
drop table if exists Odberatel cascade;

/***************************************************************************/
/* Vytvor tabulky, ktore budu drzat informacie.
/***************************************************************************/
create table Odberatel(
  pk INT NOT NULL AUTO_INCREMENT ,
  meno VARCHAR(20) NOT NULL,
  priezvisko VARCHAR(20) NOT NULL,
  adresaBydliska VARCHAR(50),
  dodaciaAdresa VARCHAR(50) NOT NULL,
  email VARCHAR(50),
  telefonneCislo NUMERIC(9, 0),
  odberNoviniek NUMERIC(1, 0) NOT NULL check(odberNoviniek in (0, 1)),
  PRIMARY KEY(pk)
);


create table Dodavatel(
  pk INT NOT NULL AUTO_INCREMENT,
  nazov VARCHAR(50) NOT NULL,
  ico NUMERIC(8, 0) NOT NULL,
  weblink VARCHAR(50),
  sidlo VARCHAR(50),
  PRIMARY KEY(pk)
);


create table CajovaOblast(
  pk INT NOT NULL AUTO_INCREMENT,
  nazov VARCHAR(50) NOT NULL,
  popis VARCHAR(500),
  typickyDruh VARCHAR(50),
  charaktCajov VARCHAR(500),
  PRIMARY KEY(pk)
);


create table Caj(
  pk INT NOT NULL AUTO_INCREMENT,
  nazov VARCHAR(50) NOT NULL,
  druh VARCHAR(50),
  krajinaPovodu VARCHAR(50),
  kvalita VARCHAR(5),
  chut VARCHAR(500),
  dobaLuhovania NUMERIC(2, 0),
  zdravotneUcinky VARCHAR(500),
  cajovaoblast_pk INT,
  dodavatel_pk INT NOT NULL,
  PRIMARY KEY(pk)
);


create table Varka(
  pk INT NOT NULL AUTO_INCREMENT,
  /* Cena za 100 g*/
  cena NUMERIC(5, 2) NOT NULL,
  /* V gramoch */
  dostupneMnozstvo NUMERIC(8, 0),
  datumExpiracie DATE NOT NULL,
  /* V desatinnom cisle vyjadrujucom percenta */
  zlava NUMERIC(3, 2) NOT NULL,
  miestoNaSklade NUMERIC(2, 0),
  caj_pk INT NOT NULL,
  PRIMARY KEY(pk)
);


create table Objednavka(
  pk INT NOT NULL AUTO_INCREMENT,
  stav VARCHAR(20) NOT NULL,
  datumPrijatia DATETIME,
  stornoPoplatok NUMERIC(5, 2),
  odberatel_pk INT NOT NULL,
  PRIMARY KEY(pk)
);


create table PolozkaObjednavky(
  pk INT NOT NULL AUTO_INCREMENT,
  objednavka_pk INT NOT NULL,
  /* V gramoch */
  objednaneMnozstvo NUMERIC(8, 0) NOT NULL,
  /* Cena za 100 g*/
  cena NUMERIC(5, 2) NOT NULL,
  varka_pk INT NOT NULL,
  PRIMARY KEY(pk)
);


create table Uzivatel(
  pk INT NOT NULL AUTO_INCREMENT,
  meno VARCHAR(30) NOT NULL,
  heslo VARCHAR(30) NOT NULL,
  odberatel_pk INT NOT NULL,
  PRIMARY KEY(pk)
);

/***************************************************************************/
/* Vytvor vztahy medzi tabulkami
/***************************************************************************/

alter table Caj add constraint fk_caj_cajovaoblast foreign key (cajovaoblast_pk) 
references CajovaOblast(pk) on delete cascade;

alter table Caj add constraint fk_caj_dodavatel foreign key (dodavatel_pk)
references Dodavatel(pk) on delete cascade;

alter table Varka add constraint fk_varka_caj foreign key (caj_pk) 
references Caj(pk) on delete cascade;

alter table Objednavka add constraint fk_objednavka_odberatel foreign key (odberatel_pk) 
references Odberatel(pk) on delete cascade;

alter table PolozkaObjednavky add constraint fk_po_objednavka foreign key (objednavka_pk) 
references Objednavka(pk) on delete cascade;

alter table PolozkaObjednavky add constraint fk_po_varka foreign key (varka_pk) 
references Varka(pk) on delete cascade;

alter table Uzivatel add constraint fk_uzivatel_odberatel foreign key (odberatel_pk)
references Odberatel(pk) on delete cascade;

/***************************************************************************/
/* Napln tabulky datami
/***************************************************************************/
/*naplnění tabulky Odberatel*/
insert into Odberatel (pk, meno, priezvisko, adresaBydliska, dodaciaAdresa, email, telefonneCislo, odberNoviniek)
values (null, 'Tomáš', 'Čížek', 'Jabloňová 456 Vřesina', 'Jabloňová 456 Vřesina', 'xcizek12@stud.fit.vutbr.cz', 123456789, 1);
insert into Odberatel (pk, meno, priezvisko, adresaBydliska, dodaciaAdresa, email, telefonneCislo, odberNoviniek) 
values (null, 'Ivan', 'Ševčík', null, 'Halalovka 10 Trenčín', 'xsevci50@stud.fit.vutbr.cz', 987654321, 0);
insert into Odberatel (pk, meno, priezvisko, adresaBydliska, dodaciaAdresa, email, telefonneCislo, odberNoviniek) 
values (null, 'Pavel', 'Nicotka', null, 'Vídeňská 3 Brno', 'nicotka@email.cz', 655352333, 1);

/*naplnění tabulky Dodavatel*/
insert into Dodavatel (pk, nazov, ico, weblink, sidlo) 
values (null, 'True Tea', 12345678, 'www.truetea.com', 'Praha');
insert into Dodavatel (pk, nazov, ico, weblink, sidlo) 
values (null, 'Biogena', 54321323, 'www.biogena.com', 'České Budějovice');
insert into Dodavatel (pk, nazov, ico, weblink, sidlo) 
values (null, 'MEGAFYT-R s.r.o.', 10000000, 'www.megafyt-pharma.cz', 'Vrané nad Vltavou');
insert into Dodavatel (pk, nazov, ico, weblink, sidlo) 
values (null, 'OXALIS', 23232323, 'www.oxalis.cz', 'Slušovice');
insert into Dodavatel (pk, nazov, ico, weblink, sidlo) 
values (null, 'Orient Tea and Commodities Co., Ltd.', 11111111, 'orientea.en.alibaba.com', 'Hangzhou');
insert into Dodavatel (pk, nazov, ico, weblink, sidlo) 
values (null, 'Changsha Organic Herb Inc.', 22222222, 'www.organic-herb.com', 'Changsha');

/*naplnění tabulky čajových oblastí*/
insert into CajovaOblast (pk, nazov, popis, typickyDruh, charaktCajov) 
values (null, 'Rousínov', 'V této oblasti je velmi teplé a vlhké podnebí.', 'Zelený čaj', 'Čaje z této oblasti jsou kyselé.');
insert into CajovaOblast (pk, nazov, popis, typickyDruh, charaktCajov) 
values (null, 'Jiangnan', 'V oblasti je dostatok slunka a vlahy pro pěstování těch nejlepších čajů.', 'Černý čaj', 'Čaje z této oblasti jsou intenzivní.');
insert into CajovaOblast (pk, nazov, popis, typickyDruh, charaktCajov) 
values (null, 'Vřesina', 'V této oblasti je velmi teplé a suché podnebí.', 'Černý čaj', 'Čaje z této oblasti jsou hořké.');
insert into CajovaOblast (pk, nazov, popis, typickyDruh, charaktCajov) 
values (null, 'Rio Grande do Sul', 'V oblasti je vlhké subtropické podnebí.', 'Maté', 'Čaje z této oblasti jsou výrazné a ovocné.');
insert into CajovaOblast (pk, nazov, popis, typickyDruh, charaktCajov) 
values (null, 'Fujian', 'V oblasti převažuje vlhké ale teplé podnebí.', 'Černý čaj', 'Čaje z této oblasti jsou jemné.');
insert into CajovaOblast (pk, nazov, popis, typickyDruh, charaktCajov) 
values (null, 'Zheijang', 'Velmi slunečná a teplá oblast.', 'Zelený čaj', 'Čaje z této oblasti jsou intenzivní.');

/*naplnění tabulky čajů*/
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Dračí dech', 'Zelený', 'Česko', 'OP', 'Osvěžujíci kyselkavá', 5, null, 1, 1);
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Irish cream', 'Černý', 'Čína', 'TGFOP', 'Výrazná s příchutí karamelu', 3, null, 2, 2);
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Řepíkový čaj', 'Bilinný', 'Česko', null, 'Trpká', 8, 'Zastavuje průjem', null, 3);
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Mate IQ', 'Mate', 'Brazília', null, 'Ovocno kvetová', 5, 'Povzbudzuje organizmus', 4, 4);
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Fujian organický', 'Oolong', 'Čína', 'FOP', 'Bohatá jemne horká', 4, null, 5, 5);
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Tian Mu Yun Wu', 'Zelený', 'Čína', 'OP', 'Jemná osviežujúca', 3, null, 6, 5);
insert into Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) 
values (null, 'Gunpowder', 'Zelený', 'Čína', 'OP', 'Zemitá', 4, 'Silný antioxidant', 6, 5);

/*naplnìní tabulky várek*/
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 80, 12000, str_to_date('2018,04,01', '%Y,%m,%d'), 0, 5, 1);
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 93, 1753, str_to_date('2015,05,15', '%Y,%m,%d'), 0.05, 6, 2);
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 68, 1347, str_to_date('2018,11,23', '%Y,%m,%d'), 0, 1, 3);
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 71, 9890, str_to_date('2019,07,22', '%Y,%m,%d'), 0, 2, 4);
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 86, 3571, str_to_date('2018,03,14', '%Y,%m,%d'), 0, 3, 5);
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 102, 8703, str_to_date('2016,07,03', '%Y,%m,%d'), 0.05, 4, 6);
insert into Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) 
values (null, 88, 6039, str_to_date('2015,09,01', '%Y,%m,%d'), 0.1, 5, 6);

/*naplnìní tabulky objednávek*/
insert into Objednavka (pk, stav, datumPrijatia, stornoPoplatok, odberatel_pk) 
values (null, 'prijatá', str_to_date('2013,03,20,13,00', '%Y,%m,%d,%H,%i'), 200, 1);
insert into Objednavka (pk, stav, datumPrijatia, stornoPoplatok, odberatel_pk) 
values (null, 'čeká na prijeti', str_to_date('2013,03,25,12,45', '%Y,%m,%d,%H,%i'), 343, 2);
insert into Objednavka (pk, stav, datumPrijatia, stornoPoplatok, odberatel_pk) 
values (null, 'neodeslána', null, null, 2);

/*naplnìní tabulky položek objednávky*/
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 1, 800, 80, 1);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 1, 300, 90, 2);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 2, 500, 93, 2);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 1, 1130, 71, 4);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 2, 560, 86, 5);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 2, 400, 79, 7);
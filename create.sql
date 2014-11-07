USE xcizek12;
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
drop function if exists Odober; 
drop procedure if exists OdoberPostupne;
drop function if exists CenaObjednavky;
drop procedure if exists PotvrdKosik;
drop function if exists ZiskajKosik;
drop procedure if exists ZalozKosik;
drop procedure if exists PridajDoKosika;
drop procedure if exists OdstranZKosika;

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
) ENGINE = InnoDB;


create table Objednavka(
  pk INT NOT NULL AUTO_INCREMENT,
  stav VARCHAR(20),
  datumPrijatia DATETIME,
  stornoPoplatok NUMERIC(12, 2),
  kosik BOOL,
  odberatel_pk INT NOT NULL,
  PRIMARY KEY(pk)
) ENGINE = InnoDB;


create table PolozkaObjednavky(
  pk INT NOT NULL AUTO_INCREMENT,
  objednavka_pk INT NOT NULL,
  /* V gramoch */
  objednaneMnozstvo NUMERIC(8, 0) NOT NULL,
  /* Cena za 100 g*/
  cena NUMERIC(5, 2),
  varka_pk INT NOT NULL,
  PRIMARY KEY(pk)
);


create table Uzivatel(
  pk INT NOT NULL AUTO_INCREMENT,
  meno VARCHAR(30) NOT NULL,
  heslo VARCHAR(30) NOT NULL,
  uuidPrihlasenia INT,
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
/* Naplnenie tabulky Odberatel*/
insert into Odberatel (pk, meno, priezvisko, adresaBydliska, dodaciaAdresa, email, telefonneCislo, odberNoviniek)
values (null, 'Tomáš', 'Čížek', 'Jabloňová 456 Vřesina', 'Jabloňová 456 Vřesina', 'xcizek12@stud.fit.vutbr.cz', 123456789, 1);
insert into Odberatel (pk, meno, priezvisko, adresaBydliska, dodaciaAdresa, email, telefonneCislo, odberNoviniek) 
values (null, 'Ivan', 'Ševčík', null, 'Halalovka 10 Trenčín', 'xsevci50@stud.fit.vutbr.cz', 987654321, 0);
insert into Odberatel (pk, meno, priezvisko, adresaBydliska, dodaciaAdresa, email, telefonneCislo, odberNoviniek) 
values (null, 'Pavel', 'Nicotka', null, 'Vídeňská 3 Brno', 'nicotka@email.cz', 655352333, 1);

/* Naplnenie tabulky Dodavatel*/
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

/* Naplnenie tabulky CajovaOblast*/
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

/* Naplnenie tabulky Caj*/
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

/* Naplnenie tabulky Varka*/
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

/* Naplnenie tabulky Objednavky*/
insert into Objednavka (pk, stav, datumPrijatia, stornoPoplatok, kosik, odberatel_pk) 
values (null, null, null, null, true, 1);
insert into Objednavka (pk, stav, datumPrijatia, stornoPoplatok, kosik, odberatel_pk) 
values (null, null, null, null, true, 2);

/* Naplnenie tabulky PolozkaObjednavky*/
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 1, 1000, NULL, 1);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 1, 300, NULL, 2);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 2, 500, 93, 2);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 1, 50000, NULL, 4);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 2, 560, 86, 5);
insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
values (null, 2, 400, 79, 7);

/* Naplnenie tabulky Uzivatel */
insert into Uzivatel (pk, meno, heslo, uuidPrihlasenia, odberatel_pk)
values (null, 'test', 'test', null, 1);
insert into Uzivatel (pk, meno, heslo, uuidPrihlasenia, odberatel_pk)
values (null, 'test2', 'test2', null, 2);

delimiter //

create function Odober(pkVarky INT, mnozstvo NUMERIC(8, 0))
returns bool
begin
	declare dostupneMnozstvo NUMERIC(8, 0);
    declare upraveneMnozstvo NUMERIC(8, 0);
	select Varka.dostupneMnozstvo into dostupneMnozstvo from Varka where Varka.pk = pkVarky;
    if dostupneMnozstvo >= mnozstvo then
		set upraveneMnozstvo = dostupneMnozstvo - mnozstvo;
		update Varka set Varka.dostupneMnozstvo = upraveneMnozstvo where Varka.pk = pkVarky;
        return true;
	else
		return false;
    end if;
end //

create procedure OdoberPostupne(pkVarky INT, mnozstvo NUMERIC(8, 0))
begin
	declare uspech bool;
    select Odober(pkVarky, mnozstvo) into uspech;
    if not uspech then
		rollback;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Amount';
    end if;
end //

create function CenaObjednavky(pkObjednavky INT)
returns NUMERIC(12, 2)
begin
	declare celkovaCena NUMERIC(12, 2);
    select sum(po.cena * po.objednaneMnozstvo / 100) from PolozkaObjednavky as po where po.objednavka_pk = pkObjednavky into celkovaCena;
    return celkovaCena;
end //

create procedure PotvrdKosik(pkUzivatela INT)
begin
	declare pkKosik INT;
	declare pkVarky INT;
    declare mnozstvo NUMERIC(8, 0);
    declare done bool default false;
	declare cur cursor for select po.varka_pk, po.objednaneMnozstvo from PolozkaObjednavky as po where po.objednavka_pk = pkKosik;
	declare continue handler for not found set done := true;
	
    select ZiskajKosik(pkUzivatela) into pkKosik;
    if pkKosik is null then
		rollback;
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No cart';
    end if;

	open cur;
	curLoop: loop
		fetch cur into pkVarky, mnozstvo;
		if done then
			leave curLoop;
		end if;
			call OdoberPostupne(pkVarky, mnozstvo);
	end loop curLoop;

	close cur;
	 
	update PolozkaObjednavky as po
    set cena = (select Varka.cena * (1 - Varka.zlava) from Varka where Varka.pk = po.varka_pk)
    where po.objednavka_pk = pkKosik;
     
    update Objednavka
    set stav = 'prijatá', datumPrijatia = now(), kosik = false, stornoPoplatok = (select 0.2 * CenaObjednavky(pkKosik))
    where Objednavka.pk = pkKosik;
     
    commit;
end //

create function ZiskajKosik(pkUzivatela INT)
returns INT
begin
	declare pkOdberatela INT;
    declare pkKosik INT;
    select u.odberatel_pk from Uzivatel as u where u.pk = pkUzivatela into pkOdberatela;
	select o.pk from Objednavka as o where o.odberatel_pk = pkOdberatela and o.kosik = true into pkKosik;
    
    return pkKosik;
end //

create procedure ZalozKosik(pkUzivatela INT)
begin
	declare pkOdberatela INT;
	declare pkKosik INT;
    select ZiskajKosik(pkUzivatela) into pkKosik;
    
    if pkKosik is not null then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cart exists';
    end if;
    
    select u.odberatel_pk from Uzivatel as u where u.pk = pkUzivatela into pkOdberatela;
	insert into Objednavka (pk, stav, datumPrijatia, stornoPoplatok, kosik, odberatel_pk) 
	values (null, null, null, null, true, pkOdberatela);
end //

create procedure PridajDoKosika(pkUzivatela INT, pkVarky INT, mnozstvo NUMERIC(8, 0))
begin
	declare pkKosik INT;
    select ZiskajKosik(pkUzivatela) into pkKosik;
    if pkKosik is null then
		call ZalozKosik(pkUzivatela);
        select ZiskajKosik(pkUzivatela) into pkKosik;
    end if;
    
    insert into PolozkaObjednavky (pk, objednavka_pk, objednaneMnozstvo, cena, varka_pk) 
	values (null, pkKosik, mnozstvo, NULL, pkVarky);
end //

create procedure OdstranZKosika(pkUzivatela INT, pkPolozky INT)
begin
	declare pkKosik INT;
    select ZiskajKosik(pkUzivatela) into pkKosik;
    if pkKosik is null then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No cart';
    end if;
    
    delete from PolozkaObjednavky where PolozkaObjednavky.pk = pkPolozky;
end //

delimiter ;

commit;
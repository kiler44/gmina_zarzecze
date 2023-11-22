CREATE TABLE modul_informacje_apartamenty
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_zamowienia integer,
  informacje text,
  dodatkowe_ceny text,
  nazwa_projektu character varying(1000),
  szablon text,
  CONSTRAINT pkey_informacje_apartamety PRIMARY KEY (id, id_projektu)
)
ALTER TABLE modul_informacje_apartamenty ADD COLUMN druga_tura_apartament integer;
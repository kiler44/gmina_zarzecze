CREATE TABLE modul_faktura_pozycje
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_faktury integer NOT NULL,
  id_obiektu integer,
  typ_obiektu character varying(128),
  nazwa_pozycji text,
  procent_kwoty integer NOT NULL DEFAULT 100,
  kwota_netto numeric(11,2) NOT NULL,
  kwota_netto_calosc numeric(11,2) NOT NULL,
  typ_produktu character varying(256),
  CONSTRAINT modul_faktura_pozycje_pkey PRIMARY KEY (id, id_projektu)
)

ALTER TABLE modul_faktura_pozycje ADD COLUMN ilosc integer NOT NULL DEFAULT 1;
ALTER TABLE modul_faktura_pozycje ADD COLUMN kreditnota boolean DEFAULT false NOT NULL;

-- Column: ikona

-- ALTER TABLE cms_kategorie DROP COLUMN ikona;

ALTER TABLE cms_kategorie ADD COLUMN ikona character varying(42);

CREATE TYPE rodzaj_podatku AS ENUM ('kwotowy', 'procentowy');

CREATE TABLE modul_tabela_podatkowa
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  nr_tabeli character(4) NOT NULL,
  rok smallint NOT NULL,
  kwota_od integer NOT NULL DEFAULT 0,
  kwota_do integer NOT NULL DEFAULT 0,
  podatek integer NOT NULL DEFAULT 0,
  rodzaj rodzaj_podatku NOT NULL DEFAULT 'kwotowy'::rodzaj_podatku,
  CONSTRAINT modul_tabela_podatkowa_pkey PRIMARY KEY (id, id_projektu)
);

ALTER TABLE cms_uzytkownicy
   ADD COLUMN tabela_podatkowa character(4) NOT NULL DEFAULT '7100'::bpchar;

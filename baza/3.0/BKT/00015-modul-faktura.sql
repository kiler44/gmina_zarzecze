CREATE TYPE faktura_metody_wyslania AS ENUM
   ('poczta',
    'mail');
CREATE TYPE faktura_typy AS ENUM
   ('zwykla',
    'material',
    'reczna');

-- Table: modul_faktura

-- DROP TABLE modul_faktura;

CREATE TABLE modul_faktura
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_obiektu integer,
  typ_obiektu character varying(128),
  nazwa_faktury text,
  autor integer NOT NULL,
  odbiorca integer NOT NULL,
  data_dodania timestamp without time zone NOT NULL DEFAULT now(),
  data_wystawienia timestamp without time zone,
  ilosc_dni_na_platnosc integer NOT NULL,
  data_zaplaty timestamp without time zone,
  kwota_do_zaplaty_netto numeric(11,2) NOT NULL,
  kwota_do_zaplaty_brutto numeric(11,2) NOT NULL,
  vat integer NOT NULL,
  kwota_vat numeric(11,2) NOT NULL,
  pelna_kwota_do_zaplaty_netto numeric(11,2) NOT NULL,
  kwota_zaplacona_brutto numeric(11,2) DEFAULT 0,
  numer_faktury character varying(128),
  numer_kreditnota character varying(128),
  pozycje_faktury text NOT NULL,
  id_rodzica integer,
  faktura_glowna boolean NOT NULL DEFAULT true,
  ilosc_upomnien integer,
  typ_faktury faktura_typy NOT NULL DEFAULT 'zwykla'::faktura_typy,
  metoda_wyslania faktura_metody_wyslania DEFAULT 'mail'::faktura_metody_wyslania,
  faktura_wyslana boolean NOT NULL DEFAULT false,
  faktura_oplacona boolean NOT NULL DEFAULT false,
  CONSTRAINT modul_faktura_pkey PRIMARY KEY (id, id_projektu)
)

ALTER TABLE modul_faktura ADD COLUMN faktura_wystawiona boolean DEFAULT false NOT NULL;
ALTER TABLE modul_faktura ADD COLUMN faktura_rodzaj faktura_rodzaje DEFAULT 'faktura'::faktura_rodzaje NOT NULL;
ALTER TABLE modul_faktura ADD COLUMN kwota_upomnienia numeric(11,2);

CREATE TYPE faktura_rodzaje AS ENUM
   ('purring',
    'kreditnota',
    'faktura');

ALTER TYPE faktura_rodzaje ADD VALUE inkassovarsel
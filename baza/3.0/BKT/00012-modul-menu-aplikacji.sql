-- Table: modul_menu_aplikacji

-- DROP TABLE modul_menu_aplikacji;

CREATE TABLE modul_menu_aplikacji
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_rodzica integer,
  id_uzytkownika integer,
  czy_modul_administracyjny boolean NOT NULL DEFAULT false,
  id_kategorii integer,
  akcja character varying(64),
  anchor character varying(32),
  ikona character varying(32),
  zawsze_widoczna boolean NOT NULL DEFAULT true,
  kolejnosc smallint NOT NULL DEFAULT 0,
  klikniecia bigint,
  etykieta text,
  parametry text,
  CONSTRAINT modul_menu_aplikacji_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);
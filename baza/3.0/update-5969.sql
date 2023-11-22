CREATE TABLE modul_produkty
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  kod_jezyka character varying(2) NOT NULL DEFAULT ''::character varying,
  nazwa_listy character varying(100),
  nazwa_portal character varying(100),
  nazwa_faktura character varying(100),
  nazwa_admin character varying(100),
  czas_trwania integer,
  czy_w_sprzedazy boolean,
  okres_rozliczeniowy integer,
  cena_bazowa integer,
  stawka_vat integer,
  waga_sortowania integer,
  opis text,
  parametry text,
  przypisane_polityki text,
  regulamin text,
  data_dodania timestamp without time zone,
  typ_produktu character varying(32),
  okres_sprzedazy_od date,
  okres_sprzedazy_do date,
  grupa_produktow character varying,
  CONSTRAINT modul_produkty_pkey PRIMARY KEY (id, id_projektu, kod_jezyka),
  CONSTRAINT modul_produkty_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

-- Poprawki w tabeli powiązań oraz dodanie nowego powiązania
ALTER TABLE cms_powiazania_typy DROP COLUMN nazwa_mappera1;
ALTER TABLE cms_powiazania_typy DROP COLUMN nazwa_mappera2;

ALTER TABLE cms_powiazania ADD CONSTRAINT cms_powiazania_id1_id2_typ_data_start_data_stop_key UNIQUE (id1, id2, typ, data_start, data_stop);

INSERT INTO cms_powiazania_typy(id, nazwa, typ1, typ2)
VALUES (2, 'jestRodzicemProduktu', 'Produkt', 'Produkt');

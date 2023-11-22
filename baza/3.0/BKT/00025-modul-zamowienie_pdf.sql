CREATE TABLE modul_zamowienie_pdf
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  data timestamp without time zone NOT NULL,
  godzina character varying(20) NOT NULL,
  id_pdf character varying NOT NULL,
  data_wygenerowania timestamp without time zone DEFAULT now(),
  data_dostarczenia timestamp without time zone,
  id_zamowienie_projekt integer,
  CONSTRAINT pkey_modul_zamowienia_pdf PRIMARY KEY (id, id_projektu)
)
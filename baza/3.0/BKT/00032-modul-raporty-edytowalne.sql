CREATE TABLE IF NOT EXISTS modul_raporty_edytowalne (
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  kod_jezyka character varying(2) NOT NULL,
  nazwa character varying(255) NOT NULL,
  opis text NOT NULL,
  grupa integer NOT NULL,
  kod_sql text NOT NULL,
  nazwy_pol text NOT NULL,
  uprawnieni_uzytkownicy text NOT NULL,
  filtry text NOT NULL,
  data_dodania timestamp without time zone NOT NULL,
  cache integer NOT NULL,
  data_modyfikacji timestamp without time zone NOT NULL,
  zezwol_zaawansowany smallint NOT NULL,
  typ_wykresu character varying(32) NOT NULL,
  kolumny_wykresu text NOT NULL,
  typy_kolumn_tabeli text NOT NULL,
  kolumna_wykresu_daty character varying(120) NOT NULL,
  typ_wykresu_modyfikowalny smallint NOT NULL,
  sub_zapytania text NOT NULL,
  CONSTRAINT pkey_raporty_edytowalne PRIMARY KEY (id,id_projektu)
);
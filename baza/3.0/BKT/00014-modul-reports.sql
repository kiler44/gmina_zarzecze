CREATE TABLE modul_reports
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  obiekt character varying(128) NOT NULL,
  id_obiektow text NOT NULL,
  kategoria character varying(128) NOT NULL,
  data_od timestamp without time zone,
  data_do timestamp without time zone,
  autor integer,
  data_dodania timestamp without time zone DEFAULT now(),
  data_modyfikacji timestamp without time zone,
  wyslany boolean,
  status status NOT NULL DEFAULT 'active'::status,
  CONSTRAINT modul_reports_pkey PRIMARY KEY (id, id_projektu)
)

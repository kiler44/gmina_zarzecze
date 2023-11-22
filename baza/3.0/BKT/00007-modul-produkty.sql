CREATE TABLE modul_produkty
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  code character varying(128) NOT NULL,
  name character varying(128) NOT NULL,
  status status NOT NULL DEFAULT 'active'::status,
  measure_unit character varying(12),
  visible_in_order text NOT NULL,
  vat integer,
  netto_price double precision,
  brutto_price double precision,
  data_added date NOT NULL DEFAULT ('now'::text)::date,
  CONSTRAINT modul_produkty_pkey PRIMARY KEY (id, id_projektu)
)

ALTER TABLE modul_produkty ALTER COLUMN name character varying(126);
ALTER TABLE modul_produkty ADD COLUMN import boolean;
ALTER TABLE modul_produkty ALTER COLUMN import SET DEFAULT false;

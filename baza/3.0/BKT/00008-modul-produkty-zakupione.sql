CREATE TABLE modul_produkty_zakupione
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_product integer,
  id_order integer NOT NULL,
  product_name character varying(128),
  quantity double precision NOT NULL DEFAULT 1,
  "time" double precision NOT NULL DEFAULT 0,
  vat integer,
  netto_price double precision,
  brutto_price double precision,
  localisation character varying(60),
  CONSTRAINT modul_produkty_zakupione_pkey PRIMARY KEY (id, id_projektu)
)

ALTER TABLE modul_produkty_zakupione ALTER COLUMN id_product SET DEFAULT NULL;
ALTER TABLE modul_produkty_zakupione ADD COLUMN description character varying(600);

ALTER TABLE modul_produkty_zakupione ADD COLUMN data_added timestamp with time zone;
ALTER TABLE modul_produkty_zakupione ALTER COLUMN data_added SET DEFAULT now();

CREATE TYPE confirmation_statuses AS ENUM 
  ('not confirmed', 
    'rejected',
    'confirmed');

ALTER TABLE modul_produkty_zakupione ADD COLUMN confirmation_status confirmation_statuses DEFAULT 'not confirmed'::confirmation_statuses,

ALTER TABLE modul_produkty_zakupione ADD COLUMN alert boolean;
ALTER TABLE modul_produkty_zakupione ALTER COLUMN alert SET DEFAULT false;

ALTER TABLE modul_produkty_zakupione ADD COLUMN kategoria character varying(128);
ALTER TABLE modul_produkty_zakupione ADD COLUMN procent_wykonania integer;
ALTER TABLE modul_produkty_zakupione ALTER COLUMN procent_wykonania SET DEFAULT 0;
CREATE TYPE charge_types AS ENUM ('given price', 'price per hour', 'by products');
CREATE TYPE work_statuses AS ENUM ('new', 'in progress', 'done', 'partially done', 'cant be done', 'client fail', 'our fail');
CREATE TYPE order_statuses AS ENUM ('active', 'cancelled', 'out dated', 'not active');

-- Table: modul_zamowienia

-- DROP TABLE modul_zamowienia;

CREATE TABLE modul_zamowienia
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_parent integer,
  id_team integer,
  id_type integer NOT NULL,
  number_order_get integer NOT NULL,
  number_order_bkt integer,
  number_customer integer,
  number_privat_customer integer,
  number_project_get character(12),
  number_contact_id integer,
  order_name character varying(250),
  charge_type charge_types NOT NULL DEFAULT 'by products'::charge_types,
  date_added timestamp without time zone NOT NULL DEFAULT now(),
  hours_interval character(11),
  total_time double precision,
  date_start date,
  date_stop date,
  status order_statuses NOT NULL DEFAULT 'active'::order_statuses,
  status_work work_statuses NOT NULL DEFAULT 'new'::work_statuses,
  address character varying(128),
  city character varying(64),
  postcode character(4),
  location_lat numeric(10,6),
  location_lng numeric(10,6),
  budget numeric(11,2),
  node_villa_code character varying(16),
  attributes text,
  job_description text,
  CONSTRAINT modul_zamowienia_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE modul_zamowienia ADD COLUMN position integer;


-- DROP TABLE modul_zamowienia_typy;

-- Table: modul_zamowienia_typy

-- DROP TABLE modul_zamowienia_typy;

CREATE TABLE modul_zamowienia_typy
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_config_template integer,
  main_type boolean,
  active boolean,
  child_orders boolean,
  date_added timestamp without time zone NOT NULL DEFAULT now(),
  possible_charge_types character varying(150),
  parent_types character varying(320),
  name character varying(128),
  required_skills character varying(128),
  preview_template text,
  CONSTRAINT modul_zamowienia_typy_tmp_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);

ALTER TABLE modul_zamowienia ALTER COLUMN number_order_bkt  DROP NOT NULL;

ALTER TABLE modul_zamowienia ADD COLUMN data_zakonczenia timestamp without time zone;

ALTER TABLE modul_zamowienia ADD COLUMN blokada_edycji boolean;
ALTER TABLE modul_zamowienia ALTER COLUMN blokada_edycji SET DEFAULT false;

ALTER TABLE modul_zamowienia ADD COLUMN blokada_poprawiania boolean;
ALTER TABLE modul_zamowienia ALTER COLUMN blokada_poprawiania SET DEFAULT false;
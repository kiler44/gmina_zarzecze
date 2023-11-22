CREATE TYPE timelist_types AS ENUM
   ('red_day',
    'holiday',
    'seek_day',
    'orders',
    'night_hours');

CREATE TABLE modul_timelist
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_team integer,
  id_user integer NOT NULL,
  data_start timestamp without time zone DEFAULT now(),
  data_stop timestamp without time zone,
  multiplier double precision DEFAULT 1,
  object character varying(60),
  id_object integer,
  type timelist_types NOT NULL DEFAULT 'orders'::timelist_types,
  hours double precision,
  stawka double precision,
  tax_table character(4),
  CONSTRAINT pkey_modul_timelist PRIMARY KEY (id, id_projektu)
)

ALTER TABLE modul_timelist ADD COLUMN auto_logout boolean;
ALTER TABLE modul_timelist ALTER COLUMN auto_logout SET DEFAULT false;

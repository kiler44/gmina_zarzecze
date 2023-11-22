CREATE TYPE status AS ENUM
   ('active',
    'delete');

DROP TABLE modul_zalaczniki;

CREATE TABLE modul_zalaczniki
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  object character varying(30) NOT NULL,
  id_object integer NOT NULL,
  file character varying(30) NOT NULL,
  date_added date NOT NULL DEFAULT ('now'::text)::date,
  status status NOT NULL DEFAULT 'active'::status,
  CONSTRAINT modul_zalaczniki_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);


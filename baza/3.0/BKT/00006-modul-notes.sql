CREATE TABLE modul_notes
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  object character varying(126) NOT NULL,
  id_object integer NOT NULL,
  description text NOT NULL,
  data_added timestamp with time zone NOT NULL DEFAULT now(),
  status status NOT NULL DEFAULT 'active'::status,
  CONSTRAINT modul_notes_pkey PRIMARY KEY (id, id_projektu)
)
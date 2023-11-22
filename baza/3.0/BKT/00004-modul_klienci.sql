CREATE TYPE klienci_types AS ENUM
   ('company',
    'developer',
    'private',
    'branch contact person');
DROP TYPE klienci_types;

CREATE TYPE klienci_types AS ENUM
   ('company',
    'developer',
    'private',
    'branch contact person');

CREATE TABLE modul_klienci
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_parent integer DEFAULT 0,
  id_customer integer,
  status klienci_status NOT NULL DEFAULT 'active'::klienci_status,
  name character varying(50),
  second_name character varying(50),
  surname character varying(50),
  org_number character varying(9),
  company_name character varying(128),
  address character varying(90),
  postcode character varying(4),
  city character varying(50),
  phone_number character varying(15),
  phone_number_1 character varying(15),
  phone_number_2 character varying(15),
  phone_mobile character varying(15) NOT NULL,
  fax character varying(15),
  email character varying(128) NOT NULL,
  type klienci_types NOT NULL,
  data_added timestamp without time zone DEFAULT ('now'::text)::date,
  www character varying(128),
  CONSTRAINT modul_klienci_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);


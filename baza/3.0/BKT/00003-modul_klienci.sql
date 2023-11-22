CREATE TABLE modul_klienci
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_parent integer DEFAULT NULL,
  status klienci_status NOT NULL DEFAULT 'active'::klienci_status,
  name character varying(50) NOT NULL,
  second_name character varying(50),
  surname character varying(50) NOT NULL,
  org_number character varying(9),
  company_name character varying(128),
  address character varying(90) NOT NULL,
  postcode character varying(4) NOT NULL,
  city character varying(50) NOT NULL,
  phone_number character varying(15),
  phone_mobile character varying(15) NOT NULL,
  fax character varying(15),
  email character varying(128) NOT NULL,
  type klienci_types NOT NULL,
  data_added timestamp without time zone,
  www character varying(128),
  CONSTRAINT modul_klienci_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE modul_klienci
  OWNER TO postgres;


CREATE TYPE klienci_status AS ENUM ('active', 'delete');
ALTER TYPE klienci_status
  OWNER TO postgres;

CREATE TYPE klienci_types AS ENUM
   ('company',
    'private',
    'branch contact person',
	);
ALTER TYPE klienci_types
  OWNER TO postgres;
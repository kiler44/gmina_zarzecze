CREATE TABLE cms_uprawnienia_obiektow
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  kod_jezyka character varying(2) NOT NULL,
  kod_obiektu character varying(50) NOT NULL,
  pole character varying(50) NOT NULL,
  hash character(8) NOT NULL,
  CONSTRAINT cms_uprawnienia_obiektow_pkey PRIMARY KEY (id, id_projektu, kod_jezyka),
  CONSTRAINT cms_uprawnienia_obiektow_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE cms_uprawnienia_obiektow
  OWNER TO crm_user;


CREATE TABLE cms_role_uprawnienia_obiektow
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  kod_jezyka character varying(2) NOT NULL,
  id_roli integer NOT NULL,
  id_uprawnienia_obiektu integer NOT NULL,
  CONSTRAINT cms_role_uprawnienia_obiektow_pkey PRIMARY KEY (id, id_projektu, kod_jezyka),
  CONSTRAINT cms_role_uprawnienia_obiektow_id_roli_fkey FOREIGN KEY (id_roli, id_projektu)
      REFERENCES cms_role (id, id_projektu) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT cms_role_uprawnienia_obiektow_id_uprawnienia_fkey FOREIGN KEY (id_uprawnienia_obiektu, id_projektu, kod_jezyka)
      REFERENCES cms_uprawnienia_obiektow (id, id_projektu, kod_jezyka) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE cms_role_uprawnienia_obiektow
  OWNER TO crm_user;
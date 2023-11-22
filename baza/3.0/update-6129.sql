ALTER TABLE cms_widoki ADD COLUMN json_ukladu text;
ALTER TABLE cms_widoki ADD COLUMN html_ukladu text;

-- Table: crm_widoki_powiazania

-- DROP TABLE crm_widoki_powiazania;

CREATE TABLE crm_widoki_powiazania
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  id_widoku integer NOT NULL,
  kod_jezyka character varying(2) NOT NULL,
  uzytkownik integer,
  grupa integer,
  akcja character varying(200),
  CONSTRAINT crm_widoki_powiazania_pkey PRIMARY KEY (id, id_projektu, kod_jezyka),
  CONSTRAINT crm_widoki_powiazania_kod_jezyka_fkey FOREIGN KEY (kod_jezyka, id_projektu)
      REFERENCES cms_jezyki (kod, id_projektu) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE crm_widoki_powiazania
  OWNER TO crm_user;

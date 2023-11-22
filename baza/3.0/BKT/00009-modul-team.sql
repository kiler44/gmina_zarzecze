CREATE TYPE status_team AS ENUM ('active', 'delete', 'in_repair','temporary_use' )

CREATE TABLE modul_team
(
  id integer NOT NULL,
  id_projektu integer NOT NULL,
  team_number character varying(7),
  number_plate character varying(7),
  id_leader integer,
  id_users character varying(60),
  email character varying(128),
  date_last_changed time with time zone,
  status status_team DEFAULT 'active'::status_team,
  CONSTRAINT pkey_modul_team PRIMARY KEY (id, id_projektu)
)

ALTER TABLE modul_team ADD COLUMN kolejnosc_zamowien text;
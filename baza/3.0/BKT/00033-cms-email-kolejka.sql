ALTER TABLE cms_email_kolejka ADD COLUMN nie_wysylaj boolean NOT NULL DEFAULT false;
ALTER TABLE cms_email_kolejka ADD COLUMN id_nadawcy integer;
ALTER TABLE cms_email_kolejka ADD COLUMN id_odbiorcy integer;
ALTER TABLE cms_email_kolejka ADD COLUMN object character varying(80);
ALTER TABLE cms_email_kolejka ADD COLUMN id_object integer;
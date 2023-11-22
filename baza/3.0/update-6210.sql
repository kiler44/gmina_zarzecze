ALTER TABLE cms_uprawnienia_administracyjne
   ADD COLUMN hash character(8);

ALTER TABLE cms_uprawnienia
   ADD COLUMN hash character(8);

ALTER TABLE cms_role
   ADD COLUMN kontekstowa integer;

ALTER TABLE cms_role
   ADD COLUMN kontekst_obiekt character varying(128);

ALTER TABLE cms_role
   ADD COLUMN kontekst_pole character varying(64);

ALTER TABLE cms_role
   ADD COLUMN kontekst_powiazanie character varying(128);

ALTER TABLE cms_role
   ADD COLUMN kontekst_powiazanie_ktore_id int;


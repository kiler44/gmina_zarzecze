ALTER TABLE modul_zamowienia ADD COLUMN apartment character varying(6);
ALTER TABLE modul_zamowienia ADD COLUMN additional_data text;
ALTER TABLE modul_zamowienia ADD COLUMN id_pdf character varying(20);
ALTER TABLE modul_zamowienia ADD COLUMN id_user_przydziel_apartamenty integer;

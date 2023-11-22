ALTER TABLE modul_zamowienia ADD COLUMN is_reclamation boolean;
ALTER TABLE modul_zamowienia ALTER COLUMN is_reclamation SET NOT NULL;
ALTER TABLE modul_zamowienia ALTER COLUMN is_reclamation SET DEFAULT false;
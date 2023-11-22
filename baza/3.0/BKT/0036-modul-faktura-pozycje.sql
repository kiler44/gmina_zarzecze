ALTER TABLE modul_faktura_pozycje ADD COLUMN kreditnota_zmniejszajaca boolean;
ALTER TABLE modul_faktura_pozycje ALTER COLUMN kreditnota_zmniejszajaca SET DEFAULT false;

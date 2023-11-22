ALTER TABLE modul_faktura ADD COLUMN ilosc_kreditnota integer DEFAULT 0;

ALTER TABLE modul_faktura ADD COLUMN kwota_graving numeric(11,2) DEFAULT 0;

ALTER TABLE modul_faktura ADD COLUMN kwota_installation numeric(11,2) DEFAULT 0;
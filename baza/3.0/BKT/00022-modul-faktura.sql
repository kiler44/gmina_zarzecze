ALTER TABLE modul_faktura ADD COLUMN data_wyslania timestamp without time zone;
ALTER TABLE modul_faktura ADD COLUMN email_wysylka character varying(256);

ALTER TABLE modul_faktura ADD COLUMN ma_dzieci boolean DEFAULT false NOT NULL;
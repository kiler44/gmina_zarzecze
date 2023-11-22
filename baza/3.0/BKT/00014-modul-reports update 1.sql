ALTER TABLE modul_reports ADD COLUMN netto_price double precision NOT NULL DEFAULT 0;

ALTER TABLE modul_reports ADD COLUMN brutto_price double precision NOT NULL DEFAULT 0;

ALTER TABLE modul_reports ADD COLUMN zafakturowano boolean NOT NULL DEFAULT false;

ALTER TABLE modul_reports ADD COLUMN wyslany_do_fakturowania boolean NOT NULL DEFAULT false;

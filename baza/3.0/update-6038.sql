ALTER TABLE cms_bloki
  DROP CONSTRAINT cms_bloki_id_projektu_key;
ALTER TABLE cms_bloki
  ADD UNIQUE (id, id_projektu, kod_jezyka);

ALTER TABLE modul_mailing
   ALTER COLUMN plik_z_lista DROP NOT NULL;

ALTER TABLE modul_mailing
   ALTER COLUMN data_zakonczenia DROP NOT NULL;

ALTER TABLE cms_email_kolejka
   ALTER COLUMN id_formatki DROP NOT NULL;

ALTER TABLE cms_uzytkownicy
   ALTER COLUMN mapa_dlugosc DROP NOT NULL;

ALTER TABLE cms_uzytkownicy
   ALTER COLUMN mapa_szerokosc DROP NOT NULL;

ALTER TABLE cms_uzytkownicy
   ALTER COLUMN zgoda_mailing SET DEFAULT true;

ALTER TABLE cms_uzytkownicy
   ALTER COLUMN zgoda_marketing SET DEFAULT true;

ALTER TABLE cms_widoki
   ALTER COLUMN struktura SET DEFAULT '';


ALTER TABLE modul_faktura_pozycje ALTER COLUMN ilosc TYPE numeric(6,2) USING ilosc::numeric;
UPDATE modul_faktura_pozycje SET ilosc = (procent_kwoty::numeric / 100);
UPDATE modul_faktura_pozycje SET varenr = ('PZ' || id_obiektu) WHERE typ_obiektu = 'ProduktyZakupione'
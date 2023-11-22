CREATE TABLE "cms_projekty" (
  "id" integer NOT NULL,
  "kod" varchar(16) NOT NULL,
  "domena" varchar(50) NOT NULL,
  "nazwa" varchar(50) NOT NULL,
  "szablon" varchar(32) NOT NULL,
  "opis" text,
  "domyslny_jezyk" varchar(2) NOT NULL DEFAULT 'pl',
  "przypisane_moduly" text NOT NULL,
  "moduly_rss" text,
  "moduly_cron" text,
  PRIMARY KEY ("id")
);

CREATE TABLE "cms_jezyki" (
  "id" integer NOT NULL,
  "kod" varchar(2) NOT NULL,
  "id_projektu" integer NOT NULL,
  "nazwa" varchar(32) NOT NULL,
  PRIMARY KEY ("id","id_projektu")
);

CREATE TABLE "cms_bloki" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "kod_modulu" varchar(50) DEFAULT NULL,
  "kontener" varchar(60) DEFAULT NULL,
  "klasa" varchar(100) DEFAULT NULL,
  "nazwa" varchar(255) NOT NULL,
  "szablon" varchar(100) DEFAULT NULL,
  "cache" integer NOT NULL DEFAULT '0',
  "cache_czas" integer NOT NULL DEFAULT '0',
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
);

CREATE TYPE cahce_linki_typ AS ENUM ('blok','podstrona_portalowa','podstrona_wizytowki');

CREATE TABLE "cms_cache_linki" (
  "url" varchar(300) NOT NULL,
  "typ" cahce_linki_typ NOT NULL,
  "data_dodania" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "lista_zawartych_url" text NOT NULL,
  PRIMARY KEY ("url")
);


CREATE TYPE email_formatki_wysylanie AS ENUM ('natychmiast','cron','kolejka');

CREATE TABLE "cms_email_formatki" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "data_dodania" timestamp NOT NULL,
  "typ_wysylania" email_formatki_wysylanie NOT NULL DEFAULT 'natychmiast',
  "kategoria" varchar(30) NOT NULL,
  "tytul" varchar(300) NOT NULL,
  "opis" varchar(500) DEFAULT NULL,
  "email_nadawca_email" varchar(100) DEFAULT NULL,
  "email_nadawca_nazwa" varchar(100) DEFAULT NULL,
  "email_potwierdzenie_email" varchar(100) DEFAULT NULL,
  "email_odbiorcy" text,
  "email_kopie" text,
  "email_kopie_ukryte" text,
  "email_odpowiedzi" text,
  "email_tytul" varchar(200) DEFAULT NULL,
  "email_tresc_html" text,
  "email_tresc_txt" text,
  "email_zalaczniki" text,
  "email_szablon" integer DEFAULT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
);

CREATE TABLE "cms_email_kolejka" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "data_dodania" timestamp NOT NULL,
  "id_formatki" integer NOT NULL,
  "typ_wysylania" email_formatki_wysylanie NOT NULL DEFAULT 'natychmiast',
  "bledy_licznik" integer DEFAULT '0',
  "bledy_opis" text,
  "email_nadawca_email" varchar(100) DEFAULT NULL,
  "email_nadawca_nazwa" varchar(100) DEFAULT NULL,
  "email_potwierdzenie_email" varchar(100) DEFAULT NULL,
  "email_odbiorcy" text,
  "email_kopie" text,
  "email_kopie_ukryte" text,
  "email_odpowiedzi" text,
  "email_tytul" varchar(200) DEFAULT NULL,
  "email_tresc_html" text,
  "email_tresc_txt" text,
  "email_zalaczniki" text,
  "email_zalaczniki_katalog" varchar(200) DEFAULT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
);

CREATE TABLE "cms_kategorie" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "prawy" integer NOT NULL,
  "lewy" integer NOT NULL,
  "poziom" integer NOT NULL,
  "czy_widoczna" boolean NOT NULL DEFAULT true,
  "dla_zalogowanych" boolean DEFAULT false,
  "wymaga_https" boolean DEFAULT false,
  "typ" varchar(16) NOT NULL,
  "kod_modulu" varchar(32) DEFAULT NULL,
  "id_widoku" integer DEFAULT NULL,
  "kontener" varchar(60) DEFAULT NULL,
  "akcja_kontener" text,
  "akcja_uklad_strony" text,
  "akcja_klasa" text,
  "akcja_szablon" text,
  "stary_url" varchar(255) DEFAULT NULL,
  "blokada" integer NOT NULL DEFAULT 0,
  "nazwa" varchar(255) NOT NULL,
  "nazwa_przyjazna" varchar(255) DEFAULT NULL,
  "kod" varchar(32) NULL,
  "pelny_link" varchar(255) DEFAULT NULL,
  "tytul_strony" varchar(255) DEFAULT NULL,
  "opis" varchar(255) DEFAULT NULL,
  "slowa_kluczowe" varchar(255) DEFAULT NULL,
  "id_kategorii" integer DEFAULT NULL,
  "adres_zewnetrzny" varchar(255) DEFAULT NULL,
  "skrypt" text,
  "rss_wlaczony" boolean NOT NULL DEFAULT false,
  "szablon" varchar(100) DEFAULT NULL,
  "naglowek_html" text,
  "naglowek_http" text,
  "cache" boolean NOT NULL DEFAULT false,
  "czas_cache" integer DEFAULT NULL,
  "klasa" varchar(100) DEFAULT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
);

CREATE TYPE konfiguracja_typy AS ENUM ('boolean','integer','float','string','array','object');

CREATE TABLE "cms_konfiguracja" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL DEFAULT '',
  "kod_modulu" varchar(50) DEFAULT NULL,
  "id_kategorii" integer DEFAULT NULL,
  "id_bloku" integer DEFAULT NULL,
  "nazwa" varchar(100) NOT NULL,
  "typ" konfiguracja_typy NOT NULL DEFAULT 'string',
  "wartosc" text NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
);

CREATE TABLE "cms_logowanie_operacji" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "czas" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "adres_ip" varchar(15) NOT NULL,
  "przegladarka" varchar(255) NOT NULL,
  "id_uzytkownika" integer DEFAULT NULL,
  "id_kategorii" integer DEFAULT NULL,
  "usluga" varchar(8) NOT NULL,
  "kod_modulu" varchar(50) DEFAULT NULL,
  "akcja" varchar(50) DEFAULT NULL,
  "zadanie_http" text,
  "dane_dodatkowe" text,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "cms_pliki" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "url" varchar(255) NOT NULL,
  PRIMARY KEY ("id","id_projektu")
);

CREATE TABLE "cms_pliki_role_powiazania" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "id_pliku" integer NOT NULL,
  "id_roli" integer NOT NULL,
  PRIMARY KEY ("id","id_projektu")
  );

CREATE TABLE "cms_pliki_uzytkownicy_powiazania" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "id_pliku" integer NOT NULL,
  "id_uzytkownika" integer NOT NULL,
  PRIMARY KEY ("id","id_projektu")
  );

CREATE TABLE "cms_powiazania" (
  "id" integer NOT NULL,
  "id1" integer NOT NULL,
  "id2" integer NOT NULL,
  "typ" integer NOT NULL,
  "data_start" timestamp DEFAULT NULL,
  "data_stop" timestamp DEFAULT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "cms_powiazania_typy" (
  "id" integer NOT NULL,
  "nazwa" varchar(150) NOT NULL,
  "typ1" varchar(150) NOT NULL,
  "typ2" varchar(150) NOT NULL,
  "nazwa_mappera1" varchar(150) NOT NULL,
  "nazwa_mappera2" varchar(150) NOT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "cms_role" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod" varchar(16) NOT NULL,
  "nazwa" varchar(32) NOT NULL,
  "opis" text NOT NULL,
  "moduly_dostep" text,
  PRIMARY KEY ("id","id_projektu")
  );

CREATE TABLE "cms_role_uprawnienia" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_roli" integer NOT NULL,
  "id_uprawnienia" integer NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "cms_role_uprawnienia_administracyjne" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_roli" integer NOT NULL,
  "id_uprawnienia_administracyjnego" integer NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TYPE tlumaczenia_typy AS ENUM ('boolean','integer','float','string','array','object');

CREATE TABLE "cms_tlumaczenia" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL DEFAULT '',
  "kod_modulu" varchar(50) DEFAULT NULL,
  "id_kategorii" integer DEFAULT NULL,
  "id_bloku" integer DEFAULT NULL,
  "nazwa" varchar(100) NOT NULL,
  "typ" tlumaczenia_typy NOT NULL DEFAULT 'string',
  "wartosc" text NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "cms_uprawnienia" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "usluga" varchar(8) NOT NULL,
  "kod_modulu" varchar(50) DEFAULT NULL,
  "id_kategorii" integer NOT NULL,
  "akcja" varchar(50) NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "cms_uprawnienia_administracyjne" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "kod_modulu" varchar(50) NOT NULL,
  "akcja" varchar(50) NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TYPE uzytkownicy_statusy AS ENUM ('nieaktywny','aktywny','zablokowany');
CREATE TYPE uzytkownicy_typy_aktywacji AS ENUM ('klient','admin','regulamin');

CREATE TABLE "cms_uzytkownicy" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "login" varchar(32) NOT NULL,
  "haslo" varchar(32) NOT NULL,
  "email" varchar(128) NOT NULL,
  "data_dodania" timestamp NULL DEFAULT NULL,
  "data_aktywacji" timestamp NULL,
  "token" varchar(32) DEFAULT NULL,
  "czy_admin" integer DEFAULT NULL,
  "status" uzytkownicy_statusy NOT NULL DEFAULT 'nieaktywny',
  "imie" varchar(50) DEFAULT NULL,
  "nazwisko" varchar(50) DEFAULT NULL,
  "rok_urodzenia" date DEFAULT NULL,
  "plec" varchar(1) DEFAULT NULL,
  "kontakt_telefon" varchar(15) DEFAULT NULL,
  "kontakt_komorka" varchar(15) DEFAULT NULL,
  "kontakt_fax" varchar(15) DEFAULT NULL,
  "kontakt_www" varchar(128) DEFAULT NULL,
  "kontakt_nazwa" varchar(255) DEFAULT NULL,
  "kontakt_adres" varchar(90) DEFAULT NULL,
  "kontakt_kod_pocztowy" varchar(6) DEFAULT NULL,
  "kontakt_miasto" varchar(50) DEFAULT NULL,
  "firma_nazwa" varchar(255) DEFAULT NULL,
  "firma_nip" varchar(10) DEFAULT NULL,
  "firma_adres" varchar(90) DEFAULT NULL,
  "firma_kod_pocztowy" varchar(6) DEFAULT NULL,
  "firma_miasto" varchar(50) DEFAULT NULL,
  "poczta_host" varchar(100) DEFAULT NULL,
  "poczta_port" integer DEFAULT NULL,
  "poczta_login" varchar(50) DEFAULT NULL,
  "poczta_haslo" varchar(50) DEFAULT NULL,
  "jezyk" varchar(2) NOT NULL DEFAULT 'pl',
  "zgoda_mailing" integer NOT NULL,
  "zgoda_marketing" integer NOT NULL,
  "typ_aktywacji" uzytkownicy_typy_aktywacji DEFAULT 'klient',
  "numer_konta_bankowego" varchar(64) DEFAULT NULL,
  "numer_umowy" varchar(32) DEFAULT NULL,
  "mapa_dlugosc" varchar(20) NOT NULL,
  "mapa_szerokosc" varchar(20) NOT NULL,
  PRIMARY KEY ("id","id_projektu")
  );

CREATE TABLE "cms_uzytkownicy_role" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "id_uzytkownika" integer NOT NULL,
  "id_roli" integer NOT NULL,
  PRIMARY KEY ("id","id_projektu")
  );

CREATE TABLE "cms_widoki" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "nazwa" varchar(50) NOT NULL,
  "uklad_strony" varchar(50) NOT NULL,
  "struktura" text NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "cms_zadania_cykliczne" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "aktywne" boolean NOT NULL DEFAULT FALSE,
  "data_rozpoczecia" timestamp NULL DEFAULT NULL,
  "data_zakonczenia" timestamp NULL DEFAULT NULL,
  "minuty" varchar(2) DEFAULT '*',
  "godziny" varchar(2) DEFAULT '*',
  "dni" varchar(2) DEFAULT '*',
  "miesiace" varchar(2) DEFAULT '*',
  "dni_tygodnia" varchar(1) DEFAULT '*',
  "kod_modulu" varchar(32) DEFAULT NULL,
  "id_kategorii" integer NOT NULL,
  "akcja" varchar(50) NOT NULL,
  "opis_zadania" text NOT NULL,
  "dodawane_wielokrotnie" integer NOT NULL DEFAULT '0',
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "modul_aktualnosci" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_kategorii" integer NOT NULL,
  "tytul" varchar(255) NOT NULL,
  "zajawka" text,
  "zdjecie_glowne" varchar(255) DEFAULT NULL,
  "tresc" text,
  "id_uzytkownika" integer NOT NULL,
  "autor" varchar(255) NOT NULL,
  "data_dodania" timestamp NULL DEFAULT NULL,
  "data_waznosci" timestamp NULL DEFAULT NULL,
  "priorytetowa" integer NOT NULL DEFAULT '0',
  "publikuj" integer NOT NULL DEFAULT '1',
  "id_galerii" integer DEFAULT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "modul_blok_opisowy" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_bloku" integer NOT NULL,
  "tytul" varchar(255) NOT NULL,
  "tresc" text,
  "id_uzytkownika" integer NOT NULL,
  "data_dodania" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "modul_formularz_kontaktowy_tematy" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_kategorii" integer NOT NULL,
  "temat" varchar(255) NOT NULL,
  "email" varchar(500) NOT NULL DEFAULT 'a:0:{}',
  "email_dw" varchar(500) NOT NULL DEFAULT 'a:0:{}',
  "konfiguracja" varchar(500) NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
);

CREATE TABLE "modul_formularz_kontaktowy_wiadomosci" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_kategorii" integer NOT NULL,
  "id_tematu" integer NOT NULL,
  "tresc" text,
  "data_wyslania" timestamp NULL DEFAULT NULL,
  "imie" varchar(50) DEFAULT NULL,
  "nazwisko" varchar(50) DEFAULT NULL,
  "email" varchar(128) NOT NULL,
  "firma_nazwa" varchar(128) DEFAULT NULL,
  "strona_www" varchar(128) DEFAULT NULL,
  "gg" varchar(20) DEFAULT NULL,
  "skype" varchar(128) DEFAULT NULL,
  "telefon" varchar(15) DEFAULT NULL,
  "komorka" varchar(15) DEFAULT NULL,
  "fax" varchar(15) DEFAULT NULL,
  "id_uzytkownika" integer DEFAULT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

CREATE TABLE "modul_mailing" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "data_dodania" timestamp NOT NULL,
  "nazwa" varchar(150) NOT NULL,
  "tytul" varchar(150) NOT NULL,
  "tresc" text NOT NULL,
  "tresc_html" text NOT NULL,
  "plik_z_lista" varchar(255) NOT NULL,
  "data_wysylki" timestamp NOT NULL,
  "ile_adresow" integer NOT NULL,
  "ile_wyslano" integer NOT NULL,
  "ile_bledow" integer NOT NULL,
  "id_zadania_cron" integer DEFAULT NULL,
  "data_zakonczenia" timestamp NOT NULL,
  "nazwa_nadawcy" varchar(80) NOT NULL,
  "email_nadawcy" varchar(80) NOT NULL,
  "zaladuj_szablon" integer NOT NULL,
  "pomin_sprawdzanie_zgody" integer NOT NULL,
  PRIMARY KEY ("id")
  );

CREATE TYPE platnosci_systemy_platnosci AS ENUM ('platnosci','paypal');

CREATE TABLE "modul_platnosci" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "data_dodania" timestamp NULL DEFAULT NULL,
  "id_uzytkownika" integer DEFAULT NULL,
  "system_platnosci" platnosci_systemy_platnosci NOT NULL,
  "kod_modulu" varchar(100) NOT NULL,
  "id_kategorii_modulu" integer NOT NULL,
  "typ_obiektu" varchar(100) NOT NULL,
  "id_obiektu" integer NOT NULL,
  "kwota" float NOT NULL,
  "waluta" varchar(5) NOT NULL,
  "opis" varchar(100) NOT NULL,
  "typ_platnosci" varchar(100) DEFAULT NULL,
  "status" varchar(20) NOT NULL,
  "imie" varchar(100) DEFAULT NULL,
  "nazwisko" varchar(100) DEFAULT NULL,
  "ulica" varchar(100) DEFAULT NULL,
  "nr_domu" varchar(10) DEFAULT NULL,
  "nr_lokalu" varchar(10) DEFAULT NULL,
  "kod_pocztowy" varchar(6) DEFAULT NULL,
  "miasto" varchar(100) DEFAULT NULL,
  "wojewodztwo" varchar(20) DEFAULT NULL,
  "kraj" varchar(2) DEFAULT 'pl',
  "email" varchar(128) NOT NULL,
  "telefon" varchar(15) DEFAULT NULL,
  "dane_wyslane" text,
  "dane_odebrane" text,
  PRIMARY KEY ("id","id_projektu")
);

CREATE TABLE "modul_platnosci_historia" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "id_platnosci" integer NOT NULL,
  "data_dodania" timestamp NULL DEFAULT NULL,
  "operacja" varchar(32) DEFAULT NULL,
  "dane_wyslane" text,
  "dane_odebrane" text,
  PRIMARY KEY ("id","id_projektu")
  );

CREATE TABLE "modul_strona_opisowa" (
  "id" integer NOT NULL,
  "id_projektu" integer NOT NULL,
  "kod_jezyka" varchar(2) NOT NULL,
  "id_kategorii" integer NOT NULL,
  "tytul" varchar(255) NOT NULL,
  "tresc" text,
  "id_uzytkownika" integer NOT NULL,
  "data_dodania" timestamp NULL DEFAULT NULL,
  "katalog" varchar(128) NOT NULL,
  PRIMARY KEY ("id","id_projektu","kod_jezyka")
  );

ALTER TABLE "cms_powiazania_typy" ADD UNIQUE("nazwa");

ALTER TABLE "cms_projekty" ADD UNIQUE("kod", "domena");

ALTER TABLE "cms_uzytkownicy" ADD UNIQUE("token");


ALTER TABLE cms_bloki ADD CONSTRAINT cms_bloki_id_projektu_key UNIQUE(id_projektu, kod_jezyka);

ALTER TABLE cms_jezyki ADD CONSTRAINT cms_jezyki_id_projektu_key UNIQUE(id_projektu);

ALTER TABLE cms_jezyki ADD CONSTRAINT cms_jezyki_id_projektu_key1 UNIQUE(id_projektu, kod);

ALTER TABLE cms_projekty ADD CONSTRAINT cms_projekty_kod_key2 UNIQUE(kod);

ALTER TABLE cms_projekty ADD CONSTRAINT cms_projekty_domena_key UNIQUE(domena);

ALTER TABLE modul_formularz_kontaktowy_tematy ADD CONSTRAINT modul_formularz_kontaktowy_tematy_id_key UNIQUE("id", "id_projektu", "kod_jezyka", "id_kategorii");

ALTER TABLE cms_zadania_cykliczne ADD CONSTRAINT cms_zadania_cykliczne_id_key UNIQUE(id);




ALTER TABLE cms_bloki
  ADD CONSTRAINT cms_bloki_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_jezyki
  ADD CONSTRAINT cms_jezyki_id_projektu_fkey FOREIGN KEY (id_projektu)
      REFERENCES cms_projekty (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_kategorie
  ADD CONSTRAINT cms_kategorie_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_konfiguracja
  ADD CONSTRAINT cms_konfiguracja_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_logowanie_operacji
  ADD CONSTRAINT cms_logowanie_operacji_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_pliki_role_powiazania
  ADD CONSTRAINT cms_pliki_role_powiazania_id_roli_fkey FOREIGN KEY ("id_roli", "id_projektu")
      REFERENCES cms_role ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_pliki_role_powiazania
  ADD CONSTRAINT cms_pliki_role_powiazania_id_pliku_fkey FOREIGN KEY ("id_pliku", "id_projektu")
      REFERENCES cms_pliki ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_pliki_uzytkownicy_powiazania
  ADD CONSTRAINT cms_pliki_uzytkownicy_powiazania_id_uzytkownika_fkey FOREIGN KEY ("id_uzytkownika", "id_projektu")
      REFERENCES cms_uzytkownicy ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_pliki_uzytkownicy_powiazania
  ADD CONSTRAINT cms_pliki_uzytkownicy_powiazania_id_pliku_fkey FOREIGN KEY ("id_pliku", "id_projektu")
      REFERENCES cms_pliki ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_role
  ADD CONSTRAINT cms_role_id_projektu_fkey FOREIGN KEY (id_projektu)
      REFERENCES cms_projekty (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_role_uprawnienia
  ADD CONSTRAINT cms_role_uprawnienia_id_roli_fkey FOREIGN KEY ("id_roli", "id_projektu")
      REFERENCES cms_role ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_role_uprawnienia
  ADD CONSTRAINT cms_role_uprawnienia_id_uprawnienia_fkey FOREIGN KEY ("id_uprawnienia", "id_projektu", "kod_jezyka")
      REFERENCES cms_uprawnienia ("id", "id_projektu", "kod_jezyka") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_role_uprawnienia_administracyjne
  ADD CONSTRAINT cms_role_uprawnienia_administracyjne_id_roli_fkey FOREIGN KEY ("id_roli", "id_projektu")
      REFERENCES cms_role ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_role_uprawnienia_administracyjne
  ADD CONSTRAINT cms_role_uprawnienia_administracyjne_id_uprawnienia_fkey FOREIGN KEY ("id_uprawnienia_administracyjnego", "id_projektu", "kod_jezyka")
      REFERENCES cms_uprawnienia_administracyjne ("id", "id_projektu", "kod_jezyka") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_tlumaczenia
  ADD CONSTRAINT cms_tlumaczenia_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_uprawnienia
  ADD CONSTRAINT cms_uprawnienia_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_uprawnienia_administracyjne
  ADD CONSTRAINT cms_uprawnienia_administracyjne_id_projektu_fkey FOREIGN KEY (id_projektu, kod_jezyka)
      REFERENCES cms_jezyki (id_projektu, kod) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_uzytkownicy
  ADD CONSTRAINT cms_uzytkownicy_id_projektu_fkey FOREIGN KEY (id_projektu)
      REFERENCES cms_projekty (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_uzytkownicy_role
  ADD CONSTRAINT cms_uzytkownicy_role_id_uzytkownika_fkey FOREIGN KEY ("id_uzytkownika", "id_projektu")
      REFERENCES cms_uzytkownicy ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_uzytkownicy_role
  ADD CONSTRAINT cms_uzytkownicy_role_id_roli_fkey FOREIGN KEY ("id_roli", "id_projektu")
      REFERENCES cms_role ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_widoki
  ADD CONSTRAINT cms_widoki_kod_jezyka_fkey FOREIGN KEY ("kod_jezyka", "id_projektu")
      REFERENCES cms_jezyki ("kod", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE cms_zadania_cykliczne
  ADD CONSTRAINT cms_zadania_cykliczne_kod_jezyka_fkey FOREIGN KEY ("kod_jezyka", "id_projektu")
      REFERENCES cms_jezyki ("kod", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE modul_aktualnosci
  ADD CONSTRAINT modul_aktualnosci_id_kategorii_fkey FOREIGN KEY ("id_kategorii", "id_projektu", "kod_jezyka")
      REFERENCES cms_kategorie ("id", "id_projektu", "kod_jezyka") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE modul_blok_opisowy
  ADD CONSTRAINT modul_blok_opisowy_id_kategorii_fkey FOREIGN KEY ("id_bloku", "id_projektu", "kod_jezyka")
      REFERENCES cms_bloki ("id", "id_projektu", "kod_jezyka") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE modul_formularz_kontaktowy_wiadomosci
  ADD CONSTRAINT modul_formularz_kontaktowy_wiadomosci_id_tematu_fkey FOREIGN KEY ("id_tematu","id_projektu","kod_jezyka","id_kategorii")
      REFERENCES modul_formularz_kontaktowy_tematy ("id", "id_projektu", "kod_jezyka", "id_kategorii") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE modul_mailing
  ADD CONSTRAINT modul_mailing_id_zadania_cron_fkey FOREIGN KEY (id_zadania_cron)
      REFERENCES cms_zadania_cykliczne ("id") MATCH SIMPLE
      ON DELETE SET NULL ON UPDATE NO ACTION;

ALTER TABLE modul_platnosci
  ADD CONSTRAINT modul_platnosci_id_projektu_fkey FOREIGN KEY (id_projektu)
      REFERENCES cms_projekty (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE modul_platnosci_historia
  ADD CONSTRAINT modul_platnosci_historia_id_platnosci_fkey FOREIGN KEY ("id_platnosci", "id_projektu")
      REFERENCES "modul_platnosci" ("id", "id_projektu") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;




INSERT INTO "cms_projekty" ("id", "kod", "domena", "nazwa", "szablon", "opis", "domyslny_jezyk", "przypisane_moduly", "moduly_rss", "moduly_cron") VALUES (1,'projekt_domyslny','traderslocal2.pl','Super Traders','szablon_domyslny','','pl',',Aktualnosci,CropperZdjec,FormularzKontaktowy,Galeria,KontoUzytkownika,MapaStrony,Platnosci,StronaOpisowa,BlokMenu,BlokOpisowy,BlokAktualnosci,BlokCzytnikRss,BlokSciezka,',',Aktualnosci,',',Platnosci,');

INSERT INTO "cms_jezyki" ("id", "kod", "id_projektu", "nazwa") VALUES (1,'pl',1,'Polski');

INSERT INTO "cms_kategorie" ("id", "id_projektu", "kod_jezyka", "prawy", "lewy", "poziom", "czy_widoczna", "dla_zalogowanych", "wymaga_https", "typ", "kod_modulu", "id_widoku", "kontener", "akcja_kontener", "akcja_uklad_strony", "akcja_klasa", "akcja_szablon", "stary_url", "blokada", "nazwa", "nazwa_przyjazna", "kod", "pelny_link", "tytul_strony", "opis", "slowa_kluczowe", "id_kategorii", "adres_zewnetrzny", "skrypt", "rss_wlaczony", "szablon", "naglowek_html", "naglowek_http", "cache", "czas_cache", "klasa") VALUES (1,1,'pl',8,1,0,1,1,0,'system',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'System',NULL,'_system_','_system_','System',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL),(2,1,'pl',7,2,1,1,0,0,'glowna','StronaOpisowa',29,NULL,NULL,NULL,NULL,NULL,NULL,0,'Strona główna','Strona główna','','','SuperTraders - portal kompleksowo promujący firmy w internecie','SuperTraders - portal umożliwiający kompleksową promocję firm w internecie, ułatwiający kontakty biznesowe pomiędzy przedsiębiorcami, pozwalający na pełniejsze wykorzystanie możliwości internetu w promocji i rozwoju przedsiębiorstw.','supertraders, portal b2b, katalog firm, lokalizator produktów i usług, ogłoszenia biznesowe',NULL,NULL,NULL,0,NULL,'<meta name=\"google-site-verification\" content=\"mjAIkLAkDyJZ_h-DDg_6URR8UOaKPN5WwwRkRVT8q58\" />',NULL,0,NULL,NULL),(9,1,'pl',4,3,2,1,0,0,'kategoria','FormularzKontaktowy',29,'fe_kontener_pomocy',NULL,NULL,NULL,NULL,NULL,0,'Kontakt','Kontakt','kontakt','/kontakt/','Kontakt z  Supertraders','Kontakt z SuperTraders.pl - tutaj możesz wysłać widomość do naszego serwisu.','kontakt, formularz kontaktowy, SuperTraders.pl',NULL,NULL,NULL,0,NULL,'<link rel=\"canonical\" href=\"http://www.supertraders.pl/kontakt\" />',NULL,0,NULL,NULL),(10,1,'pl',6,5,2,1,1,0,'kategoria','KontoUzytkownika',29,NULL,NULL,NULL,NULL,NULL,'//',0,'Logowanie','Logowanie','logowanie','/logowanie/','',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL);

INSERT INTO "cms_konfiguracja" ("id", "id_projektu", "kod_jezyka", "kod_modulu", "id_kategorii", "id_bloku", "nazwa", "typ", "wartosc") VALUES (128,1,'pl',NULL,NULL,NULL,'logi.logowaneAkcje','array','a:1:{i:0;s:31:\"Http_StronaOpisowa_wykonajIndex\";}'),(231,1,'pl','UzytkownicyZarzadzanie_Admin',NULL,NULL,'index.pager_konfiguracja','array','a:7:{s:6:\"zakres\";s:1:\"5\";s:11:\"wyborStrony\";s:5:\"linki\";s:12:\"wyborZakresu\";s:6:\"select\";s:16:\"pierwszaOstatnia\";s:1:\"1\";s:18:\"poprzedniaNastepna\";s:1:\"1\";s:15:\"dostepneZakresy\";s:0:\"\";s:7:\"skoczDo\";s:4:\"form\";}'),(957,1,'pl','Platnosci_Http',124,NULL,'nowa.wybor_typu_platnosci','integer','1'),(1205,1,'pl','Testy_Admin',NULL,NULL,'resetujDaneUzytkownikow.raport_wyslij','integer','1'),(1206,1,'pl','EdytorGraficzny_Admin',NULL,NULL,'wielkosc_miniatury','array','a:2:{s:9:\"szerokosc\";s:2:\"90\";s:8:\"wysokosc\";s:2:\"90\";}');

INSERT INTO "cms_pliki" ("id", "id_projektu", "url") VALUES (1,1,'temp/1.png');

INSERT INTO "cms_powiazania" ("id", "id1", "id2", "typ", "data_start", "data_stop") VALUES (1,3114,1301,1,NULL,NULL),(2,1301,2776,1,NULL,NULL),(3,3115,1301,1,NULL,NULL),(4,2917,1301,1,NULL,NULL),(5,1297,1301,1,NULL,NULL),(6,1305,2776,1,NULL,NULL),(7,2410,1305,1,NULL,NULL),(8,1602,1305,1,NULL,NULL),(9,3128,1305,1,NULL,NULL),(10,1308,1305,1,NULL,NULL),(11,2747,1305,1,NULL,NULL),(12,1312,2776,1,NULL,NULL),(13,3117,1312,1,NULL,NULL),(14,2748,1312,1,NULL,NULL),(15,2409,1312,1,NULL,NULL),(16,2407,0,1,NULL,NULL);

INSERT INTO "cms_powiazania_typy" ("id", "nazwa", "typ1", "typ2", "nazwa_mappera1", "nazwa_mappera2") VALUES (1,'przelozonyPracownika','Uzytkownik','Uzytkownik','Uzytkownicy','Uzytkownicy');

INSERT INTO "cms_role" ("id", "id_projektu", "kod", "nazwa", "opis", "moduly_dostep") VALUES (1,1,'administrator','Administrator','Administruje serwisem, ma pełny dostęp do systemu.',',Aktualnosci,CropperZdjec,Dokumenty,Filtr18,FormularzKontaktowy,Galeria,KontoKorektora,KontoSerwisowe,KontoUzytkownika,MapaStrony,WizytowkiOdnowienia,Oferty,Ogloszenia,WizytowkaPodglad,PracownicyUrlopy,Produkty,Platnosci,Raporty,RaportyBok,RaportyEdytowalne,RejestracjaSuperads,RejestracjaSuperwebsite,RejestracjaPrzedstawiciel,RejestracjaNowa,StronaOpisowa,Uzupelnienia,Wiadomosci,WiadomosciWizytowki,Wizytowki,Wyszukiwarka,KategorieOgloszenZarzadzanie,WizytowkiMaterialy,OfertyZarzadzanie,OgloszeniaZarzadzanie,WizytowkiZarzadzanie,WizytowkiZarzadzanieNowa,WizytowkiSpecjalistowZarzadzanie,AktualnosciUzytkownikow,BlokDodaneOferty,BlokMenu,BlokOpisowy,BlokZobaczRowniez,BlokAktualnosci,BlokBranzeFirm,BlokCzytnikRss,BlokFiltrowWyszukiwania,BlokKontoInformacje,BlokKategorieOfert,BlokOgloszeniaKategorie,BlokKategorieWizytowki,BlokKontaktOpiekun,BlokKontaktWizytowki,BlokKontoUzytkownika,BlokOfertyKategorieLista,BlokLokalizacjeOfert,BlokMenuUzytkownika,BlokMenuWizytowki,BlokNieprzeczytaneWiadomosci,BlokOgloszenia,BlokOgloszeniaPromowane,BlokMenuUzytkownikaPionowe,BlokPomocy,BlokPorownywarkaProduktow,BlokRegulaminWprowadzaniaMaterialow,BlokRegulaminWprowadzaniaTresci,BlokSaldoUzupelnien,BlokOgloszeniaSchowek,BlokSprzedawcy,BlokTytulKataloguOfertFirm,BlokWizytowki,BlokWyszukiwarka,BlokWyszukiwarkaTresci,BlokGoogleMaps,BlokMalaWyszukiwarka,BlokWyszukiwarkaZakladki,BlokSciezka,'),(4,1,'uzytkownik','Użytkownik','Użytkownik Serwisu. Uprawnienia dla tej roli należy ustawić ręcznie, bardzo ostrożnie i tylko dla usługi Http. Nie powinien mieć żadnych uprawnień do części administracyjnej.',',,');

INSERT INTO "cms_uprawnienia" ("id", "id_projektu", "kod_jezyka", "usluga", "kod_modulu", "id_kategorii", "akcja") VALUES (17,1,'pl','Admin','StronaOpisowa',2,'wykonajIndex'),(18,1,'pl','Admin','Aktualnosci',3,'wykonajIndex'),(19,1,'pl','Admin','Aktualnosci',3,'wykonajDodaj'),(20,1,'pl','Admin','Aktualnosci',3,'wykonajEdytuj'),(21,1,'pl','Admin','Aktualnosci',3,'wykonajUsun'),(22,1,'pl','Admin','Aktualnosci',3,'wykonajUsunZdjecie'),(35,1,'pl','Admin','StronaOpisowa',7,'wykonajIndex'),(37,1,'pl','Admin','FormularzKontaktowy',9,'wykonajIndex'),(38,1,'pl','Admin','FormularzKontaktowy',9,'wykonajKonfiguruj'),(39,1,'pl','Admin','FormularzKontaktowy',9,'wykonajEdytujTrescPrzed'),(40,1,'pl','Admin','FormularzKontaktowy',9,'wykonajEdytujTrescPo'),(41,1,'pl','Admin','FormularzKontaktowy',9,'wykonajDodaj'),(42,1,'pl','Admin','FormularzKontaktowy',9,'wykonajEdytuj'),(43,1,'pl','Admin','FormularzKontaktowy',9,'wykonajZapiszTemat'),(44,1,'pl','Admin','FormularzKontaktowy',9,'wykonajPodglad'),(45,1,'pl','Admin','FormularzKontaktowy',9,'wykonajUsun'),(46,1,'pl','Admin','FormularzKontaktowy',9,'wykonajUsunWiadomosc'),(55,1,'pl','Admin','KontoUzytkownika',12,'wykonajIndex'),(56,1,'pl','Http','KontoUzytkownika',12,'wykonajIndex'),(57,1,'pl','Http','KontoUzytkownika',12,'wykonajGlowna'),(58,1,'pl','Http','KontoUzytkownika',12,'wykonajZaloguj'),(59,1,'pl','Http','KontoUzytkownika',12,'wykonajWyloguj'),(60,1,'pl','Http','KontoUzytkownika',12,'wykonajPrzypomnij'),(61,1,'pl','Http','KontoUzytkownika',12,'wykonajZmienHaslo'),(62,1,'pl','Http','KontoUzytkownika',12,'wykonajZmienEmail'),(63,1,'pl','Http','KontoUzytkownika',12,'wykonajEdytuj'),(64,1,'pl','Http','KontoUzytkownika',12,'wykonajUsun'),(90,1,'pl','Admin','Wiadomosci',15,'wykonajIndex'),(91,1,'pl','Admin','Wiadomosci',15,'wykonajNieprzypisane'),(92,1,'pl','Admin','Wiadomosci',15,'wykonajOdebrane'),(93,1,'pl','Admin','Wiadomosci',15,'wykonajWyslane'),(94,1,'pl','Admin','Wiadomosci',15,'wykonajUsuniete'),(95,1,'pl','Admin','Wiadomosci',15,'wykonajBranzowe'),(96,1,'pl','Admin','Wiadomosci',15,'wykonajNowaSerwis'),(97,1,'pl','Admin','Wiadomosci',15,'wykonajNowaWizytowka'),(98,1,'pl','Admin','Wiadomosci',15,'wykonajPodglad'),(99,1,'pl','Admin','Wiadomosci',15,'wykonajOdpowiedz'),(100,1,'pl','Admin','Wiadomosci',15,'wykonajAkceptujBranzowa'),(101,1,'pl','Admin','Wiadomosci',15,'wykonajAnulujAkceptacje'),(102,1,'pl','Admin','Wiadomosci',15,'wykonajPrzejmij'),(103,1,'pl','Admin','Wiadomosci',15,'wykonajUsun'),(104,1,'pl','Http','Wiadomosci',15,'wykonajIndex'),(105,1,'pl','Http','Wiadomosci',15,'wykonajOdebrane'),(106,1,'pl','Http','Wiadomosci',15,'wykonajWyslane'),(107,1,'pl','Http','Wiadomosci',15,'wykonajUsuniete'),(108,1,'pl','Http','Wiadomosci',15,'wykonajBranzowe'),(109,1,'pl','Http','Wiadomosci',15,'wykonajNowaSerwis'),(110,1,'pl','Http','Wiadomosci',15,'wykonajNowaBranzowa'),(111,1,'pl','Http','Wiadomosci',15,'wykonajNowaWizytowka'),(112,1,'pl','Http','Wiadomosci',15,'wykonajNowaOgloszenie'),(113,1,'pl','Http','Wiadomosci',15,'wykonajPodglad'),(114,1,'pl','Http','Wiadomosci',15,'wykonajOdpowiedz'),(115,1,'pl','Http','Wiadomosci',15,'wykonajUsun'),(116,1,'pl','Http','Wiadomosci',15,'wykonajBranzowaWycofaj'),(127,1,'pl','Admin','WizytowkaPodglad',18,'wykonajIndex'),(128,1,'pl','Admin','StronaOpisowa',20,'wykonajIndex'),(129,1,'pl','Admin','StronaOpisowa',21,'wykonajIndex'),(130,1,'pl','Admin','StronaOpisowa',22,'wykonajIndex'),(131,1,'pl','Admin','StronaOpisowa',23,'wykonajIndex'),(132,1,'pl','Admin','StronaOpisowa',24,'wykonajIndex'),(133,1,'pl','Admin','StronaOpisowa',25,'wykonajIndex'),(134,1,'pl','Admin','StronaOpisowa',26,'wykonajIndex'),(135,1,'pl','Admin','StronaOpisowa',27,'wykonajIndex'),(136,1,'pl','Admin','StronaOpisowa',28,'wykonajIndex'),(137,1,'pl','Admin','StronaOpisowa',30,'wykonajIndex'),(138,1,'pl','Admin','StronaOpisowa',31,'wykonajIndex'),(139,1,'pl','Admin','StronaOpisowa',32,'wykonajIndex'),(140,1,'pl','Admin','StronaOpisowa',33,'wykonajIndex'),(141,1,'pl','Admin','StronaOpisowa',34,'wykonajIndex'),(154,1,'pl','Admin','StronaOpisowa',35,'wykonajIndex'),(155,1,'pl','Admin','StronaOpisowa',36,'wykonajIndex'),(156,1,'pl','Admin','StronaOpisowa',37,'wykonajIndex'),(157,1,'pl','Admin','StronaOpisowa',38,'wykonajIndex'),(159,1,'pl','Admin','StronaOpisowa',40,'wykonajIndex'),(160,1,'pl','Admin','StronaOpisowa',41,'wykonajIndex'),(161,1,'pl','Admin','StronaOpisowa',42,'wykonajIndex'),(162,1,'pl','Admin','StronaOpisowa',43,'wykonajIndex'),(163,1,'pl','Admin','StronaOpisowa',44,'wykonajIndex'),(164,1,'pl','Admin','StronaOpisowa',45,'wykonajIndex'),(165,1,'pl','Admin','StronaOpisowa',46,'wykonajIndex'),(166,1,'pl','Admin','StronaOpisowa',47,'wykonajIndex'),(167,1,'pl','Admin','StronaOpisowa',48,'wykonajIndex'),(168,1,'pl','Admin','StronaOpisowa',49,'wykonajIndex'),(169,1,'pl','Admin','StronaOpisowa',50,'wykonajIndex'),(170,1,'pl','Admin','StronaOpisowa',51,'wykonajIndex'),(171,1,'pl','Admin','StronaOpisowa',52,'wykonajIndex'),(172,1,'pl','Admin','StronaOpisowa',53,'wykonajIndex'),(173,1,'pl','Admin','StronaOpisowa',54,'wykonajIndex'),(174,1,'pl','Admin','StronaOpisowa',55,'wykonajIndex'),(176,1,'pl','Admin','StronaOpisowa',58,'wykonajIndex'),(177,1,'pl','Admin','StronaOpisowa',59,'wykonajIndex'),(178,1,'pl','Admin','StronaOpisowa',60,'wykonajIndex'),(179,1,'pl','Admin','StronaOpisowa',61,'wykonajIndex'),(180,1,'pl','Admin','StronaOpisowa',62,'wykonajIndex'),(181,1,'pl','Admin','StronaOpisowa',63,'wykonajIndex'),(183,1,'pl','Admin','StronaOpisowa',65,'wykonajIndex'),(184,1,'pl','Admin','StronaOpisowa',66,'wykonajIndex'),(185,1,'pl','Admin','StronaOpisowa',67,'wykonajIndex'),(186,1,'pl','Admin','StronaOpisowa',68,'wykonajIndex'),(187,1,'pl','Admin','StronaOpisowa',69,'wykonajIndex'),(188,1,'pl','Admin','StronaOpisowa',70,'wykonajIndex'),(189,1,'pl','Admin','StronaOpisowa',71,'wykonajIndex'),(190,1,'pl','Admin','StronaOpisowa',72,'wykonajIndex'),(192,1,'pl','Admin','StronaOpisowa',74,'wykonajIndex'),(193,1,'pl','Admin','StronaOpisowa',75,'wykonajIndex'),(194,1,'pl','Admin','StronaOpisowa',76,'wykonajIndex'),(195,1,'pl','Admin','StronaOpisowa',77,'wykonajIndex'),(197,1,'pl','Admin','StronaOpisowa',79,'wykonajIndex'),(198,1,'pl','Admin','StronaOpisowa',80,'wykonajIndex'),(199,1,'pl','Admin','StronaOpisowa',81,'wykonajIndex'),(200,1,'pl','Admin','StronaOpisowa',82,'wykonajIndex'),(202,1,'pl','Admin','StronaOpisowa',84,'wykonajIndex'),(203,1,'pl','Admin','StronaOpisowa',85,'wykonajIndex'),(204,1,'pl','Admin','StronaOpisowa',86,'wykonajIndex'),(205,1,'pl','Admin','StronaOpisowa',87,'wykonajIndex'),(206,1,'pl','Admin','StronaOpisowa',88,'wykonajIndex'),(207,1,'pl','Admin','StronaOpisowa',89,'wykonajIndex'),(209,1,'pl','Admin','StronaOpisowa',91,'wykonajIndex'),(210,1,'pl','Admin','StronaOpisowa',92,'wykonajIndex'),(211,1,'pl','Admin','StronaOpisowa',93,'wykonajIndex'),(212,1,'pl','Admin','StronaOpisowa',94,'wykonajIndex'),(217,1,'pl','Admin','Dokumenty',96,'wykonajIndex'),(218,1,'pl','Admin','Dokumenty',96,'wykonajPodgladDokumentu'),(219,1,'pl','Admin','Dokumenty',96,'wykonajSzablony'),(220,1,'pl','Admin','Dokumenty',96,'wykonajDodaj'),(221,1,'pl','Admin','Dokumenty',96,'wykonajEdytuj'),(222,1,'pl','Admin','Dokumenty',96,'wykonajUsun'),(224,1,'pl','Admin','Aktualnosci',3,'wykonajPoprawMiniaturke'),(237,1,'pl','Http','KontoUzytkownika',12,'wykonajUsunKonto'),(249,1,'pl','Admin','StronaOpisowa',101,'wykonajIndex'),(251,1,'pl','Admin','StronaOpisowa',122,'wykonajIndex'),(253,1,'pl','Admin','Wiadomosci',15,'wykonajUsunBranzowa'),(260,1,'pl','Http','Dokumenty',96,'wykonajIndex'),(261,1,'pl','Http','Dokumenty',96,'wykonajLista'),(262,1,'pl','Http','Dokumenty',96,'wykonajPodglad'),(280,1,'pl','Admin','Platnosci',124,'wykonajIndex'),(281,1,'pl','Admin','Platnosci',124,'wykonajPodglad'),(282,1,'pl','Admin','Platnosci',124,'wykonajStatus'),(283,1,'pl','Admin','Platnosci',124,'wykonajPotwierdz'),(284,1,'pl','Admin','Platnosci',124,'wykonajAnuluj'),(285,1,'pl','Admin','Platnosci',124,'wykonajUsun'),(291,1,'pl','Admin','Dokumenty',96,'wykonajPodglad'),(292,1,'pl','Admin','Dokumenty',96,'wykonajStatus'),(293,1,'pl','Http','Dokumenty',96,'wykonajOplac'),(300,1,'pl','Http','KontoUzytkownika',12,'kontoSerwisowe'),(301,1,'pl','Admin','Dokumenty',96,'wykonajEdytujDokument'),(302,1,'pl','Admin','Dokumenty',96,'wykonajWyslijFakture'),(303,1,'pl','Admin','KontoSerwisowe',127,'wykonajIndex'),(304,1,'pl','Http','KontoSerwisowe',127,'wykonajIndex'),(305,1,'pl','Http','KontoSerwisowe',127,'wykonajListaWizytowek'),(306,1,'pl','Http','KontoSerwisowe',127,'listaWizytowekWidokPelny'),(307,1,'pl','Http','KontoSerwisowe',127,'wykonajListaNotatek'),(308,1,'pl','Http','KontoSerwisowe',127,'wykonajPrzechwyc'),(309,1,'pl','Http','KontoSerwisowe',127,'wykonajNotatka'),(310,1,'pl','Http','KontoSerwisowe',127,'wykonajEdytuj'),(313,1,'pl','Http','KontoUzytkownika',12,'wykonajEmailAKtywacyjny'),(314,1,'pl','Http','KontoSerwisowe',127,'wszystkieNotatki'),(315,1,'pl','Http','KontoSerwisowe',127,'wykonajEdytujNotatke'),(316,1,'pl','Http','KontoSerwisowe',127,'wykonajPodgladNotatki'),(317,1,'pl','Http','KontoSerwisowe',127,'edycjaWizytowki'),(318,1,'pl','Http','KontoSerwisowe',127,'zmianaStatusu'),(322,1,'pl','Admin','Raporty',129,'wykonajIndex'),(323,1,'pl','Http','Raporty',129,'wykonajIndex'),(324,1,'pl','Http','Raporty',129,'wykonajListaKlienci'),(325,1,'pl','Http','Raporty',129,'wykonajPodgladKlienta'),(326,1,'pl','Http','Raporty',129,'wykonajEdycjaKlienta'),(327,1,'pl','Http','Raporty',129,'edycjaStatusowWplat'),(328,1,'pl','Http','KontoUzytkownika',12,'raporty'),(329,1,'pl','Admin','Dokumenty',96,'opcjeSystemowe'),(331,1,'pl','Admin','StronaOpisowa',131,'wykonajIndex'),(332,1,'pl','Http','Wiadomosci',15,'wykonajNowaOpiekun'),(333,1,'pl','Http','Wiadomosci',15,'wykonajWiadomoscBlad'),(334,1,'pl','Http','KontoSerwisowe',127,'wykonajListaOgloszen'),(335,1,'pl','Http','KontoSerwisowe',127,'wykonajSaldoUzupelnien'),(336,1,'pl','Http','KontoSerwisowe',127,'wykonajSprawdzOgloszenie'),(337,1,'pl','Http','KontoSerwisowe',127,'wykonajPoprawOgloszenie'),(341,1,'pl','Admin','Dokumenty',96,'wykonajWyslijDokument'),(343,1,'pl','Admin','Dokumenty',96,'wykonajZablokujPrzypomnienie'),(344,1,'pl','Admin','Dokumenty',96,'wykonajOdblokujPrzypomnienie'),(345,1,'pl','Http','KontoUzytkownika',12,'wykonajEmailAktywacyjny'),(346,1,'pl','Http','Raporty',129,'wykonajStatusFaktura'),(347,1,'pl','Http','Raporty',129,'wykonajStatusRaty'),(348,1,'pl','Http','Raporty',129,'wykonajStatusKlienta'),(349,1,'pl','Http','Raporty',129,'wykonajPodgladDokumentu'),(350,1,'pl','Admin','Dokumenty',96,'wykonajDodajDokument'),(351,1,'pl','Admin','Dokumenty',96,'wykonajUsunDokument'),(352,1,'pl','Admin','Uzupelnienia',148,'wykonajIndex'),(353,1,'pl','Admin','Uzupelnienia',148,'wykonajDodajUzupelnienia'),(354,1,'pl','Admin','Uzupelnienia',148,'wykonajZabierzUzupelnienia'),(355,1,'pl','Admin','Uzupelnienia',148,'wykonajEdytuj'),(356,1,'pl','Admin','Uzupelnienia',148,'wykonajListaGratisoweUzupelnienia'),(357,1,'pl','Http','Uzupelnienia',148,'wykonajIndex'),(358,1,'pl','Http','Uzupelnienia',148,'wykonajKupUzupelnienia'),(364,1,'pl','Http','KontoUzytkownika',12,'raportyBok'),(367,1,'pl','Http','KontoSerwisowe',127,'wykonajListaOgloszenWizytowki'),(368,1,'pl','Http','KontoSerwisowe',127,'wykonajZmienKategorie'),(369,1,'pl','Http','KontoSerwisowe',127,'ustawienieStarejKategoriiSzczegolowej'),(370,1,'pl','Http','KontoSerwisowe',127,'ustawienieNowejKategoriiSzczegolowej'),(371,1,'pl','Http','Dokumenty',96,'wykonajAnuluj'),(372,1,'pl','Admin','Platnosci',124,'wykonajCzysc'),(373,1,'pl','Admin','RaportyBok',149,'wykonajIndex'),(374,1,'pl','Http','RaportyBok',149,'wykonajIndex'),(375,1,'pl','Http','RaportyBok',149,'wykonajRaportWklepywaczy'),(376,1,'pl','Http','RaportyBok',149,'wykonajRaportBrakowWizytowek'),(377,1,'pl','Http','KontoUzytkownika',12,'kategorieZarzadzanie'),(386,1,'pl','Http','KontoSerwisowe',127,'podswietlanieFirmyZPolaczonymiOpisami'),(387,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajIndex'),(388,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajDrzewoKategorii'),(389,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajDodaj'),(390,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajEdytuj'),(391,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajUsun'),(392,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajSortowanie'),(393,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajCzysc'),(394,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajCzyscWszystko'),(395,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajPromowane'),(396,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajEdytujPromowane'),(397,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajZatwierdzPromowane'),(398,1,'pl','Admin','KategorieOgloszenZarzadzanie',150,'wykonajUsunPromowane'),(399,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajIndex'),(400,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajListaProduktow'),(401,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajListaUslug'),(402,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajListaOgloszen'),(403,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajListaFirm'),(404,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajPrzypiszProdukty'),(405,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajPrzypiszUslugi'),(406,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajZmienKategorie'),(407,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajZmienBranze'),(408,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajUsunPowiazanieKategorii'),(409,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajUsunPowiazanieOgloszenia'),(410,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajPokazProdukty'),(411,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'wykonajInfo'),(412,1,'pl','Http','KategorieOgloszenZarzadzanie',150,'zarzadzanieKategoriami'),(414,1,'pl','Admin','Produkty',151,'wykonajIndex'),(415,1,'pl','Admin','Produkty',151,'wykonajEdytuj'),(416,1,'pl','Admin','Produkty',151,'wykonajDodaj'),(417,1,'pl','Admin','Produkty',151,'wykonajUsun'),(418,1,'pl','Admin','Produkty',151,'wykonajHistoria'),(419,1,'pl','Http','Produkty',151,'wykonajIndex'),(420,1,'pl','Admin','Wiadomosci',15,'wiadomosciWszystkich'),(438,1,'pl','Admin','StronaOpisowa',158,'wykonajIndex'),(439,1,'pl','Admin','StronaOpisowa',160,'wykonajIndex'),(440,1,'pl','Admin','StronaOpisowa',164,'wykonajIndex'),(441,1,'pl','Admin','StronaOpisowa',166,'wykonajIndex'),(442,1,'pl','Admin','StronaOpisowa',167,'wykonajIndex'),(443,1,'pl','Http','KontoUzytkownika',12,'rejestracja'),(444,1,'pl','Http','KontoUzytkownika',12,'wykonajOdnowienie'),(445,1,'pl','Http','KontoUzytkownika',12,'wykonajOdrzucenie'),(448,1,'pl','Admin','Wiadomosci',15,'wykonajWiadomosciKlientow'),(449,1,'pl','Admin','Wiadomosci',15,'wykonajUstawWiadomosciKlientow'),(450,1,'pl','Http','KontoSerwisowe',127,'wykonajListaPowiadomien'),(451,1,'pl','Http','KontoSerwisowe',127,'wykonajAktualizujPowiadomienie'),(452,1,'pl','Http','KontoSerwisowe',127,'listaPowiadomienWyswietlWszystkie'),(453,1,'pl','Admin','RejestracjaPrzedstawiciel',155,'wykonajIndex'),(454,1,'pl','Admin','RejestracjaPrzedstawiciel',155,'wykonajEdycjaRegulamin'),(455,1,'pl','Admin','RejestracjaPrzedstawiciel',155,'wykonajEdycjaPolityka'),(456,1,'pl','Admin','RejestracjaPrzedstawiciel',155,'wykonajEdycjaEmailAktywacja'),(457,1,'pl','Http','RejestracjaPrzedstawiciel',155,'wykonajIndex'),(458,1,'pl','Admin','WizytowkiZarzadzanieNowa',156,'wykonajIndex'),(459,1,'pl','Admin','WizytowkiZarzadzanieNowa',156,'wykonajEdytuj'),(460,1,'pl','Admin','WizytowkiZarzadzanieNowa',156,'wykonajDodaj'),(461,1,'pl','Admin','WizytowkiZarzadzanieNowa',156,'wykonajUsun'),(462,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajIndex'),(463,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajUstawienia'),(464,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajEdycja'),(465,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajWyglad'),(466,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajStronaGlowna'),(467,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajKontakt'),(468,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajStronyDodatkowe'),(469,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajDodajStrone'),(470,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajEdytujStrone'),(471,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajUsunStrone'),(472,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajAktywuj'),(473,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajDokumenty'),(474,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajDodajDokument'),(475,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajEdytujDokument'),(476,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajUsunDokument'),(477,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajDodajLokalizacje'),(478,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajEdytujLokalizacje'),(479,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajEdytujSeo'),(480,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajUsunLokalizacje'),(481,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajUsunZdjecie'),(482,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'edycjaOpisuKrotkiego'),(483,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'edycjaOpisuPelnego'),(484,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'edycjaNowegoOpisuPelnego'),(485,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'edycjaPrzyciskiKopiowaniaOpisu'),(486,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajZapiszZdjecie'),(487,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajUsunZdjecia'),(488,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'edycjaWszystkichDanychBiznesowych'),(489,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajIndex'),(490,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajPromowane'),(491,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajEdytujPromowane'),(492,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajZatwierdzPromowane'),(493,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajUsunPromowane'),(494,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajDrzewoKategorii'),(495,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajDodaj'),(496,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajEdytuj'),(497,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajUsun'),(498,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajUsunPowiazanie'),(499,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajSortowanie'),(500,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajCzysc'),(501,1,'pl','Admin','OfertyZarzadzanie',168,'wykonajCzyscWszystko'),(502,1,'pl','Http','OfertyZarzadzanie',168,'wykonajIndex'),(503,1,'pl','Http','OfertyZarzadzanie',168,'wykonajLista'),(504,1,'pl','Http','OfertyZarzadzanie',168,'wykonajDodajProdukt'),(505,1,'pl','Http','OfertyZarzadzanie',168,'wykonajDodajUsluge'),(506,1,'pl','Http','OfertyZarzadzanie',168,'wykonajKopiuj'),(507,1,'pl','Http','OfertyZarzadzanie',168,'wykonajEdytuj'),(508,1,'pl','Http','OfertyZarzadzanie',168,'wykonajUsun'),(509,1,'pl','Http','OfertyZarzadzanie',168,'wykonajNiePublikuj'),(510,1,'pl','Http','OfertyZarzadzanie',168,'wykonajPromowane'),(511,1,'pl','Http','OfertyZarzadzanie',168,'wykonajUsunZdjecie'),(512,1,'pl','Http','OfertyZarzadzanie',168,'niePobierajUzupelnienia'),(513,1,'pl','Http','OfertyZarzadzanie',168,'wykonajSprawdzDuplikacje'),(514,1,'pl','Http','OfertyZarzadzanie',168,'wykonajGrupowoPublikuj'),(515,1,'pl','Http','OfertyZarzadzanie',168,'wykonajGrupowoNiePublikuj'),(516,1,'pl','Http','OfertyZarzadzanie',168,'wykonajGrupowoUsun'),(517,1,'pl','Http','OfertyZarzadzanie',168,'wykonajZapiszZdjecie'),(518,1,'pl','Http','OfertyZarzadzanie',168,'wykonajUsunZdjecia'),(519,1,'pl','Admin','WizytowkiOdnowienia',217,'wykonajIndex'),(520,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajIndex'),(521,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajStronaStartowa'),(522,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajWizytowkaInfo'),(523,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajWizytowkaInfoNip'),(524,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajProduktyInfo'),(525,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajOdnowienie'),(526,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajOdrzucenie'),(527,1,'pl','Http','WizytowkiOdnowienia',217,'wykonajStronaStartowaOdrzucenie'),(528,1,'pl','Admin','StronaOpisowa',169,'wykonajIndex'),(529,1,'pl','Http','StronaOpisowa',169,'wykonajIndex'),(530,1,'pl','Admin','StronaOpisowa',170,'wykonajIndex'),(531,1,'pl','Http','StronaOpisowa',170,'wykonajIndex'),(532,1,'pl','Admin','StronaOpisowa',171,'wykonajIndex'),(533,1,'pl','Http','StronaOpisowa',171,'wykonajIndex'),(534,1,'pl','Admin','StronaOpisowa',172,'wykonajIndex'),(535,1,'pl','Http','StronaOpisowa',172,'wykonajIndex'),(536,1,'pl','Admin','StronaOpisowa',173,'wykonajIndex'),(537,1,'pl','Http','StronaOpisowa',173,'wykonajIndex'),(538,1,'pl','Admin','StronaOpisowa',174,'wykonajIndex'),(539,1,'pl','Http','StronaOpisowa',174,'wykonajIndex'),(540,1,'pl','Admin','StronaOpisowa',175,'wykonajIndex'),(541,1,'pl','Http','StronaOpisowa',175,'wykonajIndex'),(542,1,'pl','Admin','StronaOpisowa',176,'wykonajIndex'),(543,1,'pl','Http','StronaOpisowa',176,'wykonajIndex'),(544,1,'pl','Admin','StronaOpisowa',177,'wykonajIndex'),(545,1,'pl','Http','StronaOpisowa',177,'wykonajIndex'),(546,1,'pl','Admin','StronaOpisowa',178,'wykonajIndex'),(547,1,'pl','Http','StronaOpisowa',178,'wykonajIndex'),(548,1,'pl','Admin','StronaOpisowa',179,'wykonajIndex'),(549,1,'pl','Http','StronaOpisowa',179,'wykonajIndex'),(550,1,'pl','Admin','StronaOpisowa',180,'wykonajIndex'),(551,1,'pl','Http','StronaOpisowa',180,'wykonajIndex'),(552,1,'pl','Admin','StronaOpisowa',181,'wykonajIndex'),(553,1,'pl','Http','StronaOpisowa',181,'wykonajIndex'),(554,1,'pl','Admin','StronaOpisowa',182,'wykonajIndex'),(555,1,'pl','Http','StronaOpisowa',182,'wykonajIndex'),(556,1,'pl','Admin','StronaOpisowa',183,'wykonajIndex'),(557,1,'pl','Http','StronaOpisowa',183,'wykonajIndex'),(558,1,'pl','Admin','StronaOpisowa',184,'wykonajIndex'),(559,1,'pl','Http','StronaOpisowa',184,'wykonajIndex'),(560,1,'pl','Admin','StronaOpisowa',185,'wykonajIndex'),(561,1,'pl','Http','StronaOpisowa',185,'wykonajIndex'),(562,1,'pl','Admin','StronaOpisowa',186,'wykonajIndex'),(563,1,'pl','Http','StronaOpisowa',186,'wykonajIndex'),(564,1,'pl','Admin','StronaOpisowa',187,'wykonajIndex'),(565,1,'pl','Http','StronaOpisowa',187,'wykonajIndex'),(567,1,'pl','Admin','StronaOpisowa',209,'wykonajIndex'),(568,1,'pl','Http','Dokumenty',96,'wykonajOplacone'),(569,1,'pl','Http','Dokumenty',96,'wykonajNieoplacone'),(570,1,'pl','Http','Produkty',151,'wykonajTabelaPorownania'),(571,1,'pl','Admin','WiadomosciWizytowki',207,'wykonajIndex'),(572,1,'pl','Admin','StronaOpisowa',206,'wykonajIndex'),(698,1,'pl','Http','KontoUzytkownika',12,'rejestracjaSuperads'),(699,1,'pl','Admin','RejestracjaSuperads',218,'wykonajIndex'),(700,1,'pl','Admin','RejestracjaSuperads',218,'wykonajEdycjaRegulamin'),(701,1,'pl','Admin','RejestracjaSuperads',218,'wykonajEdycjaPolityka'),(702,1,'pl','Admin','RejestracjaSuperads',218,'wykonajPodgladFaktury'),(703,1,'pl','Admin','RejestracjaSuperads',218,'wykonajPodglad'),(704,1,'pl','Http','RejestracjaSuperads',218,'wykonajIndex'),(706,1,'pl','Admin','Filtr18',219,'wykonajIndex'),(707,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajWirtualnyTelefon'),(708,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajWirtualnyTelefonEdytuj'),(709,1,'pl','Http','OfertyZarzadzanie',168,'dodawanieLinkowDoOgloszenia'),(710,1,'pl','Admin','Produkty',151,'wykonajEdytujUpgrady'),(711,1,'pl','Admin','Produkty',151,'wykonajDodajUpgrade'),(712,1,'pl','Admin','Produkty',151,'wykonajEdytujUpgrade'),(715,1,'pl','Http','KontoUzytkownika',12,'rejestracjaSuperwebsite'),(716,1,'pl','Http','KontoUzytkownika',12,'serwisoweSuperwebsite'),(717,1,'pl','Http','OfertyZarzadzanie',168,'wykonajSortujProdukty'),(718,1,'pl','Http','OfertyZarzadzanie',168,'wykonajSortujUslugi'),(719,1,'pl','Http','OfertyZarzadzanie',168,'wykonajZapiszKolejnosc'),(720,1,'pl','Admin','RejestracjaSuperwebsite',220,'wykonajIndex'),(721,1,'pl','Admin','RejestracjaSuperwebsite',220,'wykonajPodgladFaktury'),(722,1,'pl','Admin','RejestracjaSuperwebsite',220,'wykonajPodglad'),(723,1,'pl','Http','RejestracjaSuperwebsite',220,'wykonajIndex'),(724,1,'pl','Http','RejestracjaSuperwebsite',220,'wykonajKontoSerwisowe'),(725,1,'pl','Http','RejestracjaSuperwebsite',220,'wykonajEdytuj'),(726,1,'pl','Http','RejestracjaSuperwebsite',220,'przypiszOpiekuna'),(727,1,'pl','Http','KontoUzytkownika',12,'kontoSerwisowePh'),(728,1,'pl','Http','KontoUzytkownika',12,'urlopy'),(729,1,'pl','Http','KontoUzytkownika',12,'weryfikacjaMaterialow'),(730,1,'pl','Http','KontoUzytkownika',12,'kontoKorektora'),(731,1,'pl','Http','KontoSerwisowe',127,'dodawanieRaportuGa'),(732,1,'pl','Http','KontoSerwisowe',127,'wykonajPobierzRaportGa'),(733,1,'pl','Http','KontoSerwisowe',127,'wykonajUsunRaportGa'),(734,1,'pl','Http','KontoSerwisowe',127,'wykonajObciazeniePracownikow'),(735,1,'pl','Admin','WizytowkiMaterialy',221,'wykonajIndex'),(736,1,'pl','Admin','WizytowkiMaterialy',221,'wykonajUsun'),(737,1,'pl','Http','WizytowkiMaterialy',221,'wykonajIndex'),(738,1,'pl','Http','WizytowkiMaterialy',221,'wykonajListaWizytowek'),(739,1,'pl','Http','WizytowkiMaterialy',221,'listaWizytowekWidokPelny'),(740,1,'pl','Http','WizytowkiMaterialy',221,'wykonajListaMaterialow'),(741,1,'pl','Http','WizytowkiMaterialy',221,'wykonajDodajMaterialy'),(742,1,'pl','Http','WizytowkiMaterialy',221,'wykonajEdytujMaterialy'),(743,1,'pl','Http','WizytowkiMaterialy',221,'wykonajZapiszPlik'),(744,1,'pl','Http','WizytowkiMaterialy',221,'wykonajUsunPliki'),(745,1,'pl','Http','WizytowkiMaterialy',221,'wykonajUsun'),(746,1,'pl','Http','WizytowkiMaterialy',221,'dodawanieMaterialowDoKazdejWizytowki'),(747,1,'pl','Http','WizytowkiMaterialy',221,'wykonajPobierzMaterialy'),(748,1,'pl','Http','WizytowkiMaterialy',221,'przechwycenieKonta'),(749,1,'pl','Http','WizytowkiMaterialy',221,'wykonajListaDoWeryfikacji'),(750,1,'pl','Http','WizytowkiMaterialy',221,'wykonajWeryfikuj'),(751,1,'pl','Http','WizytowkiMaterialy',221,'wykonajFormularzWeryfikujMaterialy'),(752,1,'pl','Http','WizytowkiMaterialy',221,'wykonajPobierzRaportGa'),(753,1,'pl','Http','WizytowkiMaterialy',221,'blokadaZapisuMaterialow'),(755,1,'pl','Admin','PracownicyUrlopy',222,'wykonajIndex'),(756,1,'pl','Http','PracownicyUrlopy',222,'wykonajIndex'),(757,1,'pl','Http','PracownicyUrlopy',222,'wykonajListaUrlopow'),(758,1,'pl','Http','PracownicyUrlopy',222,'wykonajDodajUrlop'),(759,1,'pl','Http','PracownicyUrlopy',222,'wykonajEdytujUrlop'),(760,1,'pl','Http','PracownicyUrlopy',222,'wykonajUsunUrlop'),(761,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajZatwierdzKorekte'),(762,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'wykonajZakonczUzupelnianie'),(763,1,'pl','Http','OfertyZarzadzanie',168,'publikuj'),(764,1,'pl','Http','OfertyZarzadzanie',168,'zatwierdzKorekte'),(765,1,'pl','Admin','KontoKorektora',223,'wykonajIndex'),(766,1,'pl','Http','KontoKorektora',223,'wykonajIndex'),(767,1,'pl','Http','KontoKorektora',223,'wykonajListaOgloszen'),(768,1,'pl','Http','KontoKorektora',223,'wykonajListaOgloszenWizytowki'),(769,1,'pl','Http','KontoKorektora',223,'wykonajListaOgloszenLuznych'),(770,1,'pl','Http','KontoKorektora',223,'wykonajPrzechwyc'),(771,1,'pl','Http','KontoUzytkownika',12,'raportyEdytowalne'),(772,1,'pl','Http','WizytowkiZarzadzanieNowa',156,'edytujMiniaturyZdjec'),(773,1,'pl','Http','OfertyZarzadzanie',168,'edytujMiniaturyZdjec'),(774,1,'pl','Admin','RaportyEdytowalne',224,'wykonajIndex'),(775,1,'pl','Admin','RaportyEdytowalne',224,'wykonajEdytuj'),(776,1,'pl','Admin','RaportyEdytowalne',224,'wykonajDodaj'),(777,1,'pl','Admin','RaportyEdytowalne',224,'wykonajUsun'),(778,1,'pl','Admin','RaportyEdytowalne',224,'wykonajKasujCache'),(779,1,'pl','Http','RaportyEdytowalne',224,'wykonajIndex'),(780,1,'pl','Http','RaportyEdytowalne',224,'wykonajListaRaportow'),(781,1,'pl','Http','RaportyEdytowalne',224,'wykonajPodglad'),(782,1,'pl','Http','RaportyEdytowalne',224,'wykonajDoCsv'),(783,1,'pl','Http','RaportyEdytowalne',224,'wykonajWykres'),(784,1,'pl','Http','RaportyEdytowalne',224,'wszystkieRaporty'),(785,1,'pl','Admin','CropperZdjec',225,'wykonajIndex'),(786,1,'pl','Http','CropperZdjec',225,'wykonajIndex'),(787,1,'pl','Http','CropperZdjec',225,'wykonajFormularz'),(788,1,'pl','Http','CropperZdjec',225,'wykonajPrzytnij'),(789,1,'pl','Http','KontoSerwisowe',127,'modyfikacjaWszystkichWizytowek'),(790,1,'pl','Http','KontoSerwisowe',127,'wykonajListaFirmGa'),(791,1,'pl','Http','KontoSerwisowe',127,'raportyGaWszystkichWizytowek'),(792,1,'pl','Http','OfertyZarzadzanie',168,'pobierzUzupelnienie'),(793,1,'pl','Http','WizytowkiMaterialy',221,'formularzDodatkoweDane'),(794,1,'pl','Admin','FirmyPozyskane',226,'wykonajIndex'),(795,1,'pl','Http','FirmyPozyskane',226,'wykonajIndex'),(796,1,'pl','Http','KontoUzytkownika',12,'firmyPozyskane'),(797,1,'pl','Http','RaportyEdytowalne',224,'wykonajFiltryPoczatkowe'),(798,1,'pl','Http','FirmyPozyskane',226,'wykonajLista'),(799,1,'pl','Http','FirmyPozyskane',226,'wykonajPodglad'),(800,1,'pl','Http','FirmyPozyskane',226,'listaWszyscyHandlowcy'),(801,1,'pl','Http','FirmyPozyskane',226,'wykonajOdrzucenie'),(802,1,'pl','Admin','FirmyPozyskane',226,'wykonajListaPh'),(803,1,'pl','Admin','FirmyPozyskane',226,'wykonajEdytuj'),(804,1,'pl','Http','RejestracjaSuperwebsite',220,'rejestracjaDowolnejFirmyPozyskanej'),(805,1,'pl','Http','FirmyPozyskane',226,'wykonajUstawPonownyKontakt'),(806,1,'pl','Http','RejestracjaPrzedstawiciel',155,'rejestracjaDowolnejFirmyPozyskanej'),(807,1,'pl','Admin','Dokumenty',96,'wykonajDodajDokumentNiestandardowy'),(808,1,'pl','Admin','KontoUzytkownika',10,'wykonajIndex'),(809,1,'pl','Http','KontoUzytkownika',10,'wykonajIndex'),(810,1,'pl','Http','KontoUzytkownika',10,'wykonajGlowna'),(811,1,'pl','Http','KontoUzytkownika',10,'wykonajZaloguj'),(812,1,'pl','Http','KontoUzytkownika',10,'wykonajWyloguj'),(813,1,'pl','Http','KontoUzytkownika',10,'wykonajPrzypomnij'),(814,1,'pl','Http','KontoUzytkownika',10,'wykonajZmienHaslo'),(815,1,'pl','Http','KontoUzytkownika',10,'wykonajEdytuj'),(816,1,'pl','Http','KontoUzytkownika',10,'wykonajUsun'),(817,1,'pl','Http','KontoUzytkownika',10,'wykonajEmailAktywacyjny'),(818,1,'pl','Http','KontoUzytkownika',10,'kontoSerwisowe'),(819,1,'pl','Http','KontoUzytkownika',10,'kontoSerwisowePh'),(820,1,'pl','Http','KontoUzytkownika',10,'urlopy'),(821,1,'pl','Http','KontoUzytkownika',10,'raporty'),(822,1,'pl','Http','KontoUzytkownika',10,'raportyBok'),(823,1,'pl','Http','KontoUzytkownika',10,'raportyEdytowalne'),(824,1,'pl','Http','KontoUzytkownika',10,'kategorieZarzadzanie'),(825,1,'pl','Http','KontoUzytkownika',10,'rejestracja'),(826,1,'pl','Http','KontoUzytkownika',10,'wykonajOdnowienie'),(827,1,'pl','Http','KontoUzytkownika',10,'wykonajOdrzucenie'),(828,1,'pl','Http','KontoUzytkownika',10,'rejestracjaSuperads'),(829,1,'pl','Http','KontoUzytkownika',10,'rejestracjaSuperwebsite'),(830,1,'pl','Http','KontoUzytkownika',10,'serwisoweSuperwebsite'),(831,1,'pl','Http','KontoUzytkownika',10,'weryfikacjaMaterialow'),(832,1,'pl','Http','KontoUzytkownika',10,'kontoKorektora'),(833,1,'pl','Http','KontoUzytkownika',10,'firmyPozyskane');

INSERT INTO "cms_uprawnienia_administracyjne" ("id", "id_projektu", "kod_jezyka", "kod_modulu", "akcja") VALUES (1,1,'pl','KonfiguracjaSystemu','wykonajIndex'),(2,1,'pl','KonfiguracjaSystemu','wykonajSystem'),(3,1,'pl','KonfiguracjaSystemu','wykonajAdministracyjne'),(4,1,'pl','KonfiguracjaSystemu','wykonajZwykle'),(5,1,'pl','KonfiguracjaSystemu','wykonajEdytujAdministracyjny'),(6,1,'pl','KonfiguracjaSystemu','wykonajEdytujZwykly'),(7,1,'pl','KonfiguracjaSystemu','wykonajEdytujKategorie'),(8,1,'pl','KonfiguracjaSystemu','wykonajEdytujBlok'),(9,1,'pl','KonfiguracjaSystemu','wykonajCzyscSystem'),(10,1,'pl','KonfiguracjaSystemu','wykonajCzyscAdministracyjny'),(11,1,'pl','KonfiguracjaSystemu','wykonajCzyscZwykly'),(12,1,'pl','KonfiguracjaSystemu','wykonajCzyscKategorie'),(13,1,'pl','KonfiguracjaSystemu','wykonajCzyscBlok'),(14,1,'pl','UstawieniaJezykowe','wykonajIndex'),(15,1,'pl','UstawieniaJezykowe','wykonajBiblioteki'),(16,1,'pl','UstawieniaJezykowe','wykonajAdministracyjne'),(17,1,'pl','UstawieniaJezykowe','wykonajZwykle'),(18,1,'pl','UstawieniaJezykowe','wykonajEdytujAdministracyjny'),(19,1,'pl','UstawieniaJezykowe','wykonajEdytujZwykly'),(20,1,'pl','UstawieniaJezykowe','wykonajEdytujKategorie'),(21,1,'pl','UstawieniaJezykowe','wykonajEdytujBlok'),(22,1,'pl','UstawieniaJezykowe','wykonajCzyscBiblioteki'),(23,1,'pl','UstawieniaJezykowe','wykonajCzyscAdministracyjny'),(24,1,'pl','UstawieniaJezykowe','wykonajCzyscZwykly'),(25,1,'pl','UstawieniaJezykowe','wykonajCzyscKategorie'),(26,1,'pl','UstawieniaJezykowe','wykonajCzyscBlok'),(27,1,'pl','WidokiZarzadzanie','wykonajIndex'),(28,1,'pl','WidokiZarzadzanie','wykonajDodaj'),(29,1,'pl','WidokiZarzadzanie','wykonajEdytuj'),(30,1,'pl','WidokiZarzadzanie','wykonajUsun'),(31,1,'pl','WidokiZarzadzanie','wykonajBloki'),(32,1,'pl','WidokiZarzadzanie','wykonajDodajBlok'),(33,1,'pl','WidokiZarzadzanie','wykonajEdytujBlok'),(34,1,'pl','WidokiZarzadzanie','wykonajUsunBlok'),(35,1,'pl','KategorieZarzadzanie','wykonajIndex'),(36,1,'pl','KategorieZarzadzanie','wykonajDodaj'),(37,1,'pl','KategorieZarzadzanie','wykonajEdytuj'),(38,1,'pl','KategorieZarzadzanie','wykonajUsun'),(39,1,'pl','KategorieZarzadzanie','wykonajSortowanie'),(40,1,'pl','KategorieZarzadzanie','wykonajCzysc'),(41,1,'pl','KategorieZarzadzanie','wykonajPrzebudowa'),(42,1,'pl','UzytkownicyZarzadzanie','wykonajIndex'),(43,1,'pl','UzytkownicyZarzadzanie','wykonajDodaj'),(44,1,'pl','UzytkownicyZarzadzanie','wykonajEdytuj'),(45,1,'pl','UzytkownicyZarzadzanie','wykonajUsun'),(46,1,'pl','UprawnieniaZarzadzanie','wykonajIndex'),(47,1,'pl','UprawnieniaZarzadzanie','wykonajDodaj'),(48,1,'pl','UprawnieniaZarzadzanie','wykonajEdytuj'),(49,1,'pl','UprawnieniaZarzadzanie','wykonajPodglad'),(50,1,'pl','UprawnieniaZarzadzanie','wykonajUprawnieniaTresci'),(51,1,'pl','UprawnieniaZarzadzanie','wykonajUprawnieniaAdministracyjne'),(52,1,'pl','UprawnieniaZarzadzanie','wykonajUsun'),(53,1,'pl','LogowanieOperacji','wykonajIndex'),(54,1,'pl','LogowanieOperacji','wykonajPodglad'),(55,1,'pl','LogowanieOperacji','wykonajUstawienia'),(56,1,'pl','KontoAdministracyjne','wykonajIndex'),(57,1,'pl','KontoAdministracyjne','wykonajZaloguj'),(58,1,'pl','KontoAdministracyjne','wykonajWyloguj'),(59,1,'pl','KontoAdministracyjne','wykonajPrzypomnij'),(60,1,'pl','KontoAdministracyjne','wykonajZmienHaslo'),(61,1,'pl','KontoAdministracyjne','wykonajZmienEmail'),(62,1,'pl','KontoAdministracyjne','wykonajEdytuj'),(63,1,'pl','MenuAdministracyjne','wykonajIndex'),(64,1,'pl','SciezkaAdministracyjna','wykonajIndex'),(65,1,'pl','KategorieDrzewo','wykonajIndex'),(66,1,'pl','KonfiguracjaSystemu','wykonajZmienneGlobalne'),(67,1,'pl','WidokiZarzadzanie','wykonajAktualizuj'),(68,1,'pl','ZadaniaCykliczne','wykonajIndex'),(69,1,'pl','ZadaniaCykliczne','wykonajDodaj'),(70,1,'pl','ZadaniaCykliczne','wykonajEdytuj'),(71,1,'pl','ZadaniaCykliczne','wykonajUsun'),(72,1,'pl','PlikiPrywatne','wykonajIndex'),(73,1,'pl','PlikiPrywatne','wykonajNowy'),(74,1,'pl','PlikiPrywatne','wykonajUpload'),(75,1,'pl','PlikiPrywatne','wykonajUsun'),(76,1,'pl','PlikiPrywatne','wykonajZmien'),(77,1,'pl','PlikiPrywatne','wykonajPrzenies'),(78,1,'pl','PlikiPrywatne','wykonajUprawnienia'),(79,1,'pl','PlikiPubliczne','wykonajIndex'),(80,1,'pl','PlikiPubliczne','wykonajNowy'),(81,1,'pl','PlikiPubliczne','wykonajUpload'),(82,1,'pl','PlikiPubliczne','wykonajUsun'),(83,1,'pl','PlikiPubliczne','wykonajZmien'),(84,1,'pl','PlikiPubliczne','wykonajPrzenies'),(85,1,'pl','EdytorGraficzny','wykonajIndex'),(86,1,'pl','EdytorGraficzny','wykonajEdytor'),(87,1,'pl','UzytkownicyZarzadzanie','wykonajPrzechwyc'),(88,1,'pl','KonfiguracjaSystemu','wykonajPobierzKonfiguracje'),(89,1,'pl','KonfiguracjaSystemu','wykonajWczytajKonfiguracje'),(90,1,'pl','LogowanieOperacji','wykonajDodaj'),(91,1,'pl','LogowanieOperacji','wykonajEdytuj'),(92,1,'pl','LogowanieOperacji','wykonajUsun'),(93,1,'pl','UstawieniaJezykowe','wykonajSzukajFrazy'),(94,1,'pl','UzytkownicyZarzadzanie','wykonajEmailAktywacyjny'),(95,1,'pl','KonfiguracjaSystemu','opcjeSystemowe'),(96,1,'pl','UstawieniaJezykowe','opcjeSystemowe'),(97,1,'pl','UzytkownicyZarzadzanie','edycjaDanychKontaktowych'),(98,1,'pl','UzytkownicyZarzadzanie','edycjaDanychFirmowych'),(99,1,'pl','UzytkownicyZarzadzanie','edycjaDanychPoczty'),(100,1,'pl','UzytkownicyZarzadzanie','edycjaRoli'),(101,1,'pl','UzytkownicyZarzadzanie','edycjaDodatkoweAkcje'),(102,1,'pl','LogowanieOperacji','wykonajPobierzRaport'),(103,1,'pl','LogowanieOperacji','wykonajRaport'),(104,1,'pl','Testy','wykonajIndex'),(105,1,'pl','Testy','wykonajPhpinfo'),(106,1,'pl','Testy','wykonajLogi'),(107,1,'pl','Testy','wykonajPorownaj'),(108,1,'pl','Testy','wykonajWyslijEmailTestowy'),(109,1,'pl','Testy','wykonajSprawdzKatalogi'),(110,1,'pl','Testy','wykonajKonfiguracja'),(111,1,'pl','Testy','wykonajSprawdzTlumaczenia'),(112,1,'pl','Testy','wykonajTlumaczenia'),(113,1,'pl','Testy','wykonajSprawdzKonfiguracje'),(114,1,'pl','ZadaniaCykliczne','wykonajRaport'),(115,1,'pl','ZadaniaCykliczne','wykonajSprawdz'),(116,1,'pl','Testy','wykonajCzyscCachePhp'),(117,1,'pl','Testy','wykonajCzyscCacheTpl'),(118,1,'pl','Mailing','wykonajIndex'),(119,1,'pl','Mailing','wykonajDodaj'),(120,1,'pl','Mailing','wykonajEdytuj'),(121,1,'pl','Mailing','wykonajPodglad'),(122,1,'pl','Mailing','wykonajUsun'),(123,1,'pl','Mailing','wykonajPobierzRaport'),(124,1,'pl','KonfiguracjaSystemu','wykonajSzukajFrazy'),(125,1,'pl','KategorieZarzadzanie','wykonajPoprawUrl'),(126,1,'pl','KategorieZarzadzanie','wykonajPrzekierowania'),(127,1,'pl','CacheZarzadzanie','wykonajIndex'),(128,1,'pl','CacheZarzadzanie','wykonajCacheWizytowki'),(129,1,'pl','CacheZarzadzanie','wykonajCacheStrony'),(130,1,'pl','CacheZarzadzanie','wykonajCacheBloki'),(131,1,'pl','CacheZarzadzanie','wykonajCacheBaza'),(132,1,'pl','CacheZarzadzanie','wykonajEdytujCacheBloku'),(133,1,'pl','CacheZarzadzanie','wykonajPodglad'),(134,1,'pl','CacheZarzadzanie','wykonajUsun'),(135,1,'pl','CacheZarzadzanie','wykonajCzyscCacheWizytowki'),(136,1,'pl','CacheZarzadzanie','wykonajCzyscCacheStrony'),(137,1,'pl','CacheZarzadzanie','wykonajCzyscCacheBloki'),(138,1,'pl','CacheZarzadzanie','wykonajCzyscCacheBaza'),(139,1,'pl','CacheZarzadzanie','wykonajCzyscCachePhp'),(140,1,'pl','CacheZarzadzanie','wykonajCzyscCacheTpl'),(141,1,'pl','Testy','wykonajResetujDaneUzytkownikow'),(142,1,'pl','ModulyZarzadzanie','wykonajIndex'),(143,1,'pl','ModulyZarzadzanie','wykonajPodglad'),(144,1,'pl','ProjektyZarzadzanie','wykonajIndex'),(145,1,'pl','ProjektyZarzadzanie','wykonajDodaj'),(146,1,'pl','ProjektyZarzadzanie','wykonajEdytuj'),(147,1,'pl','ProjektyZarzadzanie','wykonajUsun'),(148,1,'pl','ProjektyZarzadzanie','wykonajVhost'),(149,1,'pl','ZadaniaCykliczne','ustawWielokrotne'),(150,1,'pl','Routing','wykonajIndex'),(151,1,'pl','Routing','wykonajDodaj'),(152,1,'pl','Routing','wykonajEdytuj'),(153,1,'pl','Routing','wykonajUsun'),(154,1,'pl','Routing','wykonajSortuj'),(155,1,'pl','Routing','wykonajPobierzAkcjeDlaKategorii'),(156,1,'pl','KategorieZarzadzanie','wykonajCzyscStaryUrl'),(157,1,'pl','Routing','wykonajPrzekierowania'),(158,1,'pl','Routing','wykonajBlokady'),(159,1,'pl','WidokiZarzadzanie','wykonajPobierzKonfiguracje'),(160,1,'pl','WidokiZarzadzanie','wykonajWczytajKonfiguracje'),(161,1,'pl','KategorieZarzadzanie','wykonajPobierzKonfiguracje'),(162,1,'pl','KategorieZarzadzanie','wykonajWczytajKonfiguracje'),(163,1,'pl','UzytkownicyZarzadzanie','wykonajImportujNumeryKont'),(164,1,'pl','EmailZarzadzanie','wykonajIndex'),(165,1,'pl','EmailZarzadzanie','wykonajDodaj'),(166,1,'pl','EmailZarzadzanie','wykonajEdytuj'),(167,1,'pl','EmailZarzadzanie','wykonajUsun'),(168,1,'pl','EmailZarzadzanie','wykonajUsunZalacznik'),(169,1,'pl','EmailZarzadzanie','wykonajSzablony'),(170,1,'pl','EmailZarzadzanie','wykonajDodajSzablon'),(171,1,'pl','EmailZarzadzanie','wykonajEdytujSzablon'),(172,1,'pl','EmailZarzadzanie','wykonajUsunSzablon'),(173,1,'pl','EmailZarzadzanie','wykonajKolejka'),(174,1,'pl','EmailZarzadzanie','wykonajPodglad'),(175,1,'pl','EmailZarzadzanie','wykonajPodgladFormatki'),(176,1,'pl','ZadaniaCykliczne','wykonajUruchom');

INSERT INTO "cms_role_uprawnienia" ("id", "id_projektu", "kod_jezyka", "id_roli", "id_uprawnienia") VALUES (33,1,'pl',1,17),(35,1,'pl',1,18),(36,1,'pl',1,19),(37,1,'pl',1,20),(38,1,'pl',1,21),(39,1,'pl',1,22),(57,1,'pl',1,35),(60,1,'pl',1,37),(61,1,'pl',1,38),(62,1,'pl',1,39),(63,1,'pl',1,40),(64,1,'pl',1,41),(65,1,'pl',1,42),(66,1,'pl',1,43),(67,1,'pl',1,44),(68,1,'pl',1,45),(69,1,'pl',1,46),(90,1,'pl',1,55),(91,1,'pl',1,56),(92,1,'pl',1,57),(93,1,'pl',1,58),(94,1,'pl',1,59),(95,1,'pl',1,60),(96,1,'pl',1,61),(97,1,'pl',1,62),(98,1,'pl',1,63),(99,1,'pl',1,64),(142,1,'pl',1,90),(143,1,'pl',1,91),(144,1,'pl',1,92),(145,1,'pl',1,93),(146,1,'pl',1,94),(147,1,'pl',1,95),(148,1,'pl',1,96),(149,1,'pl',1,97),(150,1,'pl',1,98),(151,1,'pl',1,99),(152,1,'pl',1,100),(153,1,'pl',1,101),(154,1,'pl',1,102),(155,1,'pl',1,103),(156,1,'pl',1,104),(157,1,'pl',1,105),(158,1,'pl',1,106),(159,1,'pl',1,107),(160,1,'pl',1,108),(161,1,'pl',1,109),(162,1,'pl',1,110),(163,1,'pl',1,111),(164,1,'pl',1,112),(165,1,'pl',1,113),(166,1,'pl',1,114),(167,1,'pl',1,115),(168,1,'pl',1,116),(179,1,'pl',1,127),(223,1,'pl',1,128),(225,1,'pl',1,129),(227,1,'pl',1,130),(229,1,'pl',1,131),(231,1,'pl',1,132),(233,1,'pl',1,133),(235,1,'pl',1,134),(237,1,'pl',1,135),(239,1,'pl',1,136),(241,1,'pl',1,137),(243,1,'pl',1,138),(245,1,'pl',1,139),(247,1,'pl',1,140),(249,1,'pl',1,141),(275,1,'pl',1,154),(277,1,'pl',1,155),(279,1,'pl',1,156),(281,1,'pl',1,157),(285,1,'pl',1,159),(287,1,'pl',1,160),(289,1,'pl',1,161),(291,1,'pl',1,162),(293,1,'pl',1,163),(295,1,'pl',1,164),(297,1,'pl',1,165),(299,1,'pl',1,166),(301,1,'pl',1,167),(303,1,'pl',1,168),(305,1,'pl',1,169),(307,1,'pl',1,170),(309,1,'pl',1,171),(311,1,'pl',1,172),(313,1,'pl',1,173),(315,1,'pl',1,174),(319,1,'pl',1,176),(321,1,'pl',1,177),(323,1,'pl',1,178),(325,1,'pl',1,179),(327,1,'pl',1,180),(329,1,'pl',1,181),(333,1,'pl',1,183),(335,1,'pl',1,184),(337,1,'pl',1,185),(339,1,'pl',1,186),(341,1,'pl',1,187),(343,1,'pl',1,188),(345,1,'pl',1,189),(347,1,'pl',1,190),(351,1,'pl',1,192),(353,1,'pl',1,193),(355,1,'pl',1,194),(357,1,'pl',1,195),(361,1,'pl',1,197),(363,1,'pl',1,198),(365,1,'pl',1,199),(367,1,'pl',1,200),(371,1,'pl',1,202),(373,1,'pl',1,203),(375,1,'pl',1,204),(377,1,'pl',1,205),(379,1,'pl',1,206),(381,1,'pl',1,207),(385,1,'pl',1,209),(387,1,'pl',1,210),(389,1,'pl',1,211),(391,1,'pl',1,212),(418,1,'pl',1,217),(419,1,'pl',1,218),(420,1,'pl',1,219),(421,1,'pl',1,220),(422,1,'pl',1,221),(423,1,'pl',1,222),(432,1,'pl',1,224),(456,1,'pl',1,249),(460,1,'pl',1,251),(463,1,'pl',1,253),(471,1,'pl',1,260),(472,1,'pl',1,261),(473,1,'pl',1,262),(478,1,'pl',1,237),(567,1,'pl',1,293),(569,1,'pl',1,291),(570,1,'pl',1,292),(571,1,'pl',1,280),(572,1,'pl',1,281),(573,1,'pl',1,282),(574,1,'pl',1,283),(575,1,'pl',1,284),(576,1,'pl',1,285),(678,1,'pl',4,56),(679,1,'pl',4,57),(680,1,'pl',4,58),(681,1,'pl',4,59),(682,1,'pl',4,60),(683,1,'pl',4,61),(684,1,'pl',4,62),(685,1,'pl',4,63),(686,1,'pl',4,237),(687,1,'pl',4,64),(708,1,'pl',4,104),(709,1,'pl',4,105),(710,1,'pl',4,106),(711,1,'pl',4,107),(712,1,'pl',4,108),(713,1,'pl',4,109),(714,1,'pl',4,110),(715,1,'pl',4,111),(716,1,'pl',4,112),(717,1,'pl',4,113),(718,1,'pl',4,114),(719,1,'pl',4,115),(720,1,'pl',4,116),(721,1,'pl',4,260),(722,1,'pl',4,261),(723,1,'pl',4,262),(726,1,'pl',4,313),(757,1,'pl',1,331),(759,1,'pl',1,313),(760,1,'pl',1,300),(761,1,'pl',1,328),(762,1,'pl',1,332),(763,1,'pl',1,333),(764,1,'pl',1,304),(765,1,'pl',1,305),(766,1,'pl',1,306),(767,1,'pl',1,307),(768,1,'pl',1,334),(769,1,'pl',1,314),(770,1,'pl',1,308),(771,1,'pl',1,315),(772,1,'pl',1,316),(773,1,'pl',1,310),(774,1,'pl',1,335),(775,1,'pl',1,336),(776,1,'pl',1,337),(777,1,'pl',1,317),(778,1,'pl',1,318),(779,1,'pl',1,323),(780,1,'pl',1,324),(781,1,'pl',1,325),(782,1,'pl',1,326),(783,1,'pl',1,327),(784,1,'pl',1,303),(785,1,'pl',1,322),(786,1,'pl',1,301),(787,1,'pl',1,329),(804,1,'pl',4,332),(805,1,'pl',4,333),(806,1,'pl',1,341),(809,1,'pl',1,343),(810,1,'pl',1,344),(812,1,'pl',1,346),(813,1,'pl',1,347),(814,1,'pl',1,348),(815,1,'pl',1,349),(816,1,'pl',1,350),(817,1,'pl',1,351),(818,1,'pl',1,352),(819,1,'pl',1,353),(820,1,'pl',1,354),(821,1,'pl',1,355),(822,1,'pl',1,356),(823,1,'pl',1,357),(824,1,'pl',1,358),(825,1,'pl',4,357),(826,1,'pl',4,358),(844,1,'pl',1,364),(845,1,'pl',1,373),(846,1,'pl',1,374),(847,1,'pl',1,375),(848,1,'pl',1,376),(857,1,'pl',4,293),(858,1,'pl',4,371),(862,1,'pl',1,367),(863,1,'pl',1,368),(864,1,'pl',1,369),(865,1,'pl',1,370),(866,1,'pl',1,371),(898,1,'pl',1,372),(899,1,'pl',1,377),(905,1,'pl',1,386),(911,1,'pl',1,387),(912,1,'pl',1,388),(913,1,'pl',1,389),(914,1,'pl',1,390),(915,1,'pl',1,391),(916,1,'pl',1,392),(917,1,'pl',1,393),(918,1,'pl',1,394),(919,1,'pl',1,395),(920,1,'pl',1,396),(921,1,'pl',1,397),(922,1,'pl',1,398),(923,1,'pl',1,399),(924,1,'pl',1,400),(925,1,'pl',1,401),(926,1,'pl',1,402),(927,1,'pl',1,403),(928,1,'pl',1,404),(929,1,'pl',1,405),(930,1,'pl',1,406),(931,1,'pl',1,407),(932,1,'pl',1,408),(933,1,'pl',1,409),(934,1,'pl',1,410),(935,1,'pl',1,411),(936,1,'pl',1,412),(1007,1,'pl',1,414),(1008,1,'pl',1,415),(1009,1,'pl',1,416),(1010,1,'pl',1,417),(1011,1,'pl',1,418),(1012,1,'pl',1,419),(1015,1,'pl',1,345),(1160,1,'pl',1,443),(1161,1,'pl',1,444),(1162,1,'pl',1,445),(1165,1,'pl',1,450),(1166,1,'pl',1,451),(1167,1,'pl',1,452),(1168,1,'pl',1,457),(1169,1,'pl',1,462),(1170,1,'pl',1,463),(1171,1,'pl',1,464),(1172,1,'pl',1,465),(1173,1,'pl',1,466),(1174,1,'pl',1,467),(1175,1,'pl',1,468),(1176,1,'pl',1,469),(1177,1,'pl',1,470),(1178,1,'pl',1,471),(1179,1,'pl',1,472),(1180,1,'pl',1,473),(1181,1,'pl',1,474),(1182,1,'pl',1,475),(1183,1,'pl',1,476),(1184,1,'pl',1,477),(1185,1,'pl',1,478),(1186,1,'pl',1,479),(1187,1,'pl',1,480),(1188,1,'pl',1,481),(1189,1,'pl',1,482),(1190,1,'pl',1,483),(1191,1,'pl',1,484),(1192,1,'pl',1,485),(1193,1,'pl',1,486),(1194,1,'pl',1,487),(1195,1,'pl',1,488),(1196,1,'pl',1,502),(1197,1,'pl',1,503),(1198,1,'pl',1,504),(1199,1,'pl',1,505),(1200,1,'pl',1,506),(1201,1,'pl',1,507),(1202,1,'pl',1,508),(1203,1,'pl',1,509),(1204,1,'pl',1,510),(1205,1,'pl',1,511),(1206,1,'pl',1,512),(1207,1,'pl',1,513),(1208,1,'pl',1,514),(1209,1,'pl',1,515),(1210,1,'pl',1,516),(1211,1,'pl',1,517),(1212,1,'pl',1,518),(1213,1,'pl',1,520),(1214,1,'pl',1,521),(1215,1,'pl',1,522),(1216,1,'pl',1,523),(1217,1,'pl',1,524),(1218,1,'pl',1,525),(1219,1,'pl',1,526),(1220,1,'pl',1,527),(1221,1,'pl',1,529),(1222,1,'pl',1,531),(1223,1,'pl',1,533),(1224,1,'pl',1,535),(1225,1,'pl',1,537),(1226,1,'pl',1,539),(1227,1,'pl',1,541),(1228,1,'pl',1,543),(1229,1,'pl',1,545),(1230,1,'pl',1,547),(1231,1,'pl',1,549),(1232,1,'pl',1,551),(1233,1,'pl',1,553),(1234,1,'pl',1,555),(1235,1,'pl',1,557),(1236,1,'pl',1,559),(1237,1,'pl',1,561),(1238,1,'pl',1,563),(1239,1,'pl',1,565),(1240,1,'pl',1,568),(1241,1,'pl',1,569),(1242,1,'pl',1,570),(1243,1,'pl',4,462),(1244,1,'pl',4,463),(1245,1,'pl',4,464),(1246,1,'pl',4,465),(1247,1,'pl',4,466),(1248,1,'pl',4,467),(1249,1,'pl',4,468),(1250,1,'pl',4,469),(1251,1,'pl',4,470),(1252,1,'pl',4,471),(1253,1,'pl',4,473),(1254,1,'pl',4,474),(1255,1,'pl',4,475),(1256,1,'pl',4,476),(1257,1,'pl',4,477),(1258,1,'pl',4,478),(1259,1,'pl',4,480),(1260,1,'pl',4,481),(1261,1,'pl',4,484),(1262,1,'pl',4,486),(1263,1,'pl',4,487),(1264,1,'pl',4,502),(1265,1,'pl',4,503),(1266,1,'pl',4,504),(1267,1,'pl',4,505),(1268,1,'pl',4,507),(1269,1,'pl',4,508),(1270,1,'pl',4,511),(1271,1,'pl',4,517),(1272,1,'pl',4,518),(1273,1,'pl',4,529),(1274,1,'pl',4,531),(1275,1,'pl',4,533),(1276,1,'pl',4,535),(1277,1,'pl',4,537),(1278,1,'pl',4,539),(1279,1,'pl',4,541),(1280,1,'pl',4,543),(1281,1,'pl',4,545),(1282,1,'pl',4,547),(1283,1,'pl',4,549),(1284,1,'pl',4,551),(1285,1,'pl',4,553),(1286,1,'pl',4,555),(1287,1,'pl',4,557),(1288,1,'pl',4,559),(1289,1,'pl',4,561),(1290,1,'pl',4,563),(1291,1,'pl',4,565),(1292,1,'pl',4,568),(1293,1,'pl',4,569),(1415,1,'pl',1,438),(1416,1,'pl',1,439),(1417,1,'pl',1,440),(1418,1,'pl',1,441),(1419,1,'pl',1,442),(1420,1,'pl',1,420),(1421,1,'pl',1,448),(1422,1,'pl',1,449),(1423,1,'pl',1,453),(1424,1,'pl',1,454),(1425,1,'pl',1,455),(1426,1,'pl',1,456),(1427,1,'pl',1,458),(1428,1,'pl',1,459),(1429,1,'pl',1,460),(1430,1,'pl',1,461),(1431,1,'pl',1,489),(1432,1,'pl',1,490),(1433,1,'pl',1,491),(1434,1,'pl',1,492),(1435,1,'pl',1,493),(1436,1,'pl',1,494),(1437,1,'pl',1,495),(1438,1,'pl',1,496),(1439,1,'pl',1,497),(1440,1,'pl',1,498),(1441,1,'pl',1,499),(1442,1,'pl',1,500),(1443,1,'pl',1,501),(1444,1,'pl',1,519),(1445,1,'pl',1,528),(1446,1,'pl',1,530),(1447,1,'pl',1,532),(1448,1,'pl',1,534),(1449,1,'pl',1,536),(1450,1,'pl',1,538),(1451,1,'pl',1,540),(1452,1,'pl',1,542),(1453,1,'pl',1,544),(1454,1,'pl',1,546),(1455,1,'pl',1,548),(1456,1,'pl',1,550),(1457,1,'pl',1,552),(1458,1,'pl',1,554),(1459,1,'pl',1,556),(1460,1,'pl',1,558),(1461,1,'pl',1,560),(1462,1,'pl',1,562),(1463,1,'pl',1,564),(1465,1,'pl',1,567),(1466,1,'pl',1,571),(1467,1,'pl',1,572),(1476,1,'pl',1,699),(1477,1,'pl',1,700),(1478,1,'pl',1,701),(1479,1,'pl',1,702),(1480,1,'pl',1,703),(1481,1,'pl',1,704),(1482,1,'pl',1,698),(1487,1,'pl',1,706),(1497,1,'pl',4,707),(1508,1,'pl',1,710),(1509,1,'pl',1,711),(1510,1,'pl',1,712),(1511,1,'pl',1,707),(1512,1,'pl',1,708),(1513,1,'pl',1,709),(1514,1,'pl',1,715),(1515,1,'pl',1,716),(1516,1,'pl',1,717),(1517,1,'pl',1,718),(1518,1,'pl',1,719),(1519,1,'pl',1,720),(1520,1,'pl',1,721),(1521,1,'pl',1,722),(1522,1,'pl',1,723),(1523,1,'pl',1,724),(1524,1,'pl',1,725),(1525,1,'pl',1,726),(1568,1,'pl',4,717),(1569,1,'pl',4,718),(1570,1,'pl',4,719),(1776,1,'pl',1,727),(1777,1,'pl',1,728),(1778,1,'pl',1,729),(1779,1,'pl',1,730),(1780,1,'pl',1,731),(1781,1,'pl',1,732),(1782,1,'pl',1,733),(1783,1,'pl',1,734),(1784,1,'pl',1,735),(1785,1,'pl',1,736),(1786,1,'pl',1,737),(1787,1,'pl',1,738),(1788,1,'pl',1,739),(1789,1,'pl',1,740),(1790,1,'pl',1,741),(1791,1,'pl',1,742),(1792,1,'pl',1,743),(1793,1,'pl',1,744),(1794,1,'pl',1,745),(1795,1,'pl',1,746),(1796,1,'pl',1,747),(1797,1,'pl',1,748),(1798,1,'pl',1,749),(1799,1,'pl',1,750),(1800,1,'pl',1,751),(1801,1,'pl',1,752),(1802,1,'pl',1,753),(1880,1,'pl',1,755),(1881,1,'pl',1,756),(1882,1,'pl',1,757),(1883,1,'pl',1,758),(1884,1,'pl',1,759),(1885,1,'pl',1,760),(1915,1,'pl',1,765),(1916,1,'pl',1,766),(1917,1,'pl',1,767),(1918,1,'pl',1,768),(1919,1,'pl',1,769),(1920,1,'pl',1,770),(2375,1,'pl',1,774),(2376,1,'pl',1,775),(2377,1,'pl',1,776),(2378,1,'pl',1,777),(2379,1,'pl',1,778),(2380,1,'pl',1,779),(2381,1,'pl',1,780),(2382,1,'pl',1,781),(2383,1,'pl',1,782),(2384,1,'pl',1,783),(2385,1,'pl',1,784),(2386,1,'pl',1,771),(2393,1,'pl',1,785),(2394,1,'pl',1,786),(2395,1,'pl',1,787),(2396,1,'pl',1,788),(2400,1,'pl',4,786),(2401,1,'pl',4,787),(2402,1,'pl',4,788),(2405,1,'pl',4,772),(2406,1,'pl',4,773),(2431,1,'pl',1,808),(2432,1,'pl',1,809),(2433,1,'pl',1,810),(2434,1,'pl',1,811),(2435,1,'pl',1,812),(2436,1,'pl',1,813),(2437,1,'pl',1,814),(2438,1,'pl',1,815),(2439,1,'pl',1,816),(2440,1,'pl',1,817),(2441,1,'pl',1,818),(2442,1,'pl',1,819),(2443,1,'pl',1,820),(2444,1,'pl',1,821),(2445,1,'pl',1,822),(2446,1,'pl',1,823),(2447,1,'pl',1,824),(2448,1,'pl',1,825),(2449,1,'pl',1,826),(2450,1,'pl',1,827),(2451,1,'pl',1,828),(2452,1,'pl',1,829),(2453,1,'pl',1,830),(2454,1,'pl',1,831),(2455,1,'pl',1,832),(2456,1,'pl',1,833);

INSERT INTO "cms_role_uprawnienia_administracyjne" ("id", "id_projektu", "kod_jezyka", "id_roli", "id_uprawnienia_administracyjnego") VALUES (1,1,'pl',1,65),(2,1,'pl',1,1),(3,1,'pl',1,2),(4,1,'pl',1,3),(5,1,'pl',1,4),(6,1,'pl',1,5),(7,1,'pl',1,6),(8,1,'pl',1,7),(9,1,'pl',1,8),(10,1,'pl',1,9),(11,1,'pl',1,10),(12,1,'pl',1,11),(13,1,'pl',1,12),(14,1,'pl',1,13),(15,1,'pl',1,56),(16,1,'pl',1,57),(17,1,'pl',1,58),(18,1,'pl',1,59),(19,1,'pl',1,60),(20,1,'pl',1,61),(21,1,'pl',1,62),(22,1,'pl',1,53),(23,1,'pl',1,54),(24,1,'pl',1,55),(25,1,'pl',1,63),(26,1,'pl',1,64),(27,1,'pl',1,14),(28,1,'pl',1,15),(29,1,'pl',1,16),(30,1,'pl',1,17),(31,1,'pl',1,18),(32,1,'pl',1,19),(33,1,'pl',1,20),(34,1,'pl',1,21),(35,1,'pl',1,22),(36,1,'pl',1,23),(37,1,'pl',1,24),(38,1,'pl',1,25),(39,1,'pl',1,26),(40,1,'pl',1,35),(41,1,'pl',1,36),(42,1,'pl',1,37),(43,1,'pl',1,38),(44,1,'pl',1,39),(45,1,'pl',1,40),(46,1,'pl',1,41),(47,1,'pl',1,27),(48,1,'pl',1,28),(49,1,'pl',1,29),(50,1,'pl',1,30),(51,1,'pl',1,31),(52,1,'pl',1,32),(53,1,'pl',1,33),(54,1,'pl',1,34),(55,1,'pl',1,46),(56,1,'pl',1,47),(57,1,'pl',1,48),(58,1,'pl',1,49),(59,1,'pl',1,50),(60,1,'pl',1,51),(61,1,'pl',1,52),(62,1,'pl',1,42),(63,1,'pl',1,43),(64,1,'pl',1,44),(65,1,'pl',1,45),(76,1,'pl',1,66),(77,1,'pl',1,79),(78,1,'pl',1,80),(79,1,'pl',1,81),(80,1,'pl',1,82),(81,1,'pl',1,83),(82,1,'pl',1,84),(83,1,'pl',1,72),(84,1,'pl',1,73),(85,1,'pl',1,74),(86,1,'pl',1,75),(87,1,'pl',1,76),(88,1,'pl',1,77),(89,1,'pl',1,78),(90,1,'pl',1,67),(91,1,'pl',1,94),(92,1,'pl',1,85),(93,1,'pl',1,88),(94,1,'pl',1,89),(95,1,'pl',1,95),(96,1,'pl',1,90),(97,1,'pl',1,91),(98,1,'pl',1,92),(99,1,'pl',1,102),(100,1,'pl',1,103),(101,1,'pl',1,104),(102,1,'pl',1,105),(103,1,'pl',1,106),(104,1,'pl',1,107),(105,1,'pl',1,108),(106,1,'pl',1,109),(107,1,'pl',1,110),(108,1,'pl',1,111),(109,1,'pl',1,112),(110,1,'pl',1,113),(111,1,'pl',1,93),(112,1,'pl',1,96),(113,1,'pl',1,97),(114,1,'pl',1,98),(115,1,'pl',1,99),(116,1,'pl',1,100),(117,1,'pl',1,101),(118,1,'pl',1,87),(119,1,'pl',1,68),(120,1,'pl',1,69),(121,1,'pl',1,70),(122,1,'pl',1,71),(123,1,'pl',1,116),(124,1,'pl',1,117),(125,1,'pl',1,118),(126,1,'pl',1,119),(127,1,'pl',1,120),(128,1,'pl',1,121),(129,1,'pl',1,122),(130,1,'pl',1,123),(131,1,'pl',1,114),(132,1,'pl',1,115),(133,1,'pl',1,86),(134,1,'pl',1,124),(135,1,'pl',1,127),(136,1,'pl',1,128),(137,1,'pl',1,129),(138,1,'pl',1,130),(139,1,'pl',1,131),(140,1,'pl',1,132),(141,1,'pl',1,133),(142,1,'pl',1,134),(143,1,'pl',1,135),(144,1,'pl',1,136),(145,1,'pl',1,137),(146,1,'pl',1,138),(147,1,'pl',1,139),(148,1,'pl',1,140),(149,1,'pl',1,125),(150,1,'pl',1,126),(151,1,'pl',1,142),(152,1,'pl',1,143),(153,1,'pl',1,144),(154,1,'pl',1,145),(155,1,'pl',1,146),(156,1,'pl',1,150),(157,1,'pl',1,151),(158,1,'pl',1,152),(159,1,'pl',1,153),(160,1,'pl',1,154),(161,1,'pl',1,155),(162,1,'pl',1,149),(163,1,'pl',1,157),(164,1,'pl',1,158),(165,1,'pl',1,156),(166,1,'pl',1,163),(309,1,'pl',1,164),(310,1,'pl',1,165),(311,1,'pl',1,166),(312,1,'pl',1,167),(313,1,'pl',1,168),(314,1,'pl',1,169),(315,1,'pl',1,170),(316,1,'pl',1,171),(317,1,'pl',1,172),(318,1,'pl',1,173),(319,1,'pl',1,174),(320,1,'pl',1,175),(321,1,'pl',1,141),(322,1,'pl',1,176);

INSERT INTO "cms_tlumaczenia" ("id", "id_projektu", "kod_jezyka", "kod_modulu", "id_kategorii", "id_bloku", "nazwa", "typ", "wartosc") VALUES (101,1,'pl',NULL,NULL,NULL,'bledy.blad_aplikacji','string','Przepraszamy. Wystąpił bład wewnętrzny aplikacji.'),(103,1,'pl',NULL,NULL,NULL,'pagery.pager_linki_wstecz','string','&laquo;'),(104,1,'pl',NULL,NULL,NULL,'pagery.pager_linki_przod','string','&raquo;'),(105,1,'pl',NULL,NULL,NULL,'pagery.pager_belka_wstecz','string','&laquo;'),(106,1,'pl',NULL,NULL,NULL,'pagery.pager_belka_przod','string','&raquo;'),(107,1,'pl',NULL,NULL,NULL,'walidatory.walidator_liczba_calkowita_nieprawidlowa_liczba','string','Wprowadź liczbę.'),(109,1,'pl',NULL,NULL,NULL,'walidatory.walidator_rozszerzenie_pliku_nieprawidlowe','string','Plik ma niedozwolone rozszerzenie. Więcej informacji znajdziesz w pomocy.'),(110,1,'pl',NULL,NULL,NULL,'walidatory.walidator_dozwolone_wartosci_niedozwolona_wartosc','string','Wartość nie znajduje się na liście akceptowanych.'),(133,1,'pl',NULL,NULL,NULL,'walidatory.walidator_adres_ip_nieprawidlowy_adres','string','Adres IP jest nieprawidłowy.'),(283,1,'pl',NULL,NULL,NULL,'bledy.przerwane_przetwarzanie_strony','string','Wystąpił błąd podczas przetwarzania strony. Spróbuj odświeżyć stronę w przeglądarce lub skontaktuj się z aministratorem.'),(303,1,'pl',NULL,NULL,NULL,'walidatory.walidator_nie_puste_wartosc_pusta','string','Pole nie może być puste.'),(490,1,'pl',NULL,NULL,NULL,'pagery.pager_wybierz_strone','string','');

INSERT INTO "cms_uzytkownicy" ("id", "id_projektu", "login", "haslo", "email", "data_dodania", "data_aktywacji", "token", "czy_admin", "status", "imie", "nazwisko", "rok_urodzenia", "plec", "kontakt_telefon", "kontakt_komorka", "kontakt_fax", "kontakt_www", "kontakt_nazwa", "kontakt_adres", "kontakt_kod_pocztowy", "kontakt_miasto", "firma_nazwa", "firma_nip", "firma_adres", "firma_kod_pocztowy", "firma_miasto", "poczta_host", "poczta_port", "poczta_login", "poczta_haslo", "jezyk", "zgoda_mailing", "zgoda_marketing", "typ_aktywacji", "numer_konta_bankowego", "numer_umowy", "mapa_dlugosc", "mapa_szerokosc") VALUES (1,1,'admin','5fec4ba8376f207d1ff2f0cac0882b01','marcin.mucha@supertraders.pl','2010-02-17 13:54:56',NULL,NULL,1,'aktywny','Marcin','Mucha',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(84,1,'szkolenie','ebabb1e7e998b6e0e700e103420116d2','mateuszsoltysiak@gmail.com','2010-11-02 09:43:31',NULL,NULL,NULL,'aktywny','Mateusz','Sołtysiak',NULL,NULL,'','','','www.supertraders.pl',NULL,NULL,NULL,NULL,'M-Media','6762427970','Kudlińskiego 5 / 2','30-211','Kraków',NULL,NULL,NULL,NULL,'pl',1,1,'klient',NULL,NULL,'',''),(685,1,'liczydlo','9a6bbe2a70b0747ee84239636b2c657a','anna.marszalek-trzcinska@supertraders.pl','2011-07-01 09:47:58','2011-07-02 07:37:26',NULL,0,'zablokowany','Anna','marszalek',NULL,NULL,'505739446',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Biuro Księgowe LICZYDLO','5261603119','Pruszkowska 17/602','02-119','Warszawa',NULL,NULL,NULL,NULL,'pl',1,0,'klient',NULL,NULL,'',''),(778,1,'lukasz.wrobel','58100bbed04cc0e2b93894dc68a0c42b','lukasz.wrobel@m-media.pl','2011-07-20 16:00:51',NULL,NULL,NULL,'aktywny','Łukasz','Wróbel',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(779,1,'lukasz.kozak','358bb78c1597970456a84e9b45c55c2e','lukasz.kozak@m-media.pl','2011-07-20 16:05:16',NULL,NULL,NULL,'aktywny','Łukasz','Kożak',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(780,1,'agnieszka.wrobel','da5b83ff0a19f6de09925a4f87b9b2a1','agnieszka.wrobel@m-media.pl','2011-07-20 16:06:28',NULL,NULL,NULL,'aktywny','Agnieszka','Wróbel (Wrucha)',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(781,1,'joanna.kowalska','57091af1260966a65cf521d4fe1eb63b','joanna.kowalska@m-media.pl','2011-07-20 16:07:26',NULL,NULL,NULL,'aktywny','Joanna','Kowalska',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(821,1,'mateusz.soltysiak','1b72445c0c566c6a1b5008ff9db43e75','mateusz.soltysiak@m-media.pl','2011-07-28 08:29:19',NULL,NULL,NULL,'aktywny','Mateusz','Sołtysiak',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(831,1,'katarzynagora','1984542c6ffb299f880bc162c6905b46','katarzyna.gora@m-media.pl','2011-08-01 06:17:50',NULL,NULL,0,'aktywny','Katarzyna','Góra',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(962,1,'tomasz.radomski','3f6c35c60f1a2a00eea0c8005a3d7013','tomasz.radomski@m-media.pl','2011-09-01 08:01:32',NULL,NULL,NULL,'aktywny','Tomasz','Radomski',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(963,1,'ewa.jedrusyna','56627dac9b9879a1404ac06644e328aa','ewa.jedrusyna@m-media.pl','2011-09-01 08:04:18',NULL,NULL,NULL,'aktywny','Ewa','Jędrusyna',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(964,1,'dorota.babula','fd75c9a7e5496082a63529b311e678ce','dorota.babula@m-media.pl','2011-09-01 08:06:24','2011-09-01 08:46:13',NULL,NULL,'zablokowany','Dorota','Babula',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(965,1,'wioletta.pytel-fadafan','e1317105f72f16db5dcd3e02e2dfb5e9','wioletta.pytel@m-media.pl','2011-09-01 08:14:37','2011-09-01 08:47:46',NULL,NULL,'aktywny','Wioletta','Pytel-Fadafan',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1090,1,'lukasz.galik.bok','3c229a614931d1ed5d4c6cbe9b5c5232','lukas.psk@gmail.com','2011-09-26 14:50:50',NULL,NULL,NULL,'aktywny','Łukasz','Galik',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1091,1,'lukasz.galik.pracownik','3c229a614931d1ed5d4c6cbe9b5c5232','lukas.psk@gmail.com','2011-09-26 14:51:53',NULL,NULL,NULL,'aktywny','Łukasz','Galik',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1103,1,'pawel.kostrzewa','4ffbfa5ade2a01c6d6f633d5a89da25e','pawel.kostrzewa@supertraders.pl','2011-09-28 09:14:47',NULL,NULL,NULL,'zablokowany','Paweł','Kostrzewa',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1136,1,'ms.kierownik','57091af1260966a65cf521d4fe1eb63b','mateusz.soltysiak@m-media.pl','2011-10-03 13:53:05',NULL,NULL,NULL,'aktywny','Mateusz','Sołtysiak',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1137,1,'ms.pracownik','57091af1260966a65cf521d4fe1eb63b','mateusz.soltysiak@m-media.pl','2011-10-03 13:53:41',NULL,NULL,NULL,'aktywny','Mateusz','Sołtysiak',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1138,1,'ms.windykacja','57091af1260966a65cf521d4fe1eb63b','mateusz.soltysiak@supertraders.pl','2011-10-03 13:54:08',NULL,NULL,NULL,'aktywny','Mateusz','Sołtysiak',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1139,1,'kg.kierownik','57091af1260966a65cf521d4fe1eb63b','katarzyna.gora@m-media.pl','2011-10-03 13:57:11',NULL,NULL,NULL,'aktywny','Katarzyna','Góra',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1140,1,'kg.pracownik','57091af1260966a65cf521d4fe1eb63b','katarzyna.gora@m-media.pl','2011-10-03 13:58:10',NULL,NULL,NULL,'aktywny','Katarzyna','Góra',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1141,1,'kg.windykacja','57091af1260966a65cf521d4fe1eb63b','katarzyna.gora@supertraders.pl','2011-10-03 13:58:52',NULL,NULL,NULL,'aktywny','Katarzyna','Góra',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1142,1,'mz.kierownik','57091af1260966a65cf521d4fe1eb63b','michal.zientara@m-media.pl','2011-10-03 13:59:35',NULL,NULL,NULL,'aktywny','Michał','Zientara',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1143,1,'mz.pracownik','57091af1260966a65cf521d4fe1eb63b','michal.zientara@m-media.pl','2011-10-03 14:00:07',NULL,NULL,NULL,'aktywny','Michał','Zientara',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1144,1,'mz.windykacja','57091af1260966a65cf521d4fe1eb63b','michal.zientara@supertraders.pl','2011-10-03 14:00:37',NULL,NULL,NULL,'aktywny','Michał','Zientara',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1169,1,'elzbieta.watras','ee2cd5892f89cab1bf3e1469dd20d1c4','elzbieta.watras@m-media.pl','2011-10-11 06:58:53',NULL,NULL,NULL,'zablokowany','Elżbieta','Watras',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1170,1,'paulina.leyko','fb3243cac515d346fca768fc5fab8578','paulina.leyko@m-media.pl','2011-10-11 06:59:48',NULL,NULL,NULL,'aktywny','Paulina','Leyko-Pyzik',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1171,1,'magdalena.dziurzynska','812539644bf04e89f5271e8abb2baad1','magdalena.dziurzynska@m-media.pl','2011-10-11 07:01:59',NULL,NULL,NULL,'aktywny','Magdalena','Dziurzyńska',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1328,1,'tester_prc_bok','572fe9d4cc151b1cf4f1c39123238352','pawel.litwiniuk@m-media.pl','2011-11-03 10:14:28',NULL,NULL,NULL,'zablokowany','Paweł','Litwiniuk',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1330,1,'tester_krw_bok','6c2130840922a601e04414b35fc7f47b','pawel.litwiniuk@m-media.pl','2011-11-03 10:28:28',NULL,NULL,NULL,'zablokowany','Paweł','Litwiniuk',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(1943,1,'monika.wojnarowska','afdb52e2aaa510a121741a1899f080d6','monika.wojnarowska@m-media.pl','2012-02-20 07:27:15',NULL,NULL,NULL,'aktywny','Monika','Wojnarowska',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(2084,1,'magdalena.pietrzak','51fef5071d7e29f6c0db306e6cb67b23','magdalena.pietrzak@supertraders.pl','2012-03-08 13:07:05',NULL,NULL,NULL,'aktywny','Magdalena','Pietrzak',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(2122,1,'magdalena.zubrzak','8c5c417c26943560fea7cf30aa0d7478','magdalena.zubrzak@m-media.pl','2012-03-14 11:09:07',NULL,NULL,NULL,'aktywny','Magdalena','Zubrzak',NULL,'K',NULL,NULL,NULL,NULL,'Magdalena, Zubrzak',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(2698,1,'michal.rachwal','109405dd28c6459f363a7f4a42d3186d','michal.rachwal@m-media.pl','2012-07-04 15:52:59',NULL,NULL,NULL,'aktywny','Michał','Rachwał',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(2732,1,'stadmin','fdc21332bf032d51b64093349e248658','marcin.michalski@m-media.pl','2012-07-12 06:07:56',NULL,NULL,1,'aktywny','Marcin','Michalski',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(2776,1,'tomasz.tracz','cc6485eee81e5799d2712ae240eb7c45','tomasz.tracz@m-media.pl','2012-07-18 15:14:58',NULL,NULL,NULL,'aktywny','Tomasz','Tracz',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(2897,1,'monika.szczepan','966b31a2734d862c9e6e10edfdcf7f2b','monika.szczepan@m-media.pl','2012-08-08 14:50:13',NULL,NULL,NULL,'aktywny','Monika','Szczepan',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(3044,1,'monika.szczepan.bok','b2aa59504ad088faa8d863ca94079d7a','monika.szczepan@m-media.pl','2012-09-07 08:09:09',NULL,NULL,NULL,'aktywny','Monika','Szczepan',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(3221,1,'marcin.bok','4a18ac145d8e8b578a484f6342cfe96a','marcin.mucha@m-media.pl','2012-10-04 16:12:30',NULL,NULL,NULL,'aktywny','Marcin','Mucha',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(3235,1,'sabina.przepiora','aeddf950c3e7e846cef84bdd3f75c458','sabina.przepiora@m-media.pl','2012-10-09 05:56:26',NULL,NULL,NULL,'aktywny','Sabina','Przepióra',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(3236,1,'agnieszka.lew','f9751651775df284a0bd47785ed78c69','agnieszka.lew@m-media.pl','2012-10-09 05:58:54',NULL,NULL,NULL,'aktywny','Agnieszka','Lew',NULL,'K',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'',''),(3281,1,'marcin.ph','5fec4ba8376f207d1ff2f0cac0882b01','marcin.mucha@m-media.pl','2012-10-16 10:44:15',NULL,NULL,NULL,'aktywny','Marcin','Mucha',NULL,'M',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pl',0,0,'klient',NULL,NULL,'','');

INSERT INTO "cms_uzytkownicy_role" ("id", "id_projektu", "id_uzytkownika", "id_roli") VALUES (1,1,1,1),(84,1,84,4),(687,1,685,4),(3255,1,2732,1);

INSERT INTO "cms_widoki" ("id", "id_projektu", "kod_jezyka", "nazwa", "uklad_strony", "struktura") VALUES (29,1,'pl','Fe Układ Zwykła Strona','uklad_podstawowy','region_0,blok_0,');

INSERT INTO "modul_formularz_kontaktowy_tematy" ("id", "id_projektu", "kod_jezyka", "id_kategorii", "temat", "email", "email_dw", "konfiguracja") VALUES (1,1,'pl',9,'Kontakt z Biurem Obsługi Klienta','a:1:{i:0;s:32:\"a:1:{i:0;s:14:\"test@sttest.pl\";}\";}','a:0:{}','a:8:{s:5:\"tresc\";s:1:\"2\";s:4:\"imie\";s:1:\"2\";s:8:\"nazwisko\";s:1:\"1\";s:10:\"firmaNazwa\";s:1:\"1\";s:7:\"nadawca\";s:1:\"2\";s:7:\"telefon\";s:1:\"1\";s:7:\"komorka\";s:1:\"1\";s:11:\"daneOsobowe\";s:1:\"2\";}'),(5,1,'pl',9,'Kontakt w sprawie płatności','a:1:{i:0;s:32:\"a:1:{i:0;s:14:\"test@sttest.pl\";}\";}','a:0:{}','a:8:{s:5:\"tresc\";s:1:\"2\";s:4:\"imie\";s:1:\"2\";s:8:\"nazwisko\";s:1:\"2\";s:10:\"firmaNazwa\";s:1:\"2\";s:7:\"nadawca\";s:1:\"2\";s:7:\"telefon\";s:1:\"1\";s:7:\"komorka\";s:1:\"1\";s:11:\"daneOsobowe\";s:1:\"2\";}'),(6,1,'pl',9,'Uwagi i błędy na portalu','a:1:{i:0;s:32:\"a:1:{i:0;s:14:\"test@sttest.pl\";}\";}','a:0:{}','a:8:{s:5:\"tresc\";s:1:\"2\";s:4:\"imie\";s:1:\"2\";s:8:\"nazwisko\";s:1:\"2\";s:10:\"firmaNazwa\";s:1:\"1\";s:7:\"nadawca\";s:1:\"2\";s:7:\"telefon\";s:1:\"1\";s:7:\"komorka\";s:1:\"1\";s:11:\"daneOsobowe\";s:1:\"2\";}'),(9,1,'pl',9,'Zgłoszenie nadużycia','a:1:{i:0;s:32:\"a:1:{i:0;s:14:\"test@sttest.pl\";}\";}','a:0:{}','a:5:{s:5:\"tresc\";s:1:\"2\";s:4:\"imie\";s:1:\"1\";s:8:\"nazwisko\";s:1:\"1\";s:7:\"nadawca\";s:1:\"2\";s:9:\"stronaWWW\";s:1:\"2\";}');

INSERT INTO "modul_strona_opisowa" ("id", "id_projektu", "kod_jezyka", "id_kategorii", "tytul", "tresc", "id_uzytkownika", "data_dodania", "katalog") VALUES (1,1,'pl',2,'','<p style=\"display:block; background:#fff; border-radius:4px; padding:5px; margin-top:100px; width:100px; margin-left:auto; margin-right:auto; text-align:center;\"><a href=\"/logowanie\">Zaloguj się</a></p>',0,'2013-02-12 07:31:59','');
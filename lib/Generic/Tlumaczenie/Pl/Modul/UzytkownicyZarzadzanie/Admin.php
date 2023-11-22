<?php
namespace Generic\Tlumaczenie\Pl\Modul\UzytkownicyZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_login_zajety']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_uzytkownika']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['emailAktywacyjny.blad_brak_kategorii']
 * @property string $t['emailAktywacyjny.blad_brak_uzytkownika']
 * @property string $t['emailAktywacyjny.blad_brak_wizytowki']
 * @property string $t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego']
 * @property string $t['emailAktywacyjny.info_utworzono_konto_uzytkownika']
 * @property string $t['emailAktywacyjny.tresc']
 * @property string $t['emailAktywacyjny.tresc_html']
 * @property string $t['emailAktywacyjny.tytul']
 * @property string $t['formularz.akcje.zakladka']
 * @property string $t['formularz.blad_nie_mozna_przypisac_roli']
 * @property string $t['formularz.blad_zapisu_uzytkownika']
 * @property string $t['formularz.czyAdmin.etykieta']
 * @property string $t['formularz.czyAdmin.opis']
 * @property string $t['formularz.dane_firmowe.region']
 * @property string $t['formularz.dane_kontaktowe.region']
 * @property string $t['formularz.dane_podstawowe.region']
 * @property string $t['formularz.dataUrodzenia.etykieta']
 * @property string $t['formularz.dataUrodzenia.opis']
 * @property string $t['formularz.doWizytowki.wartosc']
 * @property string $t['formularz.email.etykieta']
 * @property string $t['formularz.email.opis']
 * @property string $t['formularz.firmaAdres.etykieta']
 * @property string $t['formularz.firmaAdres.opis']
 * @property string $t['formularz.firmaKodPocztowy.etykieta']
 * @property string $t['formularz.firmaKodPocztowy.opis']
 * @property string $t['formularz.firmaMiasto.etykieta']
 * @property string $t['formularz.firmaMiasto.opis']
 * @property string $t['formularz.firmaNazwa.etykieta']
 * @property string $t['formularz.firmaNazwa.opis']
 * @property string $t['formularz.firmaNip.etykieta']
 * @property string $t['formularz.firmaNip.opis']
 * @property string $t['formularz.haslo.etykieta']
 * @property string $t['formularz.haslo.opis']
 * @property string $t['formularz.hasloPowtorz.etykieta']
 * @property string $t['formularz.hasloPowtorz.opis']
 * @property string $t['formularz.imie.etykieta']
 * @property string $t['formularz.imie.opis']
 * @property string $t['formularz.info_przypisano_role']
 * @property string $t['formularz.info_zapisano_dane_uzytkownika']
 * @property string $t['formularz.jezyk.etykieta']
 * @property string $t['formularz.jezyk.opis']
 * @property string $t['formularz.konfiguracja_smtp.region']
 * @property string $t['formularz.kontakAadres.opis']
 * @property string $t['formularz.kontaktAdres.etykieta']
 * @property string $t['formularz.kontaktFax.etykieta']
 * @property string $t['formularz.kontaktFax.opis']
 * @property string $t['formularz.kontaktKodPocztowy.etykieta']
 * @property string $t['formularz.kontaktKodPocztowy.opis']
 * @property string $t['formularz.kontaktKomorka.etykieta']
 * @property string $t['formularz.kontaktKomorka.opis']
 * @property string $t['formularz.kontaktMiasto.etykieta']
 * @property string $t['formularz.kontaktMiasto.opis']
 * @property string $t['formularz.kontaktNazwa.etykieta']
 * @property string $t['formularz.kontaktNazwa.opis']
 * @property string $t['formularz.kontaktTelefon.etykieta']
 * @property string $t['formularz.kontaktTelefon.opis']
 * @property string $t['formularz.kontaktWWW.etykieta']
 * @property string $t['formularz.kontaktWWW.opis']
 * @property string $t['formularz.login.Walidator_RozneOd.walidator_rozne_od_nie_jest_rozne']
 * @property string $t['formularz.login.etykieta']
 * @property string $t['formularz.login.opis']
 * @property string $t['formularz.nazwisko.etykieta']
 * @property string $t['formularz.nazwisko.opis']
 * @property string $t['formularz.plec.etykieta']
 * @property string $t['formularz.plec.opis']
 * @property string $t['formularz.pocztaHaslo.etykieta']
 * @property string $t['formularz.pocztaHaslo.opis']
 * @property string $t['formularz.pocztaHost.etykieta']
 * @property string $t['formularz.pocztaHost.opis']
 * @property string $t['formularz.pocztaLogin.etykieta']
 * @property string $t['formularz.pocztaLogin.opis']
 * @property string $t['formularz.pocztaPort.etykieta']
 * @property string $t['formularz.pocztaPort.opis']
 * @property string $t['formularz.role.zakladka']
 * @property string $t['formularz.status.etykieta']
 * @property string $t['formularz.status.opis']
 * @property string $t['formularz.uzytkownik.zakladka']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wyslijEmailAktywacyjny.wartosc']
 * @property string $t['formularz.zaloguj.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzImport.formularzImport.plik.etykieta']
 * @property string $t['formularzImport.formularzImport.plik.opis']
 * @property string $t['formularzImport.formularzImport.typ.etykieta']
 * @property string $t['formularzImport.formularzImport.typ.opis']
 * @property string $t['formularzImport.wstecz.wartosc']
 * @property string $t['formularzImport.zapisz.wartosc']
 * @property string $t['import.komunikat_error']
 * @property string $t['import.komunikat_succes']
 * @property string $t['import.tytul_strony']
 * @property string $t['index.admin_nie']
 * @property string $t['index.admin_tak']
 * @property string $t['index.czy_admin.etykieta']
 * @property string $t['index.czysc.wartosc']
 * @property string $t['index.data_dodania.etykieta']
 * @property string $t['index.data_dodania_do.etykieta']
 * @property string $t['index.data_dodania_od.etykieta']
 * @property string $t['index.email.etykieta']
 * @property string $t['index.etykieta_button_przechwyc']
 * @property string $t['index.etykieta_czy_admin']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_data_dodania_do']
 * @property string $t['index.etykieta_data_dodania_od']
 * @property string $t['index.etykieta_dodaj_uzytkownika']
 * @property string $t['index.etykieta_email']
 * @property string $t['index.etykieta_imie']
 * @property string $t['index.etykieta_link_doadaj']
 * @property string $t['index.etykieta_link_konta']
 * @property string $t['index.etykieta_login']
 * @property string $t['index.etykieta_nazwisko']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_status']
 * @property string $t['index.fraza.etykieta']
 * @property string $t['index.rola.etykieta']
 * @property string $t['index.status.etykieta']
 * @property string $t['index.szukaj.wartosc']
 * @property string $t['index.tytul_strony']
 * @property string $t['przechwyc.blad_brak_uprawnien']
 * @property string $t['przechwyc.blad_brak_uzytkownika']
 * @property string $t['przechwyc.etykieta_input_pytanie']
 * @property string $t['przechwyc.etykieta_input_wstecz']
 * @property string $t['przechwyc.etykieta_input_zapisz']
 * @property string $t['przechwyc.info_przechwycono_uzytkownika']
 * @property string $t['usun.blad_brak_uzytkownika']
 * @property string $t['usun.blad_nie_mozna_usunac_uzytkownika']
 * @property string $t['usun.info_uzytkownik_usuniety']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['edycjaDanychKontaktowych']
 * @property string $t['_akcje_etykiety_']['edycjaDanychFirmowych']
 * @property string $t['_akcje_etykiety_']['edycjaDanychPoczty']
 * @property string $t['_akcje_etykiety_']['edycjaRoli']
 * @property string $t['_akcje_etykiety_']['edycjaDodatkoweAkcje']
 * @property string $t['_akcje_etykiety_']['wykonajPrzechwyc']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajEmailAktywacyjny']
 * @property string $t['_akcje_etykiety_']['wykonajTest']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['usunieto_uzytkownika']
 * @property string $t['_zdarzenia_etykiety_']['zablokowano_uzytkownika']
 * @property string $t['_zdarzenia_etykiety_']['odblokowano_uzytkownika']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_aktywacyjny']
 * @property string $t['_zdarzenia_etykiety_']['przechwycono_konto']
 * @property array $t['plec']
 * @property string $t['plec']['K']
 * @property string $t['plec']['M']
 * @property array $t['uzytkownik.czyAdmin']
 * @property string $t['uzytkownik.czyAdmin']['0']
 * @property string $t['uzytkownik.czyAdmin']['1']
 * @property array $t['uzytkownik.data_dodania_opcje']
 * @property string $t['uzytkownik.data_dodania_opcje']['7']
 * @property string $t['uzytkownik.data_dodania_opcje']['14']
 * @property string $t['uzytkownik.data_dodania_opcje']['31']
 * @property array $t['uzytkownik.statusy']
 * @property string $t['uzytkownik.statusy']['nieaktywny']
 * @property string $t['uzytkownik.statusy']['aktywny']
 * @property string $t['uzytkownik.statusy']['zablokowany']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'dodaj.blad_login_zajety' => 'Wybrany login jest już zajęty!',
		'dodaj.tytul_strony' => 'Dodaj użytkownika',

		'edytuj.blad_brak_uzytkownika' => 'Nie można pobrać użytkownika',
		'edytuj.tytul_strony' => 'Edycja użytkownika: ',

		'emailAktywacyjny.blad_brak_kategorii' => 'Brak modułu odpowiedzialnego za aktywację kont',
		'emailAktywacyjny.blad_brak_uzytkownika' => 'Nie można pobrać użytkownika',
		'emailAktywacyjny.blad_brak_wizytowki' => 'Nie można pobrać wizytówki użytkownika',
		'emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego' => 'Nie można wysłać emaila aktywującego konto',
		'emailAktywacyjny.info_utworzono_konto_uzytkownika' => 'Na podany adres email została ponownie wysłana wiadomość z linkiem aktywującym konto.',
		'emailAktywacyjny.tresc' => '',
		'emailAktywacyjny.tresc_html' => '',
		'emailAktywacyjny.tytul' => 'SuperTraders - Aktywacja konta.',

		'formularz.akcje.zakladka' => 'Akcje',
		'formularz.kolekcje.zakladka' => 'Tidsbanken collection',
		
		'formularz.tidsbanken.zakladka' => 'Tidsbanken data',
		'formularz.tidsbankenLogin.region' => 'Tidsbanken login options',
		'formularz.tidsbankenKod.etykieta' => 'Pin Code',
		'formularz.tidsbankenLogujPrzezHaslo.etykieta' => 'Login by password',
		'formularz.wyswietlajWTidsbanken.etykieta' => 'Show user in tidsbank',
		'formularz.tidsbankenHaslo.etykieta' => 'Tidsbanken password',
		'formularz.tidsbankenNumerPracownika.etykieta' => 'User number',
		'formularz.informacjeZatrudnienie.region' => 'Employment information',
		'formularz.stanowisko.etykieta' => 'Title/position',
		'formularz.dzial.etykieta' => 'Department',
		'formularz.etat.etykieta' => 'Position percentage',
		'formularz.kontoBankowe.etykieta' => 'Salary account',
		'formularz.dniChorobowe.etykieta' => 'Egenmelding barns sykdom',
		'formularz.wlascicielKonta.etykieta' => 'Account owner',
		'formularz.dniWolne.etykieta' => 'Holiday',
		'formularz.stawkaUzytkownika.zakladka' => 'Wage per Hour',
		'formularz.pliki.zakladka' => 'Pliki',
		'formularz.stawka.etykieta' => 'Wage per Hour',
		
		'formularz.dane_opiekuna.region' => 'Next of kin',
		'formularz.opiekun.etykieta' => 'Name',
		'formularz.emailOpiekun.etykieta' => 'E-Mail',
		'formularz.telefonOpiekun.etykieta' => 'Phone',
		
		
		'formularz.blad_nie_mozna_przypisac_roli' => 'Nie mozna zapisac powiązań użytkownika z rolami',
		'formularz.blad_zapisu_uzytkownika' => 'Nie można zapisać danych użytkownika!',
		'formularz.czyAdmin.etykieta' => 'Może się logować do panelu',
		'formularz.czyAdmin.opis' => '',
		'formularz.dane_firmowe.region' => 'Dane firmowe',
		'formularz.dane_kontaktowe.region' => 'Dane kontaktowe',
		'formularz.dane_pracownicze.region' => 'Dane pracownicze',
		'formularz.dane_podstawowe.region' => 'Dane podstawowe',
		'formularz.dataUrodzenia.etykieta' => 'Data urodzenia',
		'formularz.dataUrodzenia.opis' => '',
		'formularz.doWizytowki.wartosc' => 'Przejdź do wizytówki',
		'formularz.email.etykieta' => 'E-Mail',
		'formularz.email.opis' => '',
		'formularz.firmaAdres.etykieta' => 'Ulica',
		'formularz.firmaAdres.opis' => '',
		'formularz.firmaKodPocztowy.etykieta' => 'Kod pocztowy',
		'formularz.firmaKodPocztowy.opis' => '',
		'formularz.firmaMiasto.etykieta' => 'Miasto',
		'formularz.firmaMiasto.opis' => '',
		'formularz.firmaNazwa.etykieta' => 'Nazwa firmy',
		'formularz.firmaNazwa.opis' => '',
		'formularz.firmaNip.etykieta' => 'Nip',
		'formularz.firmaNip.opis' => '',
		'formularz.haslo.etykieta' => 'Hasło',
		'formularz.haslo.opis' => '',
		'formularz.hasloPowtorz.etykieta' => 'Powtórz hasło',
		'formularz.hasloPowtorz.opis' => '',
		'formularz.imie.etykieta' => 'Imię',
		'formularz.imie.opis' => '',
		'formularz.info_przypisano_role' => 'Zapisano powiazania użytkownika z rolami',
		'formularz.info_zapisano_dane_uzytkownika' => 'Zapisano dane użytkownika',
		'formularz.jezyk.etykieta' => 'Domyślny język',
		'formularz.jezyk.opis' => '',
		'formularz.konfiguracja_smtp.region' => 'Konfiguracja poczty wychodzącej',
		'formularz.kontakAadres.opis' => '',
		'formularz.kontaktAdres.etykieta' => 'Ulica',
		'formularz.kontaktFax.etykieta' => 'Fax',
		'formularz.kontaktFax.opis' => '',
		'formularz.kontaktKodPocztowy.etykieta' => 'Kod pocztowy',
		'formularz.kontaktKodPocztowy.opis' => '',
		'formularz.kontaktKomorka.etykieta' => 'Telefon kom.',
		'formularz.kontaktKomorka.opis' => '',
		'formularz.kontaktMiasto.etykieta' => 'Miasto',
		'formularz.kontaktMiasto.opis' => '',
		'formularz.telKomorkaFirmowa.etykieta' => 'Komórka służbowa',
		'formularz.telKomorkaPrywatna.etykieta' => 'Komórka prywatna',
		'formularz.telKomorkaPrywatna.opis' => '',
		'formularz.telKomorkaFirmowa.opis' => '',
		'formularz.telDomowy.etykieta' => 'Telefon domowy',
		'formularz.telDomowy.opis' => '',
		'formularz.stawkaGodzinowa.etykieta' => 'Stawka godzinowa',
		'formularz.stawkaGodzinowa.opis' => '',
		'formularz.tabelaPodatkowa.etykieta' => 'Tabela podatkowa',
		'formularz.tabelaPodatkowa.opis' => '',
		'formularz.umiejetnosci.etykieta' => 'Umiejętności',
		'formularz.umiejetnosci.opis' => '',
		
		'formularz.zdjecie.etykieta' => 'Zdjęcie',
		'formularz.zdjecie.opis' => '',
		'formularz.krajPochodzenia.etykieta' => 'Kraj pochodzenia',
		'formularz.login.Walidator_RozneOd.walidator_rozne_od_nie_jest_rozne' => 'Podany login już istnieje.',
		'formularz.login.etykieta' => 'Login',
		'formularz.login.opis' => '',
		'formularz.nazwisko.etykieta' => 'Nazwisko',
		'formularz.nazwisko.opis' => '',
		'formularz.plec.etykieta' => 'Płeć',
		'formularz.plec.opis' => '',
		'formularz.pocztaHaslo.etykieta' => 'Haslo',
		'formularz.pocztaHaslo.opis' => '',
		'formularz.pocztaHost.etykieta' => 'Serwer SMTP',
		'formularz.pocztaHost.opis' => '',
		'formularz.pocztaLogin.etykieta' => 'Login',
		'formularz.pocztaLogin.opis' => '',
		'formularz.pocztaPort.etykieta' => 'Port',
		'formularz.pocztaPort.opis' => '',
		'formularz.role.zakladka' => 'Przypisane role',
		'formularz.status.etykieta' => 'Status',
		'formularz.status.opis' => '',
		'formularz.uzytkownik.zakladka' => 'Dana użytkownika',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.wyslijEmailAktywacyjny.wartosc' => 'Wyślij e-mail aktywacyjny',
		'formularz.zaloguj.wartosc' => 'Zaloguj się jako ten użytkownik',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularz.uprawnienie.wartosc' => 'Uprawnienie',
		'formularz.edycja_admin_blad_walidacji' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione',
		'formularz.praktykant.etykieta' => 'Praktykant',
		'formularz.praktykant.opis' => '',
		
		'formularz.praktykantDataDo.etykieta' => 'Data zkończenia praktyk',
		'formularz.praktykantDataDo.opis' => 'po tej dacie użytkownik będzie traktowany jak normalny pracownik',

		'formularzImport.formularzImport.plik.etykieta' => 'Plik z numerami kont bankowych do importu',
		'formularzImport.formularzImport.plik.opis' => '',
		'formularzImport.formularzImport.typ.etykieta' => 'Typ numerów do importu',
		'formularzImport.formularzImport.typ.opis' => '',
		'formularzImport.wstecz.wartosc' => 'Wstecz',
		'formularzImport.zapisz.wartosc' => 'Zapisz',

		'import.komunikat_error' => 'Wystąpił błąd zapisu dla numeru konta w linii: {nrLinii}. Sprawdź czy importowane numery kont lub umów nie istnieją już w bazie.',
		'import.komunikat_succes' => 'Zaimportowano {liczba} numerów kont.',
		'import.tytul_strony' => 'Import numerów kont bankowych',

		'index.admin_nie' => 'Nie',
		'index.admin_tak' => 'Tak',
		'index.czy_admin.etykieta' => 'Administrator',
		'index.czysc.wartosc' => 'Czyść',
		'index.data_dodania.etykieta' => 'Data dodania',
		'index.data_dodania_do.etykieta' => '-',
		'index.data_dodania_od.etykieta' => 'Dodany',
		'index.email.etykieta' => 'E-mail',
		'index.etykieta_button_przechwyc' => 'Przechwyć',
		'index.etykieta_czy_admin' => 'Admin',
		'index.etykieta_data_dodania' => 'Data dodania',
		'index.etykieta_data_dodania_do' => '-',
		'index.etykieta_data_dodania_od' => 'Dodana od',
		'index.etykieta_dodaj_uzytkownika' => 'Dodaj użytkownika',
		'index.etykieta_email' => 'Email',
		'index.etykieta_imie' => 'Imię',
		'index.etykieta_link_doadaj' => 'Dodaj użytkownika',
		'index.etykieta_link_konta' => 'Importuj numery kont bankowych',
		'index.etykieta_login' => 'Login',
		'index.etykieta_nazwisko' => 'Nazwisko',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_status' => 'Status',
		'index.fraza.etykieta' => 'Fraza',
		'index.rola.etykieta' => 'Rola',
		'index.status.etykieta' => 'Status',
		'index.szukaj.wartosc' => 'Szukaj',
		'index.tytul_strony' => 'Zarzadzanie użytkownikami',

		'przechwyc.blad_brak_uprawnien' => 'Nie masz uprawnień do wykonywania tej akcji',
		'przechwyc.blad_brak_uzytkownika' => 'Nie można pobrać danych użytkownika',
		'przechwyc.etykieta_input_pytanie' => 'Czy chcesz się zalogować jako użytkownik %s ?',
		'przechwyc.etykieta_input_wstecz' => 'Anuluj',
		'przechwyc.etykieta_input_zapisz' => 'Zaloguj się',
		'przechwyc.info_przechwycono_uzytkownika' => 'Zalogowano na konto użytkownika %s z konta superużytkownika',

		'usun.blad_brak_uzytkownika' => 'Nie można pobrać użytkownika',
		'usun.blad_nie_mozna_usunac_uzytkownika' => 'Nie można usunąć użytkownika!',
		'usun.info_uzytkownik_usuniety' => 'Użytkownik został usunięty',
		
		'usunZdjecie.info_usunieto_zdjecie' => 'Zdjęcie zostało usuniete',
		'usunZdjecie.blad_nie_mozna_usunac_zdjecia' => 'Nie można usunać zdjęcia',
		'usunZdjecie.blad_nie_mozna_pobrac_uzytkownika' => 'Nie można pobrać danych uzytkownika o podanym ID',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista użytkowników',
			'wykonajDodaj' => 'Dodawanie użytkowników',
			'wykonajEdytuj' => 'Edycja użytkowniów',
			'edycjaDanychKontaktowych' => 'Edycja danych kontaktowych użytkownika',
			'edycjaDanychFirmowych' => 'Edycja danych firmy użytkownika',
			'edycjaDanychPoczty' => 'Edycja danych poczty wychodzącej SMTP',
			'edycjaRoli' => 'Przypisywanie roli w systemie',
			'edycjaDodatkoweAkcje' => 'Dodatkowe akcje edycji użytkownika',
			'pliki' => 'Pliki',
			'wykonajPrzechwyc' => 'Przechwycenie konta użytkownika',
			'wykonajUsun' => 'Usuwanie użytkowników',
			'wykonajEmailAktywacyjny' => 'Wysłanie e-mail\'a aktywacyjnego',
			'wykonajUsunZdjecie' => 'Usuń zdjęcie',
			'edycjaDanychPracowniczych' => 'Edycja danych pracownika'
		),

		'_zdarzenia_etykiety_' => array(
			'usunieto_uzytkownika' => 'Usunieto użytkownika',
			'zablokowano_uzytkownika' => 'Zablokowano użytkownika',
			'odblokowano_uzytkownika' => 'Odblokowano użytkownika',
			'wyslano_email_aktywacyjny' => 'Wysłano e-mail aktywacyjny',
			'przechwycono_konto' => 'Przechwycono konto',
		),

		'plec' => array(
			'K' => 'Kobieta',
			'M' => 'Mężczyzna',
		),

		'uzytkownik.czyAdmin' => array(
			'0' => 'Nie',
			'1' => 'Tak',
		),
		'uzytkownik.data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
		),
		'uzytkownik.statusy' => array(
			'nieaktywny' => 'Nieaktywny',
			'aktywny' => 'Aktywny',
			'zablokowany' => 'Zablokowany',
		),
	);

	protected $typyPolTlumaczen = array(
	);
}

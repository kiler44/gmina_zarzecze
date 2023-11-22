<?php
namespace Generic\Tlumaczenie\En\Modul\UzytkownicyZarzadzanie;

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

		'dodaj.blad_login_zajety' => 'Entered login already in use!',
		'dodaj.tytul_strony' => 'Add user',

		'edytuj.blad_brak_uzytkownika' => 'Cannot obtain user data',
		'edytuj.tytul_strony' => 'Edit user: ',

		'emailAktywacyjny.blad_brak_kategorii' => 'Account activation module not present',
		'emailAktywacyjny.blad_brak_uzytkownika' => 'User with given id does not exist',
		'emailAktywacyjny.blad_brak_wizytowki' => 'Cannot read users profile',
		'emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego' => 'Cannot send activation email',
		'emailAktywacyjny.info_utworzono_konto_uzytkownika' => 'The activation email has been sent to provided e-mail address',
		'emailAktywacyjny.tresc' => '',
		'emailAktywacyjny.tresc_html' => '',
		'emailAktywacyjny.tytul' => 'BKT - account activation',

		'formularz.akcje.zakladka' => 'Actions',
		
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
		'formularz.pliki.zakladka' => 'Files',
		'formularz.stawka.etykieta' => 'Wage per Hour',
		
		'formularz.stalaWyplata.etykieta' => 'Salary',
		
		'formularz.dane_opiekuna.region' => 'Next of kin',
		'formularz.opiekun.etykieta' => 'Name',
		'formularz.emailOpiekun.etykieta' => 'E-Mail',
		'formularz.telefonOpiekun.etykieta' => 'Phone',
		
		'formularz.blad_nie_mozna_przypisac_roli' => 'Cannot save linkings between user and roles',
		'formularz.blad_zapisu_uzytkownika' => 'Cannot save user data!',
		'formularz.czyAdmin.etykieta' => 'Can login to control panel',
		'formularz.czyAdmin.opis' => '',
		'formularz.dane_firmowe.region' => 'Companys data',
		'formularz.dane_kontaktowe.region' => 'Contact data',
		'formularz.dane_pracownicze.region' => 'Employee data',
		'formularz.dane_podstawowe.region' => 'General data',
		'formularz.dataUrodzenia.etykieta' => 'Date of birth',
		'formularz.dataUrodzenia.opis' => '',
		'formularz.doWizytowki.wartosc' => 'Go to user profile',
		'formularz.email.etykieta' => 'E-Mail',
		'formularz.email.opis' => '',
		'formularz.firmaAdres.etykieta' => 'Street',
		'formularz.firmaAdres.opis' => '',
		'formularz.firmaKodPocztowy.etykieta' => 'Post code',
		'formularz.firmaKodPocztowy.opis' => '',
		'formularz.firmaMiasto.etykieta' => 'City',
		'formularz.firmaMiasto.opis' => '',
		'formularz.firmaNazwa.etykieta' => 'Company name',
		'formularz.firmaNazwa.opis' => '',
		'formularz.firmaNip.etykieta' => 'Tax number',
		'formularz.firmaNip.opis' => '',
		'formularz.haslo.etykieta' => 'Password',
		'formularz.haslo.opis' => '',
		'formularz.hasloPowtorz.etykieta' => 'Confirm password',
		'formularz.hasloPowtorz.opis' => '',
		'formularz.imie.etykieta' => 'Name',
		'formularz.imie.opis' => '',
		'formularz.info_przypisano_role' => 'User and role linkings saved',
		'formularz.info_zapisano_dane_uzytkownika' => 'User saved',
		'formularz.jezyk.etykieta' => 'Default language',
		'formularz.jezyk.opis' => '',
		'formularz.konfiguracja_smtp.region' => 'E-mail configuration',
		'formularz.kontakAadres.opis' => '',
		'formularz.kontaktAdres.etykieta' => 'Street',
		'formularz.kontaktFax.etykieta' => 'Fax',
		'formularz.kontaktFax.opis' => '',
		'formularz.kontaktKodPocztowy.etykieta' => 'Post code',
		'formularz.kontaktKodPocztowy.opis' => '',
		'formularz.telKomorkaFirmowa.etykieta' => 'Business mobile',
		'formularz.telKomorkaPrywatna.etykieta' => 'Private mobile',
		'formularz.telKomorkaPrywatna.opis' => '',
		'formularz.telKomorkaFirmowa.opis' => '',
		'formularz.telDomowy.etykieta' => 'Telphone',
		'formularz.telDomowy.opis' => '',
		'formularz.stawkaGodzinowa.etykieta' => 'Wage per hour',
		'formularz.stawkaGodzinowa.opis' => '',
		'formularz.tabelaPodatkowa.etykieta' => 'Tax table',
		'formularz.tabelaPodatkowa.opis' => '',
		'formularz.umiejetnosci.etykieta' => 'Skills',
		'formularz.umiejetnosci.opis' => '',
		'formularz.praktykant.etykieta' => 'Trainee',
		'formularz.praktykant.opis' => '',
		
		'formularz.praktykantDataDo.etykieta' => 'Date end of trainee',
		'formularz.praktykantDataDo.opis' => 'after this date user will be login how normal workers',
		
		'formularz.zdjecie.etykieta' => 'Photo',
		'formularz.zdjecie.opis' => '',
		'formularz.krajPochodzenia.etykieta' => 'Country of origin',
		'formularz.kontaktMiasto.etykieta' => 'City',
		'formularz.kontaktMiasto.opis' => '',
		'formularz.kontaktNazwa.opis' => '',
		'formularz.kontaktTelefon.etykieta' => 'Telphone',
		'formularz.kontaktTelefon.opis' => '',
		'formularz.kontaktWWW.etykieta' => 'Web page',
		'formularz.kontaktWWW.opis' => '',
		'formularz.login.Walidator_RozneOd.walidator_rozne_od_nie_jest_rozne' => 'Entered login already in use',
		'formularz.login.etykieta' => 'Login',
		'formularz.login.opis' => '',
		'formularz.nazwisko.etykieta' => 'Surename',
		'formularz.nazwisko.opis' => '',
		'formularz.plec.etykieta' => 'Sex',
		'formularz.plec.opis' => '',
		'formularz.pocztaHaslo.etykieta' => 'Password',
		'formularz.pocztaHaslo.opis' => '',
		'formularz.pocztaHost.etykieta' => 'SMTP Server',
		'formularz.pocztaHost.opis' => '',
		'formularz.pocztaLogin.etykieta' => 'Login',
		'formularz.pocztaLogin.opis' => '',
		'formularz.pocztaPort.etykieta' => 'Port',
		'formularz.pocztaPort.opis' => '',
		'formularz.role.zakladka' => 'Assigned roles',
		'formularz.status.etykieta' => 'Status',
		'formularz.status.opis' => '',
		'formularz.uzytkownik.zakladka' => 'User data',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.wyslijEmailAktywacyjny.wartosc' => 'Send activation e-mail',
		'formularz.zaloguj.wartosc' => 'Sign-in as this user',
		'formularz.zapisz.wartosc' => 'Save',
		'formularz.uprawnienie.wartosc' => 'Privilage',
		'formularz.edycja_admin_blad_walidacji' => 'Not all of required fields have been filled properly',

		'formularzImport.formularzImport.plik.etykieta' => 'Import bank account numbers',
		'formularzImport.formularzImport.plik.opis' => '',
		'formularzImport.formularzImport.typ.etykieta' => 'Type of account numbers',
		'formularzImport.formularzImport.typ.opis' => '',
		'formularzImport.wstecz.wartosc' => 'Back',
		'formularzImport.zapisz.wartosc' => 'Save',

		'import.komunikat_error' => 'Wystąpił błąd zapisu dla numeru konta w linii: {nrLinii}. Sprawdź czy importowane numery kont lub umów nie istnieją już w bazie.',
		'import.komunikat_succes' => 'Zaimportowano {liczba} numerów kont.',
		'import.tytul_strony' => 'Import numerów kont bankowych',

		'index.admin_nie' => 'No',
		'index.admin_tak' => 'Yes',
		'index.czy_admin.etykieta' => 'Administrator',
		'index.czysc.wartosc' => 'Clear',
		'index.data_dodania.etykieta' => 'Creation date',
		'index.data_dodania_do.etykieta' => '-',
		'index.data_dodania_od.etykieta' => 'Added',
		'index.email.etykieta' => 'E-mail',
		'index.etykieta_button_przechwyc' => 'Capture',
		'index.etykieta_czy_admin' => 'Admin',
		'index.etykieta_data_dodania' => 'Creation date',
		'index.etykieta_data_dodania_do' => '-',
		'index.etykieta_data_dodania_od' => 'Date from',
		'index.etykieta_dodaj_uzytkownika' => 'Create user',
		'index.etykieta_email' => 'Email',
		'index.etykieta_imie' => 'Name',
		'index.etykieta_link_doadaj' => 'Create user',
		'index.etykieta_link_konta' => 'Import bank account numbers',
		'index.etykieta_login' => 'Login',
		'index.etykieta_nazwisko' => 'Surname',
		'index.etykieta_select_wybierz' => '- select -',
		'index.etykieta_status' => 'Status',
		'index.fraza.etykieta' => 'Phrase',
		'index.rola.etykieta' => 'Role',
		'index.status.etykieta' => 'Status',
		'index.szukaj.wartosc' => 'Search',
		'index.tytul_strony' => 'Users management',

		'przechwyc.blad_brak_uprawnien' => 'You don\'t have permission to perform this action',
		'przechwyc.blad_brak_uzytkownika' => 'Cannot obtain user data',
		'przechwyc.etykieta_input_pytanie' => 'Do you wan to sign-in as user: %s ?',
		'przechwyc.etykieta_input_wstecz' => 'Cancel',
		'przechwyc.etykieta_input_zapisz' => 'Sign-in',
		'przechwyc.info_przechwycono_uzytkownika' => 'You are now signed-in as %s z from superadmin account',

		'usun.blad_brak_uzytkownika' => 'Cannot obtain user data',
		'usun.blad_nie_mozna_usunac_uzytkownika' => 'Cennot remove user!',
		'usun.info_uzytkownik_usuniety' => 'User removed',
		
		'usunZdjecie.info_usunieto_zdjecie' => 'Photo has been removed',
		'usunZdjecie.blad_nie_mozna_usunac_zdjecia' => 'Cannot remove this photo',
		'usunZdjecie.blad_nie_mozna_pobrac_uzytkownika' => 'Cannot obtain user data with this ID',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Users list',
			'wykonajDodaj' => 'Create users',
			'wykonajEdytuj' => 'Edit users',
			'edycjaDanychKontaktowych' => 'Edit contact data',
			'edycjaDanychFirmowych' => 'Edit company data',
			'edycjaDanychPoczty' => 'SMTP settings',
			'edycjaRoli' => 'Assign a role to user',
			'edycjaDodatkoweAkcje' => 'Additional actions',
			'pliki' => 'Files',
			'kolekcje' => 'Tidsbanken Collection',
			'wykonajPrzechwyc' => 'Capture user account',
			'wykonajUsun' => 'Delete users',
			'wykonajEmailAktywacyjny' => 'Send activation e-mail',
			'wykonajUsunZdjecie' => 'Remove photo',
			'edycjaDanychPracowniczych' => 'Employee data',
		),

		'_zdarzenia_etykiety_' => array(
			'usunieto_uzytkownika' => 'User removed',
			'zablokowano_uzytkownika' => 'User blocked',
			'odblokowano_uzytkownika' => 'User unlocked',
			'wyslano_email_aktywacyjny' => 'Activation e-mail sent',
			'przechwycono_konto' => 'Account captured',
		),

		'plec' => array(
			'K' => 'Female',
			'M' => 'Male',
		),

		'uzytkownik.czyAdmin' => array(
			'0' => 'No',
			'1' => 'Yes',
		),
		'uzytkownik.data_dodania_opcje' => array(
			'7' => 'Last wek',
			'14' => 'Last two weeks',
			'31' => 'last month',
		),
		'uzytkownik.statusy' => array(
			'nieaktywny' => 'Not active',
			'aktywny' => 'Active',
			'zablokowany' => 'Blocked',
		),
	);

	protected $typyPolTlumaczen = array(
	);
}

<?php
namespace Generic\Tlumaczenie\No\Modul\Testy;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['emailTestowy.blad.nie_mozna_wyslac_emaila']
 * @property string $t['emailTestowy.dane_email.zakladka']
 * @property string $t['emailTestowy.debugInfo.zakladka']
 * @property string $t['emailTestowy.doEmail.etykieta']
 * @property string $t['emailTestowy.doEmail.opis']
 * @property string $t['emailTestowy.doNazwa.etykieta']
 * @property string $t['emailTestowy.doNazwa.opis']
 * @property string $t['emailTestowy.info_wyslano_poprawnie']
 * @property string $t['emailTestowy.odEmail.etykieta']
 * @property string $t['emailTestowy.odEmail.opis']
 * @property string $t['emailTestowy.odNazwa.etykieta']
 * @property string $t['emailTestowy.odNazwa.opis']
 * @property string $t['emailTestowy.smtpDebug.etykieta']
 * @property string $t['emailTestowy.smtpDebug.opis']
 * @property string $t['emailTestowy.tresc.etykieta']
 * @property string $t['emailTestowy.tresc.opis']
 * @property string $t['emailTestowy.trescHtml.etykieta']
 * @property string $t['emailTestowy.trescHtml.opis']
 * @property string $t['emailTestowy.tytul.etykieta']
 * @property string $t['emailTestowy.tytul.opis']
 * @property string $t['emailTestowy.wstecz.wartosc']
 * @property string $t['emailTestowy.zapisz.wartosc']
 * @property string $t['index.etykieta_email_testowy']
 * @property string $t['index.etykieta_link_logi']
 * @property string $t['index.etykieta_link_phpinfo']
 * @property string $t['index.etykieta_porownanie_konfiguracji']
 * @property string $t['index.etykieta_reset_danych']
 * @property string $t['index.etykieta_resetuj_dane']
 * @property string $t['index.etykieta_resetuj_dane_potwierdzenie']
 * @property string $t['index.etykieta_resetuj_dane_potwierdzenie2']
 * @property string $t['index.etykieta_sprawdz_katalogi']
 * @property string $t['index.etykieta_sprawdz_konfiguracje']
 * @property string $t['index.etykieta_sprawdz_tlumaczenia']
 * @property string $t['index.tytul_strony']
 * @property string $t['logi.etykieta_input_fraza']
 * @property string $t['logi.etykieta_input_szukaj']
 * @property string $t['logi.etykieta_input_typ']
 * @property string $t['logi.etykieta_nazwa']
 * @property string $t['logi.etykieta_select_wybierz']
 * @property string $t['logi.tytul_strony']
 * @property string $t['phpinfo.tytul_strony']
 * @property string $t['porownajKonfiguracje.etykieta_edutuj_konfiguracje']
 * @property string $t['porownajKonfiguracje.etykieta_klucz_konfiguracji']
 * @property string $t['porownajKonfiguracje.etykieta_modul']
 * @property string $t['porownajKonfiguracje.etykieta_status']
 * @property string $t['porownajKonfiguracje.etykieta_wartosc_konfiguracji_bazowa']
 * @property string $t['porownajKonfiguracje.etykieta_wartosc_konfiguracji_wczytana']
 * @property string $t['porownajKonfiguracje.plik.etykieta']
 * @property string $t['porownajKonfiguracje.plik.opis']
 * @property string $t['porownajKonfiguracje.tytul_strony']
 * @property string $t['porownajKonfiguracje.zapisz.wartosc']
 * @property string $t['resetujDaneUzytkownikow.komunikat_blad']
 * @property string $t['resetujDaneUzytkownikow.komunikat_wykonano']
 * @property string $t['resetujDaneUzytkownikow.komunikat_wykonano_SMSNIE']
 * @property string $t['resetujDaneUzytkownikow.komunikat_wykonano_SMSTAK']
 * @property string $t['sprawdzKonfiguracje.etykieta_blad']
 * @property string $t['sprawdzKonfiguracje.etykieta_id_bloku']
 * @property string $t['sprawdzKonfiguracje.etykieta_id_kategorii']
 * @property string $t['sprawdzKonfiguracje.etykieta_klucz']
 * @property string $t['sprawdzKonfiguracje.etykieta_napraw']
 * @property string $t['sprawdzKonfiguracje.etykieta_potwierdz_napraw']
 * @property string $t['sprawdzKonfiguracje.etykieta_potwierdz_usun_duplikaty']
 * @property string $t['sprawdzKonfiguracje.etykieta_usun_duplikaty']
 * @property string $t['sprawdzKonfiguracje.etykieta_wartosc']
 * @property string $t['sprawdzKonfiguracje.tytul_strony']
 * @property string $t['sprawdzTlumaczenia.etykieta_blad']
 * @property string $t['sprawdzTlumaczenia.etykieta_id_bloku']
 * @property string $t['sprawdzTlumaczenia.etykieta_id_kategorii']
 * @property string $t['sprawdzTlumaczenia.etykieta_klucz']
 * @property string $t['sprawdzTlumaczenia.etykieta_napraw']
 * @property string $t['sprawdzTlumaczenia.etykieta_potwierdz_napraw']
 * @property string $t['sprawdzTlumaczenia.etykieta_potwierdz_usun_duplikaty']
 * @property string $t['sprawdzTlumaczenia.etykieta_usun_duplikaty']
 * @property string $t['sprawdzTlumaczenia.etykieta_wartosc']
 * @property string $t['sprawdzTlumaczenia.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajPhpinfo']
 * @property string $t['_akcje_etykiety_']['wykonajLogi']
 * @property string $t['_akcje_etykiety_']['wykonajResetujDaneUzytkownikow']
 * @property array $t['emailTestowy.smtpDebug.wartosci']
 * @property string $t['emailTestowy.smtpDebug.wartosci']['0']
 * @property string $t['emailTestowy.smtpDebug.wartosci']['1']
 * @property string $t['emailTestowy.smtpDebug.wartosci']['2']
 * @property string $t['emailTestowy.smtpDebug.wartosci']['4']
 * @property array $t['logi.logi_typy']
 * @property string $t['logi.logi_typy']['php']
 * @property string $t['logi.logi_typy']['sql']
 * @property array $t['modul_typy']
 * @property string $t['modul_typy']['administracyjny']
 * @property string $t['modul_typy']['zwykly']
 * @property string $t['modul_typy']['jednorazowy']
 * @property string $t['modul_typy']['blok']
 * @property array $t['sprawdz.typy_bledow']
 * @property string $t['sprawdz.typy_bledow']['0']
 * @property string $t['sprawdz.typy_bledow']['1']
 * @property string $t['sprawdz.typy_bledow']['2']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'emailTestowy.blad.nie_mozna_wyslac_emaila' => 'Test e-mail not sent',
		'emailTestowy.dane_email.zakladka' => 'Test e-mail message',
		'emailTestowy.debugInfo.zakladka' => 'Debug info',
		'emailTestowy.doEmail.etykieta' => 'Recipient e-mail',
		'emailTestowy.doEmail.opis' => '',
		'emailTestowy.doNazwa.etykieta' => 'Recipient name',
		'emailTestowy.doNazwa.opis' => '',
		'emailTestowy.info_wyslano_poprawnie' => 'Test e-mail was sent',
		'emailTestowy.odEmail.etykieta' => 'Sender e-mail',
		'emailTestowy.odEmail.opis' => '',
		'emailTestowy.odNazwa.etykieta' => 'Sender name',
		'emailTestowy.odNazwa.opis' => '',
		'emailTestowy.smtpDebug.etykieta' => 'SMTP Debug',
		'emailTestowy.smtpDebug.opis' => '',
		'emailTestowy.tresc.etykieta' => 'Message',
		'emailTestowy.tresc.opis' => '',
		'emailTestowy.trescHtml.etykieta' => 'HTML message',
		'emailTestowy.trescHtml.opis' => '',
		'emailTestowy.tytul.etykieta' => 'Title',
		'emailTestowy.tytul.opis' => '',
		'emailTestowy.wstecz.wartosc' => 'Back',
		'emailTestowy.zapisz.wartosc' => 'Send',

		'index.etykieta_email_testowy' => 'Send test e-mail',
		'index.etykieta_link_logi' => 'Logs',
		'index.etykieta_link_phpinfo' => 'PHP info',
		'index.etykieta_porownanie_konfiguracji' => 'Compare configuration',
		'index.etykieta_reset_danych' => 'Reset system data',
		'index.etykieta_resetuj_dane' => 'Make reset of system data',
		'index.etykieta_resetuj_dane_potwierdzenie' => 'Are you sure you want to reset system data?',
		'index.etykieta_resetuj_dane_potwierdzenie2' => 'Really sure?',
		'index.etykieta_sprawdz_katalogi' => 'Check directories',
		'index.etykieta_sprawdz_konfiguracje' => 'Check configuration',
		'index.etykieta_sprawdz_tlumaczenia' => 'Check translations',
		'index.tytul_strony' => 'Tests and informations',
		
		'index.etykieta_aktualizuj_produkty_zakupione_villa' => 'Update product Villa',
		'index.etykieta_aktualizuj_produkty_zakupione_b2b' => 'Update products B2B',

		'logi.etykieta_input_fraza' => 'Search phrase',
		'logi.etykieta_input_szukaj' => 'Search',
		'logi.etykieta_input_typ' => 'File type',
		'logi.etykieta_nazwa' => 'File name',
		'logi.etykieta_select_wybierz' => '- pick -',
		'logi.tytul_strony' => 'Logs viewer',

		'phpinfo.tytul_strony' => 'PHP informations',

		'porownajKonfiguracje.etykieta_edutuj_konfiguracje' => 'Edit configuration',
		'porownajKonfiguracje.etykieta_klucz_konfiguracji' => 'Configuration key',
		'porownajKonfiguracje.etykieta_modul' => 'Module',
		'porownajKonfiguracje.etykieta_status' => 'Status',
		'porownajKonfiguracje.etykieta_wartosc_konfiguracji_bazowa' => 'System value',
		'porownajKonfiguracje.etykieta_wartosc_konfiguracji_wczytana' => 'Loaded value',
		'porownajKonfiguracje.plik.etykieta' => 'Load configuration file',
		'porownajKonfiguracje.plik.opis' => '',
		'porownajKonfiguracje.tytul_strony' => 'Compare configurations',
		'porownajKonfiguracje.zapisz.wartosc' => 'Compare',

		'resetujDaneUzytkownikow.komunikat_blad' => 'Reset of system data fail. try again later',
		'resetujDaneUzytkownikow.komunikat_wykonano' => 'Successfull reset of system data<br />
			Reset of logins and passwords: {{ILE_LOGINOW}}<br />
			Telephone numbers reseted: {{ILE_TELEFONOW}}<br />
			Clients reseted: {{ILE_KLIENCI}}<br />
			Reseted PH: {{ILE_PRZEDSTAWICIELE}}<br />
			Reset of SMS API data: {{CZY_SMSAPI}}<br />
			Reset of email senders: {{ILE_WIERSZE}}<br />
			Reset of email recipients: {{ILE_WIERSZE2}}<br />
			Reset of contact form recepients: {{ILE_WIERSZE3}}<br />
			Reset of SW users: {{ILE_UZYTKOWNICY_SW}}',
		'resetujDaneUzytkownikow.komunikat_wykonano_SMSNIE' => 'No',
		'resetujDaneUzytkownikow.komunikat_wykonano_SMSTAK' => 'Reset done',

		'sprawdzKonfiguracje.etykieta_blad' => 'Error type',
		'sprawdzKonfiguracje.etykieta_id_bloku' => 'Block',
		'sprawdzKonfiguracje.etykieta_id_kategorii' => 'Category',
		'sprawdzKonfiguracje.etykieta_klucz' => 'Key',
		'sprawdzKonfiguracje.etykieta_napraw' => 'Repair configuration',
		'sprawdzKonfiguracje.etykieta_potwierdz_napraw' => 'Do you really want to repair configuration?',
		'sprawdzKonfiguracje.etykieta_potwierdz_usun_duplikaty' => 'Do you really want to erase duplicate entries?',
		'sprawdzKonfiguracje.etykieta_usun_duplikaty' => 'Erase duplicated entries',
		'sprawdzKonfiguracje.etykieta_wartosc' => 'Walue',
		'sprawdzKonfiguracje.tytul_strony' => 'Configuration check',

		'sprawdzTlumaczenia.etykieta_blad' => 'Error type',
		'sprawdzTlumaczenia.etykieta_id_bloku' => 'Block',
		'sprawdzTlumaczenia.etykieta_id_kategorii' => 'Category',
		'sprawdzTlumaczenia.etykieta_klucz' => 'Key',
		'sprawdzTlumaczenia.etykieta_napraw' => 'Repair translations',
		'sprawdzTlumaczenia.etykieta_potwierdz_napraw' => 'Do you really want to repair translations?',
		'sprawdzTlumaczenia.etykieta_potwierdz_usun_duplikaty' => 'Do you really want to erase duplicate entries?',
		'sprawdzTlumaczenia.etykieta_usun_duplikaty' => 'Erase duplicated entries',
		'sprawdzTlumaczenia.etykieta_wartosc' => 'Walue',
		'sprawdzTlumaczenia.tytul_strony' => 'Check translations',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'MOdule index',
			'wykonajPodglad' => 'Preview',
			'wykonajPhpinfo' => 'Phpinfo',
			'wykonajLogi' => 'Logs',
			'wykonajResetujDaneUzytkownikow' => 'Reset of users data with test values',
		),
		'emailTestowy.smtpDebug.wartosci' => array(
			'0' => 'Off',
			'1' => 'Errors only',
			'2' => 'Errors end warnings',
			'4' => 'Full info',
		),

		'logi.logi_typy' => array(
			'php' => 'PHP Logs',
			'sql' => 'SQL Logs',
		),

		'modul_typy' => array(
			'administracyjny' => 'Administracyjny',
			'zwykly' => 'Zwykły',
			'jednorazowy' => 'Zwykły Jednorazowy',
			'blok' => 'Blok',
		),

		'sprawdz.typy_bledow' => array(
			'0' => 'not used in code',
			'1' => 'the same value',
			'2' => 'duplicate',
		),
	);
}

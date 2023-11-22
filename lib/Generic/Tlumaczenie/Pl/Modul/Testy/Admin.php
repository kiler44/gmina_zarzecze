<?php
namespace Generic\Tlumaczenie\Pl\Modul\Testy;

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

		'emailTestowy.blad.nie_mozna_wyslac_emaila' => 'Nie wysłano email\'a testowego',
		'emailTestowy.dane_email.zakladka' => 'Dane wiadomości testowej',
		'emailTestowy.debugInfo.zakladka' => 'Debug info',
		'emailTestowy.doEmail.etykieta' => 'Email odbiorcy',
		'emailTestowy.doEmail.opis' => '',
		'emailTestowy.doNazwa.etykieta' => 'Nazwa odbiorcy',
		'emailTestowy.doNazwa.opis' => '',
		'emailTestowy.info_wyslano_poprawnie' => 'Email testowy został wysłany poprawnie',
		'emailTestowy.odEmail.etykieta' => 'Email nadawcy',
		'emailTestowy.odEmail.opis' => '',
		'emailTestowy.odNazwa.etykieta' => 'Nazwa nadawcy',
		'emailTestowy.odNazwa.opis' => '',
		'emailTestowy.smtpDebug.etykieta' => 'SMTP Debug',
		'emailTestowy.smtpDebug.opis' => '',
		'emailTestowy.tresc.etykieta' => 'Treść',
		'emailTestowy.tresc.opis' => '',
		'emailTestowy.trescHtml.etykieta' => 'Treść HTML',
		'emailTestowy.trescHtml.opis' => '',
		'emailTestowy.tytul.etykieta' => 'Tytul',
		'emailTestowy.tytul.opis' => '',
		'emailTestowy.wstecz.wartosc' => 'Wstecz',
		'emailTestowy.zapisz.wartosc' => 'Wyślij',

		'index.etykieta_email_testowy' => 'Wyślij email testowy',
		'index.etykieta_link_logi' => 'Logi CMS-a',
		'index.etykieta_link_phpinfo' => 'Informacje o PHP',
		'index.etykieta_porownanie_konfiguracji' => 'Porównanie konfiguracji',
		'index.etykieta_reset_danych' => 'Reset danych systemu',
		'index.etykieta_resetuj_dane' => 'Zresetuj dane systemu',
		'index.etykieta_resetuj_dane_potwierdzenie' => 'Czy zresetować dane systemu?',
		'index.etykieta_resetuj_dane_potwierdzenie2' => 'Czy jesteś pewien?',
		'index.etykieta_sprawdz_katalogi' => 'Sprawdź katalogi',
		'index.etykieta_sprawdz_konfiguracje' => 'Sprawdź konfiguracje',
		'index.etykieta_sprawdz_tlumaczenia' => 'Sprawdź tłumczenia',
		'index.tytul_strony' => 'Testy i informacje',
		
		'index.etykieta_aktualizuj_produkty_zakupione_villa' => 'Aktualizuj zakupione Villa',
		'index.etykieta_aktualizuj_produkty_zakupione_b2b' => 'Aktualizuj zakupione B2B',

		'logi.etykieta_input_fraza' => 'Szukana fraza',
		'logi.etykieta_input_szukaj' => 'Szukaj',
		'logi.etykieta_input_typ' => 'Typ pliku',
		'logi.etykieta_nazwa' => 'Nazwa pliku',
		'logi.etykieta_select_wybierz' => '- wybierz -',
		'logi.tytul_strony' => 'Przeglądarka logów.',

		'phpinfo.tytul_strony' => 'Informacje o PHP',

		'porownajKonfiguracje.etykieta_edutuj_konfiguracje' => 'Edytuj konfiguacje',
		'porownajKonfiguracje.etykieta_klucz_konfiguracji' => 'Klucz Konfiguracji',
		'porownajKonfiguracje.etykieta_modul' => 'Moduł',
		'porownajKonfiguracje.etykieta_status' => 'Status',
		'porownajKonfiguracje.etykieta_wartosc_konfiguracji_bazowa' => 'Systemowa wartość',
		'porownajKonfiguracje.etykieta_wartosc_konfiguracji_wczytana' => 'Wczytana wartość',
		'porownajKonfiguracje.plik.etykieta' => 'Wyślij plik konfiguracji',
		'porownajKonfiguracje.plik.opis' => '',
		'porownajKonfiguracje.tytul_strony' => 'Porównanie konfiguracji',
		'porownajKonfiguracje.zapisz.wartosc' => 'Porównaj',

		'resetujDaneUzytkownikow.komunikat_blad' => 'Wystąpił błąd podczas operacji resetowania danych. Spróbuj ponownie.',
		'resetujDaneUzytkownikow.komunikat_wykonano' => 'Poprawnie zresetowano dane użytkowników<br />
			Zresetowanych loginów i haseł: {{ILE_LOGINOW}}<br />
			Zresetowanych telefonów: {{ILE_TELEFONOW}}<br />
			Zresetowanych klientów: {{ILE_KLIENCI}}<br />
			Zresetowanych PH: {{ILE_PRZEDSTAWICIELE}}<br />
			Zresetowanie danych SMS API: {{CZY_SMSAPI}}<br />
			Zresetowane nazwy nadawców emaili: {{ILE_WIERSZE}}<br />
			Zresetowanych odbiorców emaili: {{ILE_WIERSZE2}}<br />
			Zresetowanych odbiorców formularza kontaktowego: {{ILE_WIERSZE3}}<br />
			Zresetowanych uzytkowników SW: {{ILE_UZYTKOWNICY_SW}}',
		'resetujDaneUzytkownikow.komunikat_wykonano_SMSNIE' => 'Nie',
		'resetujDaneUzytkownikow.komunikat_wykonano_SMSTAK' => 'Zresetowano',

		'sprawdzKonfiguracje.etykieta_blad' => 'Typ błedu',
		'sprawdzKonfiguracje.etykieta_id_bloku' => 'Blok',
		'sprawdzKonfiguracje.etykieta_id_kategorii' => 'Kategoria',
		'sprawdzKonfiguracje.etykieta_klucz' => 'Klucz',
		'sprawdzKonfiguracje.etykieta_napraw' => 'Napraw konfigurację',
		'sprawdzKonfiguracje.etykieta_potwierdz_napraw' => 'Czy na pewno naprawić?',
		'sprawdzKonfiguracje.etykieta_potwierdz_usun_duplikaty' => 'Czy na pewno usunąć zduplikowane wpisy?',
		'sprawdzKonfiguracje.etykieta_usun_duplikaty' => 'Usuń zduplikowane wpisy',
		'sprawdzKonfiguracje.etykieta_wartosc' => 'Wartość',
		'sprawdzKonfiguracje.tytul_strony' => 'Sprawdzanie konfiguracji',

		'sprawdzTlumaczenia.etykieta_blad' => 'Typ błedu',
		'sprawdzTlumaczenia.etykieta_id_bloku' => 'Blok',
		'sprawdzTlumaczenia.etykieta_id_kategorii' => 'Kategoria',
		'sprawdzTlumaczenia.etykieta_klucz' => 'Klucz',
		'sprawdzTlumaczenia.etykieta_napraw' => 'Napraw tłumaczenia',
		'sprawdzTlumaczenia.etykieta_potwierdz_napraw' => 'Czy na pewno naprawić?',
		'sprawdzTlumaczenia.etykieta_potwierdz_usun_duplikaty' => 'Czy na pewno usunąć zduplikowane wpisy?',
		'sprawdzTlumaczenia.etykieta_usun_duplikaty' => 'Usuń zduplikowane wpisy',
		'sprawdzTlumaczenia.etykieta_wartosc' => 'Wartość',
		'sprawdzTlumaczenia.tytul_strony' => 'Sprawdzanie tłumaczeń',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajPodglad' => 'Podgląd',
			'wykonajPhpinfo' => 'Phpinfo',
			'wykonajLogi' => 'Logi',
			'wykonajResetujDaneUzytkownikow' => 'Ustawienie danych użytkowników na testowe - tylko Superadmin',
		),
		'emailTestowy.smtpDebug.wartosci' => array(
			'0' => 'Wyłączone',
			'1' => 'Tylko błędy',
			'2' => 'Błędy i komunikaty',
			'4' => 'Pełna komunikacja',
		),

		'logi.logi_typy' => array(
			'php' => 'Logi PHP',
			'sql' => 'Logi SQL',
		),

		'modul_typy' => array(
			'administracyjny' => 'Administracyjny',
			'zwykly' => 'Zwykły',
			'jednorazowy' => 'Zwykły Jednorazowy',
			'blok' => 'Blok',
		),

		'sprawdz.typy_bledow' => array(
			'0' => 'nie istnieje w modułach',
			'1' => 'wartość taka sama',
			'2' => 'duplikat w bazie',
		),
	);
}

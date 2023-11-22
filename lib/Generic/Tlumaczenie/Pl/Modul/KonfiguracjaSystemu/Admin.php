<?php
namespace Generic\Tlumaczenie\Pl\Modul\KonfiguracjaSystemu;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['administracyjne.tytul_strony']
 * @property string $t['czyscAdministracyjny.blad_modulu_nie_jest_administracyjny']
 * @property string $t['czyscAdministracyjny.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscAdministracyjny.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscAdministracyjny.info_usunieto_wiersze']
 * @property string $t['czyscBlok.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscBlok.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscBlok.blad_nieprawidlowy_blok']
 * @property string $t['czyscBlok.info_usunieto_wiersze']
 * @property string $t['czyscKategorie.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscKategorie.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscKategorie.blad_nieprawidlowa_kategoria']
 * @property string $t['czyscKategorie.info_usunieto_wiersze']
 * @property string $t['czyscSystem.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscSystem.info_usunieto_wiersze']
 * @property string $t['czyscZwykly.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['czyscZwykly.blad_modulu_nie_jest_zwykly']
 * @property string $t['czyscZwykly.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscZwykly.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscZwykly.info_usunieto_wiersze']
 * @property string $t['edytujAdministracyjny.blad_brak_uprawnien_do_modulu']
 * @property string $t['edytujAdministracyjny.blad_modulu_nie_jest_administracyjny']
 * @property string $t['edytujAdministracyjny.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujAdministracyjny.etykieta_link_czysc']
 * @property string $t['edytujAdministracyjny.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujAdministracyjny.tytul_strony']
 * @property string $t['edytujBlok.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujBlok.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujBlok.blad_nieprawidlowy_blok']
 * @property string $t['edytujBlok.etykieta_link_czysc']
 * @property string $t['edytujBlok.etykieta_pobierz_konfiguracje']
 * @property string $t['edytujBlok.etykieta_wczytaj_konfiguracje']
 * @property string $t['edytujBlok.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujBlok.tytul_strony']
 * @property string $t['edytujKategorie.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujKategorie.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujKategorie.blad_nieprawidlowa_kategoria']
 * @property string $t['edytujKategorie.etykieta_link_czysc']
 * @property string $t['edytujKategorie.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujKategorie.tytul_strony']
 * @property string $t['edytujZwykly.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujZwykly.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujZwykly.etykieta_link_czysc']
 * @property string $t['edytujZwykly.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujZwykly.tytul_strony']
 * @property string $t['formularz.etykieta_link_czysc']
 * @property string $t['formularz.etykieta_wstecz']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['index.etykieta_fraza']
 * @property string $t['index.etykieta_globalne']
 * @property string $t['index.etykieta_link_globalne']
 * @property string $t['index.etykieta_link_konfiguracja']
 * @property string $t['index.etykieta_link_konfiguracja_systemu_czysc']
 * @property string $t['index.etykieta_link_konfiguracja_systemu_czysc_potwierdzenie']
 * @property string $t['index.etykieta_link_moduly_administracyjne']
 * @property string $t['index.etykieta_link_moduly_zwykle']
 * @property string $t['index.etykieta_link_system']
 * @property string $t['index.etykieta_moduly_administracyjne']
 * @property string $t['index.etykieta_moduly_zwykle']
 * @property string $t['index.etykieta_system']
 * @property string $t['index.etykieta_szukaj']
 * @property string $t['index.etykieta_wyszukiwarka']
 * @property string $t['index.opis_globalne']
 * @property string $t['index.opis_moduly_administracyjne']
 * @property string $t['index.opis_moduly_zwykle']
 * @property string $t['index.opis_system']
 * @property string $t['index.tytul_strony']
 * @property string $t['modul.tytul_strony']
 * @property string $t['system.blad_nie_mozna_zapisac_wiersza']
 * @property string $t['system.error_nie_mozna_zapisac_wierszy']
 * @property string $t['system.info_zapisano_wiersze']
 * @property string $t['system.tytul_strony']
 * @property string $t['szukajFrazy.blad.fraza_zbyt_krotka']
 * @property string $t['szukajFrazy.etykieta_button_edytuj']
 * @property string $t['szukajFrazy.etykieta_dotyczy']
 * @property string $t['szukajFrazy.etykieta_dotyczy_bloku']
 * @property string $t['szukajFrazy.etykieta_dotyczy_globalne']
 * @property string $t['szukajFrazy.etykieta_dotyczy_kategorii']
 * @property string $t['szukajFrazy.etykieta_nazwa']
 * @property string $t['szukajFrazy.etykieta_wartosc']
 * @property string $t['szukajFrazy.naglowek_modulu']
 * @property string $t['szukajFrazy.nie_znaleziono']
 * @property string $t['szukajFrazy.tytul_strony']
 * @property string $t['tabela.etykieta_edytuj']
 * @property string $t['tabela.etykieta_input_czysc']
 * @property string $t['tabela.etykieta_input_fraza']
 * @property string $t['tabela.etykieta_input_szukaj']
 * @property string $t['tabela.etykieta_input_typ']
 * @property string $t['tabela.etykieta_nazwa']
 * @property string $t['tabela.etykieta_select_wybierz']
 * @property string $t['tabela.etykieta_typ']
 * @property string $t['wczytajKonfiguracje.blad_nie_wczytano_konfiguracji']
 * @property string $t['wczytajKonfiguracje.plik.etykieta']
 * @property string $t['wczytajKonfiguracje.plik.opis']
 * @property string $t['wczytajKonfiguracje.tytul_strony']
 * @property string $t['wczytajKonfiguracje.wczytano_konfiguracje']
 * @property string $t['wczytajKonfiguracje.zapisz.wartosc']
 * @property string $t['zmienneGlobalne.blad_kluczy']
 * @property string $t['zmienneGlobalne.blad_systemowe']
 * @property string $t['zmienneGlobalne.nie_zapisano']
 * @property string $t['zmienneGlobalne.opis_globalnych']
 * @property string $t['zmienneGlobalne.opis_globalnych_systemowych']
 * @property string $t['zmienneGlobalne.opis_globalnych_zarezerwowanych']
 * @property string $t['zmienneGlobalne.tablica_globalnych']
 * @property string $t['zmienneGlobalne.tablica_globalnych_systemowych']
 * @property string $t['zmienneGlobalne.tablica_globalnych_zarezerwowanych']
 * @property string $t['zmienneGlobalne.zapisano']
 * @property string $t['zwykle.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajSystem']
 * @property string $t['_akcje_etykiety_']['wykonajAdministracyjne']
 * @property string $t['_akcje_etykiety_']['wykonajZwykle']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujAdministracyjny']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujZwykly']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujKategorie']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujBlok']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscSystem']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscAdministracyjny']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscZwykly']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscKategorie']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscBlok']
 * @property string $t['_akcje_etykiety_']['wykonajZmienneGlobalne']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajWczytajKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajSzukajFrazy']
 * @property string $t['_akcje_etykiety_']['opcjeSystemowe']
 * @property array $t['modul_typy']
 * @property string $t['modul_typy']['administracyjny']
 * @property string $t['modul_typy']['zwykly']
 * @property string $t['modul_typy']['jednorazowy']
 * @property string $t['modul_typy']['blok']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'administracyjne.tytul_strony' => 'Moduły administracyjne',

		'czyscAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'Moduł nie jest administracyjny',
		'czyscAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscAdministracyjny.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić konfiguracji domyślnej dla modułu',
		'czyscAdministracyjny.info_usunieto_wiersze' => 'Przywrócono domyślną konfigurację modułu.',

		'czyscBlok.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscBlok.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić konfiguracji domyślnej dla bloku.',
		'czyscBlok.blad_nieprawidlowy_blok' => 'Nie można pobrać bloku',
		'czyscBlok.info_usunieto_wiersze' => 'Przywrócono domyślną konfigurację modułu dla bloku.',

		'czyscKategorie.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscKategorie.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić konfiguracji domyślnej dla kategorii.',
		'czyscKategorie.blad_nieprawidlowa_kategoria' => 'Nie można pobrać kategorii',
		'czyscKategorie.info_usunieto_wiersze' => 'Przywrócono domyślną konfigurację modułu dla kategorii.',

		'czyscSystem.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić konfiguracji domyślnej systemu.',
		'czyscSystem.info_usunieto_wiersze' => 'Przywrócono domyślną konfigurację dla systemu.',

		'czyscZwykly.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'czyscZwykly.blad_modulu_nie_jest_zwykly' => 'Moduł nie jest zwykły',
		'czyscZwykly.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscZwykly.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić konfiguracji domyślnej dla modułu.',
		'czyscZwykly.info_usunieto_wiersze' => 'Przywrócono domyślną konfigurację modułu.',

		'edytujAdministracyjny.blad_brak_uprawnien_do_modulu' => 'Brak uprawnień do modułu',
		'edytujAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'To nie jest moduł administracyjny',
		'edytujAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujAdministracyjny.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujAdministracyjny.info_modul_nie_posiada_konfiguracji' => 'Moduł nie posiada opcji konfiguracyjnych.',
		'edytujAdministracyjny.tytul_strony' => 'Konfiguracja modulu "%s"',

		'edytujBlok.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'edytujBlok.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujBlok.blad_nieprawidlowy_blok' => 'Nie można pobrać danych bloku.',
		'edytujBlok.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujBlok.etykieta_pobierz_konfiguracje' => 'Pobierz konfigurację',
		'edytujBlok.etykieta_wczytaj_konfiguracje' => 'Załaduj konfigurację z pliku',
		'edytujBlok.info_modul_nie_posiada_konfiguracji' => 'Moduł nie posiada opcji konfiguracyjnych.',
		'edytujBlok.tytul_strony' => 'Konfiguracja modulu dla bloku "%s"',

		'edytujKategorie.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'edytujKategorie.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujKategorie.blad_nieprawidlowa_kategoria' => 'Nie można pobrać kategorii.',
		'edytujKategorie.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujKategorie.info_modul_nie_posiada_konfiguracji' => 'Moduł nie posiada opcji konfiguracyjnych.',
		'edytujKategorie.tytul_strony' => 'Konfiguracja modulu dla kategorii "%s"',

		'edytujZwykly.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'edytujZwykly.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujZwykly.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujZwykly.info_modul_nie_posiada_konfiguracji' => 'Moduł nie posiada opcji konfiguracyjnych.',
		'edytujZwykly.tytul_strony' => 'Konfiguracja modulu "%s"',

		'formularz.etykieta_link_czysc' => 'Przywróć domyślną',
		'formularz.etykieta_wstecz' => 'Wstecz',
		'formularz.etykieta_zapisz' => 'Zapisz',

		'index.etykieta_fraza' => 'Szukana fraza',
		'index.etykieta_globalne' => 'Konfiguracja zmiennych globalnych',
		'index.etykieta_link_globalne' => 'Konfiguracja zmiennych globalnych',
		'index.etykieta_link_konfiguracja' => 'Pobierz konfigurację',
		'index.etykieta_link_konfiguracja_systemu_czysc' => 'Przywróć domyślną',
		'index.etykieta_link_konfiguracja_systemu_czysc_potwierdzenie' => 'Czy jesteś pewien, że chcesz przywrócić domyślną konfigurację?',
		'index.etykieta_link_moduly_administracyjne' => 'Lista modułów',
		'index.etykieta_link_moduly_zwykle' => 'Lista modułów',
		'index.etykieta_link_system' => 'Edycja konfiguracji',
		'index.etykieta_moduly_administracyjne' => 'Konfiguracja modułów administracyjnych',
		'index.etykieta_moduly_zwykle' => 'Konfiguracja modułów zwykłych',
		'index.etykieta_system' => 'Ustawienia systemu',
		'index.etykieta_szukaj' => 'Szukaj',
		'index.etykieta_wyszukiwarka' => 'Wyszukiwarka konfiguracji',
		'index.opis_globalne' => 'Konfigurowanie zmiennych do użycia na stronie.',
		'index.opis_moduly_administracyjne' => 'Konfiguracja modułów administracyjnych(Stuktura serwisu, użytkownicy, uprawnienia,...). Mogą one być ustawiane tylko tutaj.',
		'index.opis_moduly_zwykle' => 'Konfiguracja modułów zwykłych. Opcje ustawiane tutaj mogą być nadpisane w ustawieniach kategorii i bloków.',
		'index.opis_system' => 'Podstawowa konfiguracja systemu. Zawiera opcje konfiguracyjne dla obsługi błędów, sesji, uprawnień, poczty, itd.',
		'index.tytul_strony' => 'Konfiguracja CMS-a',

		'modul.tytul_strony' => 'Konfiguracja modułu %s',

		'system.blad_nie_mozna_zapisac_wiersza' => 'Nie można zapisać wiersza "%s"',
		'system.error_nie_mozna_zapisac_wierszy' => 'Nie można zapisać konfiguracji',
		'system.info_zapisano_wiersze' => 'Zmodyfikowano %d wierszy konfiguracji',
		'system.tytul_strony' => 'Konfiguracja systemu',

		'szukajFrazy.blad.fraza_zbyt_krotka' => 'Wpisana fraza jest zbyt krótka',
		'szukajFrazy.etykieta_button_edytuj' => 'Edytuj',
		'szukajFrazy.etykieta_dotyczy' => 'Dotyczy',
		'szukajFrazy.etykieta_dotyczy_bloku' => 'Bloku ',
		'szukajFrazy.etykieta_dotyczy_globalne' => 'Globalne',
		'szukajFrazy.etykieta_dotyczy_kategorii' => 'Kategorii ',
		'szukajFrazy.etykieta_nazwa' => 'Nazwa etykiety',
		'szukajFrazy.etykieta_wartosc' => 'Wartość',
		'szukajFrazy.naglowek_modulu' => '<span class="icon"><i class="icon-search"></i></span><h5>%s</h5>',
		'szukajFrazy.nie_znaleziono' => 'Nie znaleziono poszukiwanej frazy',
		'szukajFrazy.tytul_strony' => 'Wyniki wyszukiwania frazy "%s"',

		'tabela.etykieta_edytuj' => 'Edytuj',
		'tabela.etykieta_input_czysc' => 'Czyść',
		'tabela.etykieta_input_fraza' => 'Szukana fraza',
		'tabela.etykieta_input_szukaj' => 'Szukaj',
		'tabela.etykieta_input_typ' => 'Typ modułu',
		'tabela.etykieta_nazwa' => 'Nazwa modułu',
		'tabela.etykieta_select_wybierz' => '- wybierz -',
		'tabela.etykieta_typ' => 'Typ modułu',

		'wczytajKonfiguracje.blad_nie_wczytano_konfiguracji' => 'Nie udało się wczytać konfiguracji.',
		'wczytajKonfiguracje.plik.etykieta' => 'Wyślij plik konfiguracji',
		'wczytajKonfiguracje.plik.opis' => '',
		'wczytajKonfiguracje.tytul_strony' => 'Wczytanie konfiguracji',
		'wczytajKonfiguracje.wczytano_konfiguracje' => 'Wczytano poprawnie konfigurację.',
		'wczytajKonfiguracje.zapisz.wartosc' => 'Wczytaj',

		'zmienneGlobalne.blad_kluczy' => 'Nie można stosować zarezerwowanych kluczy w zmiennych użytkownika',
		'zmienneGlobalne.blad_systemowe' => 'Tablica zmiennych globalnych bądź systemowych nie zgadza się z oryginałem',
		'zmienneGlobalne.nie_zapisano' => 'Błąd podczas zapisu zmiennych globalnych.',
		'zmienneGlobalne.opis_globalnych' => 'Tablica zwierająca zmienne globalne w postaci $klucz => $wartosc. Wstaw {$klucz} na stronie by w tym miejscu pojawiła się wskazana wartość.',
		'zmienneGlobalne.opis_globalnych_systemowych' => 'Tablica zwierająca systemowe zmienne globalne w postaci $klucz => $wartosc. Wstaw {$klucz} na stronie by w tym miejscu pojawiła się wskazana wartość.',
		'zmienneGlobalne.opis_globalnych_zarezerwowanych' => 'Tablica zwierająca zarezerwowane zmienne globalne w postaci $klucz => $wartosc. Wstaw {$klucz} na stronie by w tym miejscu pojawiła się wskazana wartość.',
		'zmienneGlobalne.tablica_globalnych' => 'Zmienne globalne użytkownika',
		'zmienneGlobalne.tablica_globalnych_systemowych' => 'Systemowe zmienne globalne',
		'zmienneGlobalne.tablica_globalnych_zarezerwowanych' => 'Zarezerwowane zmienne globalne',
		'zmienneGlobalne.zapisano' => 'Lista zmiennych globalnych została zaktualizowana',

		'zwykle.tytul_strony' => 'Moduły przypisane do projektu',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Ekran startowy konfiguracji',
			'wykonajSystem' => 'Konfiguracja CMS-a',
			'wykonajAdministracyjne' => 'Lista modułów admnistracyjnych',
			'wykonajZwykle' => 'Lista modułów zwykłych',
			'wykonajEdytujAdministracyjny' => 'Ogólna edycja modułu administracyjnego',
			'wykonajEdytujZwykly' => 'Ogólna edycja modułu zwykłego',
			'wykonajEdytujKategorie' => 'Edycja modułu zwykłego dla podstrony',
			'wykonajEdytujBlok' => 'Edycja modułu zwykłego dla bloku',
			'wykonajCzyscSystem' => 'Przywrócenie domyślnych dla CMS-a',
			'wykonajCzyscAdministracyjny' => 'Przywrócenie domyślnych dla modułu administracyjego',
			'wykonajCzyscZwykly' => 'Przywrócenie domyślnych dla modułu zwykłego',
			'wykonajCzyscKategorie' => 'Przywrócenie domyślnych dla podstrony',
			'wykonajCzyscBlok' => 'Przywrócenie domyślnych dla bloku',
			'wykonajZmienneGlobalne' => 'Zmienne Globalne',
			'wykonajPobierzKonfiguracje' => 'Pobranie konfiguracji',
			'wykonajWczytajKonfiguracje' => 'Wczytanie konfiguracji',
			'wykonajSzukajFrazy' => 'Wyszukiwanie konfiguracji w systemie',
			'opcjeSystemowe' => 'Edycja opcji zastrzeżonych',
		),

		'modul_typy' => array(
			'administracyjny' => 'Administracyjny',
			'zwykly' => 'Zwykły',
			'jednorazowy' => 'Zwykły Jednorazowy',
			'blok' => 'Blok',
		),
	);
}

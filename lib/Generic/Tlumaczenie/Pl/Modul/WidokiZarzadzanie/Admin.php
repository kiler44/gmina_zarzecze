<?php
namespace Generic\Tlumaczenie\Pl\Modul\WidokiZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['blok.etykieta_link_edytuj']
 * @property string $t['blok.etykieta_link_tresc']
 * @property string $t['blok.etykieta_link_usun']
 * @property string $t['bloki.etykieta_edytuj']
 * @property string $t['bloki.etykieta_edytuj_tresc']
 * @property string $t['bloki.etykieta_input_szablon']
 * @property string $t['bloki.etykieta_kod_modulu']
 * @property string $t['bloki.etykieta_kontener']
 * @property string $t['bloki.etykieta_link_dodaj']
 * @property string $t['bloki.etykieta_nazwa']
 * @property string $t['bloki.etykieta_potwierdz_usun']
 * @property string $t['bloki.etykieta_usun']
 * @property string $t['bloki.tytul_strony']
 * @property string $t['dodaj.blad_nazwa_zajeta']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_widoku']
 * @property string $t['dodaj.info_zapisano_dane_widoku']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['dodajBlok.blad_nazwa_zajeta']
 * @property string $t['dodajBlok.blad_nie_mozna_zapisac_bloku']
 * @property string $t['dodajBlok.info_zapisano_dane_bloku']
 * @property string $t['dodajBlok.tytul_strony']
 * @property string $t['edytuj.blad_brak_widoku']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_widoku']
 * @property string $t['edytuj.etykieta_link_dodaj']
 * @property string $t['edytuj.info_widok_domyslny']
 * @property string $t['edytuj.info_widok_edytowany']
 * @property string $t['edytuj.info_zapisano_dane_widoku']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['edytujBlok.blad_brak_bloku']
 * @property string $t['edytujBlok.blad_nie_mozna_zapisac_bloku']
 * @property string $t['edytujBlok.etykieta_link_konfiguracja']
 * @property string $t['edytujBlok.etykieta_link_tlumaczenia']
 * @property string $t['edytujBlok.info_zapisano_dane_bloku']
 * @property string $t['edytujBlok.tytul_strony']
 * @property string $t['formularz.cache.etykieta']
 * @property string $t['formularz.cache.opis']
 * @property string $t['formularz.cacheCzas.etykieta']
 * @property string $t['formularz.cacheCzas.opis']
 * @property string $t['formularz.czysc.wartosc']
 * @property string $t['formularz.etykieta_kategoria']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.klasa.etykieta']
 * @property string $t['formularz.klasa.opis']
 * @property string $t['formularz.kodModulu.etykieta']
 * @property string $t['formularz.kodModulu.opis']
 * @property string $t['formularz.kontener.etykieta']
 * @property string $t['formularz.kontener.opis']
 * @property string $t['formularz.kopiowanyWidok.etykieta']
 * @property string $t['formularz.kopiowanyWidok.opis']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.nazwa.opis']
 * @property string $t['formularz.podglad.etykieta']
 * @property string $t['formularz.podglad.opis']
 * @property string $t['formularz.szablon.etykieta']
 * @property string $t['formularz.szablon.opis']
 * @property string $t['formularz.ukladStrony.etykieta']
 * @property string $t['formularz.ukladStrony.opis']
 * @property string $t['formularz.widoki.etykieta']
 * @property string $t['formularz.widoki.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_bloki']
 * @property string $t['index.etykieta_link_bloki']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_link_edytuj']
 * @property string $t['index.etykieta_link_pobierz_konfiguracje']
 * @property string $t['index.etykieta_link_usun']
 * @property string $t['index.etykieta_link_wczytaj_konfiguracje']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_ukladStrony']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.etykieta_budowanie_ukladu']
 * @property string $t['trescBloku.blad_brak_bloku']
 * @property string $t['usun.blad_brak_widoku']
 * @property string $t['usun.blad_nie_mozna_usunac_widoku']
 * @property string $t['usun.blad_przypisane_kategorie']
 * @property string $t['usun.info_usunieto_widok']
 * @property string $t['usunBlok.blad_brak_bloku']
 * @property string $t['usunBlok.blad_istnieja_widoki_zawierajace']
 * @property string $t['usunBlok.blad_nie_mozna_usunac_bloku']
 * @property string $t['usunBlok.info_usunieto_blok']
 * @property string $t['wczytajKonfiguracje.blad_nie_wczytano_konfiguracji']
 * @property string $t['wczytajKonfiguracje.etykieta_potwierdz_wczytanie_konfiguracji']
 * @property string $t['wczytajKonfiguracje.niepoprawny_plik']
 * @property string $t['wczytajKonfiguracje.plik.etykieta']
 * @property string $t['wczytajKonfiguracje.plik.opis']
 * @property string $t['wczytajKonfiguracje.tytul_strony']
 * @property string $t['wczytajKonfiguracje.wczytano_konfiguracje']
 * @property string $t['wczytajKonfiguracje.wstecz.wartosc']
 * @property string $t['wczytajKonfiguracje.zapisz.wartosc']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajAktualizuj']
 * @property string $t['_akcje_etykiety_']['wykonajBloki']
 * @property string $t['_akcje_etykiety_']['wykonajDodajBlok']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujBlok']
 * @property string $t['_akcje_etykiety_']['wykonajUsunBlok']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajWczytajKonfiguracje']
 * @property array $t['bloki.cache_przedzialy_czasowe']
 * @property string $t['bloki.cache_przedzialy_czasowe']['0']
 * @property string $t['bloki.cache_przedzialy_czasowe']['60']
 * @property string $t['bloki.cache_przedzialy_czasowe']['300']
 * @property string $t['bloki.cache_przedzialy_czasowe']['900']
 * @property string $t['bloki.cache_przedzialy_czasowe']['1800']
 * @property string $t['bloki.cache_przedzialy_czasowe']['3600']
 * @property string $t['bloki.cache_przedzialy_czasowe']['86400']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'blok.etykieta_link_edytuj' => 'Edytuj blok',
		'blok.etykieta_link_tresc' => 'Edytuj treść',
		'blok.etykieta_link_usun' => 'Usuń blok',
		'bloki.etykieta_edytuj' => 'Edytuj blok',
		'bloki.etykieta_edytuj_tresc' => 'Edytuj treść bloku',
		'bloki.etykieta_input_szablon' => 'Szablon',
		'bloki.etykieta_kod_modulu' => 'Moduł',
		'bloki.etykieta_kontener' => 'Kontener',
		'bloki.etykieta_link_dodaj' => 'Dodaj blok',
		'bloki.etykieta_nazwa' => 'Nazwa bloku',
		'bloki.etykieta_potwierdz_usun' => 'Czy chcesz usunąć zaznaczony blok?',
		'bloki.etykieta_usun' => 'Usuń blok',
		'bloki.tytul_strony' => 'Zarzadzanie blokami',

		'buduj.tytul_strony' => 'Budowanie układu strony',
		
		
		'dodaj.blad_nazwa_zajeta' => 'Wybrana nazwa jest już zajęta',
		'dodaj.blad_nie_mozna_zapisac_widoku' => 'Nie można zapisać danych układu strony!',
		'dodaj.info_zapisano_dane_widoku' => 'Zapisano dane układu strony',
		'dodaj.tytul_strony' => 'Nowy układ strony',

		'dodajBlok.blad_nazwa_zajeta' => 'Wybrana nazwa jest już zajęta',
		'dodajBlok.blad_nie_mozna_zapisac_bloku' => 'Nie można zapisać danych bloku!',
		'dodajBlok.info_zapisano_dane_bloku' => 'Dodano nowy blok',
		'dodajBlok.tytul_strony' => 'Dodawanie nowego bloku',

		'edytuj.blad_brak_widoku' => 'Nie można pobrać danych układu strony',
		'edytuj.blad_nie_mozna_zapisac_widoku' => 'Nie można zapisać danych układu strony!',
		'edytuj.etykieta_link_dodaj' => 'Dodaj blok',
		'edytuj.info_widok_domyslny' => 'Przywrócono domyślne ustawienie dla tego układu strony',
		'edytuj.info_widok_edytowany' => 'Układ strony w trakcie edycji. Wygląd różni się od zapisanego w bazie.',
		'edytuj.info_zapisano_dane_widoku' => 'Zaktualizowano dane układu strony',
		'edytuj.tytul_strony' => 'Edycja układu strony',

		'edytujBlok.blad_brak_bloku' => 'Nie można pobrać danych bloku',
		'edytujBlok.blad_nie_mozna_zapisac_bloku' => 'Nie można zapisać danych bloku!',
		'edytujBlok.etykieta_link_konfiguracja' => 'Konfiguracja modułu dla bloku',
		'edytujBlok.etykieta_link_tlumaczenia' => 'Tłumaczenia dla bloku',
		'edytujBlok.info_zapisano_dane_bloku' => 'Zaktualizowano dane bloku',
		'edytujBlok.tytul_strony' => 'Edycja bloku',

		'formularz.cache.etykieta' => 'Włączyć cache dla bloku',
		'formularz.cache.opis' => '',
		'formularz.cacheCzas.etykieta' => 'Czas odświeżania cache',
		'formularz.cacheCzas.opis' => 'Co jaki czas wygenerowany cache ma się odświeżać',
		'formularz.czysc.wartosc' => 'Anuluj zmiany',
		'formularz.etykieta_kategoria' => 'Główna treść strony',
		'formularz.etykieta_select_wybierz' => ' - wybierz - ',
		'formularz.klasa.etykieta' => 'Klasa',
		'formularz.klasa.opis' => '',
		'formularz.kodModulu.etykieta' => 'Moduł',
		'formularz.kodModulu.opis' => '',
		'formularz.kontener.etykieta' => 'Kontener',
		'formularz.kontener.opis' => '',
		'formularz.kopiowanyWidok.etykieta' => 'Kopiowanie z układu strony',
		'formularz.kopiowanyWidok.opis' => 'Jeżeli to pole zostanie ustawione dane(oprócz nazwy) zostaną skopiowane zwybranego układu strony',
		'formularz.nazwa.etykieta' => 'Nazwa',
		'formularz.nazwa.opis' => '',
		'formularz.podglad.etykieta' => 'Podgląd',
		'formularz.podglad.opis' => 'Podgląd edytowanego układu na wybranej podstronie',
		'formularz.szablon.etykieta' => 'Szablon',
		'formularz.szablon.opis' => '',
		'formularz.ukladStrony.etykieta' => 'Szablon',
		'formularz.ukladStrony.opis' => '',
		'formularz.widoki.etykieta' => 'Widoki powiązane',
		'formularz.widoki.opis' => '',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'index.etykieta_bloki' => 'Użyte bloki',
		'index.etykieta_link_bloki' => 'Zarządzanie blokami',
		'index.etykieta_link_dodaj' => 'Dodaj układ strony',
		'index.etykieta_link_edytuj' => 'Edytuj widok',
		'index.etykieta_link_pobierz_konfiguracje' => 'Pobierz konfigurację',
		'index.etykieta_link_usun' => 'Usuń widok',
		'index.etykieta_link_wczytaj_konfiguracje' => 'Załaduj konfigurację z pliku',
		'index.etykieta_nazwa' => 'Nazwa układu strony',
		'index.etykieta_ukladStrony' => 'Szablon',
		'index.tytul_strony' => 'Zarzadzanie układami stron',
		'index.etykieta_budowanie_ukladu' => 'Zbuduj układ strony',

		'trescBloku.blad_brak_bloku' => 'Nie można pobrać danych bloku',

		'usun.blad_brak_widoku' => 'Nie można pobrać danych układu strony',
		'usun.blad_nie_mozna_usunac_widoku' => 'Nie można usunąć układu strony!',
		'usun.blad_przypisane_kategorie' => 'Nie można usunąć ponieważ układ strony jest używany przez podstrony: %s',
		'usun.info_usunieto_widok' => 'Układ strony został usunięty',

		'usunBlok.blad_brak_bloku' => 'Nie można pobrać danych bloku',
		'usunBlok.blad_istnieja_widoki_zawierajace' => 'Istnieją widoki zawierające blok: %s',
		'usunBlok.blad_nie_mozna_usunac_bloku' => 'Nie można usunąć bloku!',
		'usunBlok.info_usunieto_blok' => 'Blok został usunięty',

		'wczytajKonfiguracje.blad_nie_wczytano_konfiguracji' => '<h3>Nie udało się poprawnie zaimportować konfiguracji widoków.<h3>',
		'wczytajKonfiguracje.etykieta_potwierdz_wczytanie_konfiguracji' => 'Czy napewno zaimportować konfigurację widoków z pliku?',
		'wczytajKonfiguracje.niepoprawny_plik' => 'Plik do importu konfiguracji widoków jest nieprawidłow.',
		'wczytajKonfiguracje.plik.etykieta' => 'Wyślij plik konfiguracji',
		'wczytajKonfiguracje.plik.opis' => '',
		'wczytajKonfiguracje.tytul_strony' => 'Wczytanie konfiguracji',
		'wczytajKonfiguracje.wczytano_konfiguracje' => '<h3>Udało się poprawnie zaimportować konfigurację widoków.<h3>',
		'wczytajKonfiguracje.wstecz.wartosc' => 'Wstecz',
		'wczytajKonfiguracje.zapisz.wartosc' => 'Wczytaj',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie listy układów stron',
			'wykonajDodaj' => 'Dodawanie układu strony',
			'wykonajEdytuj' => 'Edycja układu strony',
			'wykonajUsun' => 'Usuwanie układu strony',
			'wykonajAktualizuj' => 'Aktualizacja układu do podglądu',
			'wykonajBloki' => 'Zarządzanie dodatkowymi blokami',
			'wykonajDodajBlok' => 'Dodawanie bloku',
			'wykonajEdytujBlok' => 'Edycja bloku',
			'wykonajUsunBlok' => 'Usuwanie bloku',
			'wykonajPobierzKonfiguracje' => 'Pobranie konfiguracji widoków',
			'wykonajWczytajKonfiguracje' => 'Zaimportowanie konfiguracji widoków',
		),

		'bloki.cache_przedzialy_czasowe' => array(
			'0' => 'Brak limitu',
			'60' => '1 minuta',
			'300' => '5 minut',
			'900' => '15 minut',
			'1800' => '30 minut',
			'3600' => '1 godzina',
			'86400' => '24 godziny',
		),
		
		'gridster' => array(
			'zapisano_uklad' => 'Układ został zapisany',
			'niezapisano_uklad' => 'Nie zapisano układu',
			'blad' => 'Wystąpił błąd działania gridstera',
		),
	);
}

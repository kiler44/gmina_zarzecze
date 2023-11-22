<?php
namespace Generic\Tlumaczenie\Pl\Modul\KategorieZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['czysc.blad_nie mozna_usunac_drzewa_kategorii']
 * @property string $t['czysc.info_usunieto_drzewo_kategorii']
 * @property string $t['czyscStaryUrl.blad_nie_wyczyszczono_url']
 * @property string $t['czyscStaryUrl.info_wyczyszczono_url']
 * @property string $t['dodaj.blad_brak_kategorii_nadrzednej']
 * @property string $t['dodaj.blad_kod_zajety']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_kategorii']
 * @property string $t['dodaj.info_zapisano_dane_kategorii']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_kategorii']
 * @property string $t['edytuj.blad_kod_kategorii_zajety']
 * @property string $t['edytuj.blad_nie_mozna_edytowac_kategorii']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_kategorii']
 * @property string $t['edytuj.info_zapisano_dane_kategorii']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.adresZewnetrzny.etykieta']
 * @property string $t['formularz.adresZewnetrzny.opis']
 * @property string $t['formularz.akcjaKlasa.etykieta']
 * @property string $t['formularz.akcjaKlasa.opis']
 * @property string $t['formularz.akcjaKontener.etykieta']
 * @property string $t['formularz.akcjaKontener.opis']
 * @property string $t['formularz.akcjaSzablon.etykieta']
 * @property string $t['formularz.akcjaSzablon.opis']
 * @property string $t['formularz.akcjaUkladStrony.etykieta']
 * @property string $t['formularz.akcjaUkladStrony.opis']
 * @property string $t['formularz.blad_nie_przypisano_modulow_do_projektu']
 * @property string $t['formularz.blad_nie_utworzono_widokow']
 * @property string $t['formularz.blokada.etykieta']
 * @property string $t['formularz.blokada.opis']
 * @property string $t['formularz.cache.etykieta']
 * @property string $t['formularz.cache.opis']
 * @property string $t['formularz.czasCache.etykieta']
 * @property string $t['formularz.czasCache.opis']
 * @property string $t['formularz.czyWidoczna.etykieta']
 * @property string $t['formularz.czyWidoczna.opis']
 * @property string $t['formularz.czyscStaryUrl.wartosc']
 * @property string $t['formularz.dlaZalogowanych.etykieta']
 * @property string $t['formularz.dlaZalogowanych.opis']
 * @property string $t['formularz.etykietaCzysc.etykieta']
 * @property string $t['formularz.etykieta_powrot']
 * @property string $t['formularz.etykieta_region_widok_kategoria']
 * @property string $t['formularz.etykieta_region_widoki_akcje']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_zakladka_kategoria']
 * @property string $t['formularz.etykieta_zakladka_seo']
 * @property string $t['formularz.etykieta_zakladka_wyglad']
 * @property string $t['formularz.idKategorii.etykieta']
 * @property string $t['formularz.idKategorii.opis']
 * @property string $t['formularz.idWidokuZbiorowy.etykieta']
 * @property string $t['formularz.idWidokuZbiorowy.opis']
 * @property string $t['formularz.klasa.etykieta']
 * @property string $t['formularz.klasa.opis']
 * @property string $t['formularz.kodGeneruj.wartosc']
 * @property string $t['formularz.kodKontener.etykieta']
 * @property string $t['formularz.kodKontener.opis']
 * @property string $t['formularz.kodModulu.etykieta']
 * @property string $t['formularz.kodModulu.opis']
 * @property string $t['formularz.kontener.etykieta']
 * @property string $t['formularz.kontener.opis']
 * @property string $t['formularz.link.etykieta']
 * @property string $t['formularz.link.opis']
 * @property string $t['formularz.naglowekHtml.etykieta']
 * @property string $t['formularz.naglowekHtml.opis']
 * @property string $t['formularz.naglowekHttp.etykieta']
 * @property string $t['formularz.naglowekHttp.opis']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.nazwaPrzyjaznaKontener.etykieta']
 * @property string $t['formularz.nazwaPrzyjaznaKontener.opis']
 * @property string $t['formularz.nazwaPrzyjaznaPobierz.wartosc']
 * @property string $t['formularz.nazwa_przyjazna.etykieta']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.opis.opis']
 * @property string $t['formularz.pelnyLink.etykieta']
 * @property string $t['formularz.pelnyLink.opis']
 * @property string $t['formularz.poprawLink.wartosc']
 * @property string $t['formularz.przekieruj.wartosc']
 * @property string $t['formularz.rssWlaczony.etykieta']
 * @property string $t['formularz.rssWlaczony.opis']
 * @property string $t['formularz.skrypt.etykieta']
 * @property string $t['formularz.skrypt.opis']
 * @property string $t['formularz.slowaKluczowe.etykieta']
 * @property string $t['formularz.slowaKluczowe.opis']
 * @property string $t['formularz.staryUrlZbiorowy.etykieta']
 * @property string $t['formularz.staryUrlZbiorowy.opis']
 * @property string $t['formularz.szablon.etykieta']
 * @property string $t['formularz.szablon.opis']
 * @property string $t['formularz.typ.etykieta']
 * @property string $t['formularz.typ.opis']
 * @property string $t['formularz.tytulStrony.etykieta']
 * @property string $t['formularz.tytulStrony.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wymagaHttps.etykieta']
 * @property string $t['formularz.wymagaHttps.opis']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_link_edytuj']
 * @property string $t['index.etykieta_link_pobierz_konfiguracje']
 * @property string $t['index.etykieta_link_przebudowa']
 * @property string $t['index.etykieta_link_przekierowania']
 * @property string $t['index.etykieta_link_sortowanie']
 * @property string $t['index.etykieta_link_tresc']
 * @property string $t['index.etykieta_link_usun']
 * @property string $t['index.etykieta_link_usun_pytanie']
 * @property string $t['index.etykieta_link_usun_wszystkie']
 * @property string $t['index.etykieta_link_usun_wszystkie_pytanie']
 * @property string $t['index.etykieta_link_wczytaj_konfiguracje']
 * @property string $t['index.etykieta_nazwa_kategorii']
 * @property string $t['index.info_nie_dodano_kategorii']
 * @property string $t['index.tytul_strony']
 * @property string $t['kategoria.etykieta_typ_glowna']
 * @property string $t['kategoria.etykieta_typ_kategoria']
 * @property string $t['kategoria.etykieta_typ_link_wewnetrzny']
 * @property string $t['kategoria.etykieta_typ_link_zewnetrzny']
 * @property string $t['kategoria.etykieta_typ_menu']
 * @property string $t['przebudowa.info_nie_mozna_przebudowac_adresow_url']
 * @property string $t['przebudowa.info_nie_mozna_przebudowac_adresu_url']
 * @property string $t['przebudowa.info_nie_utworzono_jeszcze_kategorii']
 * @property string $t['przebudowa.info_przebudowano_adres_url']
 * @property string $t['przebudowa.info_przebudowano_adresy_url']
 * @property string $t['sortowanie.blad_nie_mozna_pobrac_kategorii']
 * @property string $t['sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii']
 * @property string $t['sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii']
 * @property string $t['sortowanie.blad_niepelne_dane_kategorii']
 * @property string $t['sortowanie.blad_nieprawidlowe_dane_kategorii']
 * @property string $t['sortowanie.blad_nieprawidlowe_dane_sasiada']
 * @property string $t['sortowanie.blad_nieprawidlowe_oznaczenie_polozenia']
 * @property string $t['sortowanie.info_zmieniono_rodzica_kategorii']
 * @property string $t['sortowanie.info_zmieniono_ustawienie_kategorii']
 * @property string $t['sortowanie.tytul_strony']
 * @property string $t['usun.blad_brak_kategorii']
 * @property string $t['usun.blad_nie_mozna_usunac_kategorii']
 * @property string $t['usun.info_usunieto_kategorie']
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
 * @property string $t['_akcje_etykiety_']['wykonajSortowanie']
 * @property string $t['_akcje_etykiety_']['wykonajCzysc']
 * @property string $t['_akcje_etykiety_']['wykonajPrzebudowa']
 * @property string $t['_akcje_etykiety_']['wykonajPoprawUrl']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscStaryUrl']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajWczytajKonfiguracje']
 * @property array $t['formularz.cache_przedzialy_czasowe']
 * @property string $t['formularz.cache_przedzialy_czasowe']['0']
 * @property string $t['formularz.cache_przedzialy_czasowe']['60']
 * @property string $t['formularz.cache_przedzialy_czasowe']['300']
 * @property string $t['formularz.cache_przedzialy_czasowe']['900']
 * @property string $t['formularz.cache_przedzialy_czasowe']['1800']
 * @property string $t['formularz.cache_przedzialy_czasowe']['3600']
 * @property string $t['formularz.cache_przedzialy_czasowe']['14400']
 * @property string $t['formularz.cache_przedzialy_czasowe']['86400']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'czysc.blad_nie mozna_usunac_drzewa_kategorii' => 'Nie można usunąć struktury serwisu',
		'czysc.info_usunieto_drzewo_kategorii' => 'Usunięto całą strukturę serwisu',

		'czyscStaryUrl.blad_nie_wyczyszczono_url' => 'Nie udało się usunąć starego url-a.',
		'czyscStaryUrl.info_wyczyszczono_url' => 'Wyczyszczono stary url.',

		'dodaj.blad_brak_kategorii_nadrzednej' => 'Nie określono strony nadrzędnej',
		'dodaj.blad_kod_zajety' => 'Wybrany kod jest już zajęty',
		'dodaj.blad_nie_mozna_zapisac_kategorii' => 'Nie można zapisać danych strony!',
		'dodaj.info_zapisano_dane_kategorii' => 'Dodano nową strony',
		'dodaj.tytul_strony' => 'Nowa strona',

		'edytuj.blad_brak_kategorii' => 'Nie można pobrać danych strony',
		'edytuj.blad_kod_kategorii_zajety' => 'Kod dla strony jest już zajęty przez inną',
		'edytuj.blad_nie_mozna_edytowac_kategorii' => 'Nie można edytować strony',
		'edytuj.blad_nie_mozna_zapisac_kategorii' => 'Nie można zapisać danych strony',
		'edytuj.info_zapisano_dane_kategorii' => 'Zaktualizowano dane strony',
		'edytuj.tytul_strony' => 'Edycja strony',

		'formularz.adresZewnetrzny.etykieta' => 'Adres Http',
		'formularz.adresZewnetrzny.opis' => '',
		'formularz.akcjaKlasa.etykieta' => 'Przypisz klasę do akcji',
		'formularz.akcjaKlasa.opis' => '',
		'formularz.akcjaKontener.etykieta' => 'Przypisz kontener do akcji',
		'formularz.akcjaKontener.opis' => '',
		'formularz.akcjaSzablon.etykieta' => 'Przypisz szablon do akcji',
		'formularz.akcjaSzablon.opis' => '',
		'formularz.akcjaUkladStrony.etykieta' => 'Przypisz układ strony do akcji',
		'formularz.akcjaUkladStrony.opis' => '',
		'formularz.blad_nie_przypisano_modulow_do_projektu' => 'Brak dostępnych modułów. Sprawdź ustawienia projektu.',
		'formularz.blad_nie_utworzono_widokow' => 'Nie utworzono jeszcze żadnych układów strony. Należy utworzyć przynajmniej jeden układ strony.',
		'formularz.blokada.etykieta' => 'Blokada wyświetlania',
		'formularz.blokada.opis' => '',
		'formularz.cache.etykieta' => 'Cache dla kategorii',
		'formularz.cache.opis' => 'Czy włączyć cache dla danej kategorii',
		'formularz.czasCache.etykieta' => 'Co ile odświeżać cache',
		'formularz.czasCache.opis' => 'Czas po jakim cache ma być odświeżony',
		'formularz.czyWidoczna.etykieta' => 'Widoczna w menu',
		'formularz.czyWidoczna.opis' => '',
		'formularz.czyscStaryUrl.wartosc' => 'Czyść',
		'formularz.dlaZalogowanych.etykieta' => 'Dla zalgowanych',
		'formularz.dlaZalogowanych.opis' => 'Tylko dla zalogowanych użytkowników',
		'formularz.etykietaCzysc.etykieta' => '',
		'formularz.etykieta_powrot' => 'Powrót do listy kategorii',
		'formularz.etykieta_region_widok_kategoria' => 'Widok dla kategorii',
		'formularz.etykieta_region_widoki_akcje' => 'Widoki dla akcji',
		'formularz.etykieta_select_wybierz' => ' - wybierz - ',
		'formularz.etykieta_zakladka_kategoria' => 'Kategoria',
		'formularz.etykieta_zakladka_seo' => 'SEO',
		'formularz.etykieta_zakladka_wyglad' => 'Wygląd',
		'formularz.idKategorii.etykieta' => 'Podstrona docelowa',
		'formularz.idKategorii.opis' => '',
		'formularz.idWidokuZbiorowy.etykieta' => 'Układ strony',
		'formularz.idWidokuZbiorowy.opis' => '',
		'formularz.klasa.etykieta' => 'Klasa',
		'formularz.klasa.opis' => '',
		'formularz.kodGeneruj.wartosc' => 'Generuj',
		'formularz.kodKontener.etykieta' => 'Kod url',
		'formularz.kodKontener.opis' => '',
		'formularz.kodModulu.etykieta' => 'Moduł',
		'formularz.kodModulu.opis' => '',
		'formularz.kontener.etykieta' => 'Kontener dla treści',
		'formularz.kontener.opis' => '',
		'formularz.link.etykieta' => 'Pełny link',
		'formularz.link.opis' => '',
		'formularz.naglowekHtml.etykieta' => 'Nagłówek strony',
		'formularz.naglowekHtml.opis' => 'Dodatkowe treści w nagłówku html strony (head)',
		'formularz.naglowekHttp.etykieta' => 'Nagłówki HTTP',
		'formularz.naglowekHttp.opis' => '<strong>Uwaga!!! Należy używać bardzo ostrożnie.</strong> Podawaj nagłówki które chcesz ustawić w kolejnych wierszach.',
		'formularz.nazwa.etykieta' => 'Nazwa w menu',
		'formularz.nazwaPrzyjaznaKontener.etykieta' => 'Nazwa dla administratora',
		'formularz.nazwaPrzyjaznaKontener.opis' => 'Nazwa, która będzie się wyświetlała tylko w panelu administracyjnym',
		'formularz.nazwaPrzyjaznaPobierz.wartosc' => 'Skopiuj z tytułu',
		'formularz.nazwa_przyjazna.etykieta' => '',
		'formularz.ikona.etykieta' => 'Ikona',
		'formularz.ikona.opis' => '',
		'formularz.opis.etykieta' => 'Opis',
		'formularz.opis.opis' => '',
		'formularz.pelnyLink.etykieta' => '',
		'formularz.pelnyLink.opis' => '',
		'formularz.poprawLink.wartosc' => 'Popraw link',
		'formularz.przekieruj.wartosc' => 'Przejdź do edycji',
		'formularz.rssWlaczony.etykieta' => 'Publikuj kanał RSS dla podstrony',
		'formularz.rssWlaczony.opis' => '',
		'formularz.skrypt.etykieta' => 'Dodatkowy skrypt na stronie',
		'formularz.skrypt.opis' => 'Dodatkowy skrypt doklejany do stopki',
		'formularz.slowaKluczowe.etykieta' => 'Słowa kluczowe',
		'formularz.slowaKluczowe.opis' => '',
		'formularz.staryUrlZbiorowy.etykieta' => 'Stary url (podgląd)',
		'formularz.staryUrlZbiorowy.opis' => 'Ta opcja nie działa jeszcze w pełni. Brak przekierowań ze starego url-a na nowy. Bedzie poprawione w przyszłości.',
		'formularz.szablon.etykieta' => 'Szablon',
		'formularz.szablon.opis' => '',
		'formularz.typ.etykieta' => 'Typ',
		'formularz.typ.opis' => '',
		'formularz.tytulStrony.etykieta' => 'Tytuł strony',
		'formularz.tytulStrony.opis' => '',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.wymagaHttps.etykieta' => 'Wymaga HTTPS',
		'formularz.wymagaHttps.opis' => '',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'index.etykieta_link_dodaj' => 'Dodaj podstronę',
		'index.etykieta_link_edytuj' => 'Edytuj stronę',
		'index.etykieta_link_pobierz_konfiguracje' => 'Pobierz konfigurację',
		'index.etykieta_link_przebudowa' => 'Poprawienie adresów url',
		'index.etykieta_link_przekierowania' => 'Przekierowanie adresów url',
		'index.etykieta_link_sortowanie' => 'Sortowanie stron',
		'index.etykieta_link_tresc' => 'Edytuj treść strony',
		'index.etykieta_link_usun' => 'Usuń stronę',
		'index.etykieta_link_usun_pytanie' => 'Czy na pewno chcesz usunąć tą stronę i wszystkie podległe?',
		'index.etykieta_link_usun_wszystkie' => 'Czyść wszystkie strony',
		'index.etykieta_link_usun_wszystkie_pytanie' => 'Czy na pewno chcesz usunąć wszystkie strony z serwisu?',
		'index.etykieta_link_wczytaj_konfiguracje' => 'Załaduj konfigurację z pliku',
		'index.etykieta_nazwa_kategorii' => 'Nazwa podstrony',
		'index.info_nie_dodano_kategorii' => 'Nie dodano żadnych podstron w serwisie. Aby poprawnie zainicjować strukturę serwisu użyj przycisku "Czyść wszystkie strony"',
		'index.tytul_strony' => 'Strony serwisu',

		'kategoria.etykieta_typ_glowna' => 'Strona główna',
		'kategoria.etykieta_typ_kategoria' => 'Podstrona',
		'kategoria.etykieta_typ_link_wewnetrzny' => 'Link do podstrony',
		'kategoria.etykieta_typ_link_zewnetrzny' => 'Link do strony zewnętrznej',
		'kategoria.etykieta_typ_menu' => 'Menu dodatkowe',

		'przebudowa.info_nie_mozna_przebudowac_adresow_url' => 'Nie udało sie przebudowanie wszystkich adresów url',
		'przebudowa.info_nie_mozna_przebudowac_adresu_url' => 'Nie udało się poprawić adresu url.',
		'przebudowa.info_nie_utworzono_jeszcze_kategorii' => 'Nie utworzono jeszcze żadnej strony w serwisie',
		'przebudowa.info_przebudowano_adres_url' => 'Poprawiono adres url.',
		'przebudowa.info_przebudowano_adresy_url' => 'Przebudowano adresy url dla całego serwisu',

		'sortowanie.blad_nie_mozna_pobrac_kategorii' => 'Przekazano nieprawidlowe dane strony',
		'sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii' => 'Nie można zmienić strony nadrzędnej dla sortowanej',
		'sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii' => 'Nie można zmienić ustawienia strony',
		'sortowanie.blad_niepelne_dane_kategorii' => 'Nieprawidlowe oznaczenia strony do sortowania ',
		'sortowanie.blad_nieprawidlowe_dane_kategorii' => 'Nie można sortować tych stron',
		'sortowanie.blad_nieprawidlowe_dane_sasiada' => 'Blad nieprawidłowe dane sąsiada',
		'sortowanie.blad_nieprawidlowe_oznaczenie_polozenia' => 'Nieprawidlowe oznaczenie polozenia',
		'sortowanie.info_zmieniono_rodzica_kategorii' => 'Zmieniono stronę nadrzędną dla sortowanej',
		'sortowanie.info_zmieniono_ustawienie_kategorii' => 'Zmieniono ustawienie strony',
		'sortowanie.tytul_strony' => 'Sortowanie stron',

		'usun.blad_brak_kategorii' => 'Nie można pobrać danych strony',
		'usun.blad_nie_mozna_usunac_kategorii' => 'Nie można usunąć strony!',
		'usun.info_usunieto_kategorie' => 'Strona została usunięta',

		'wczytajKonfiguracje.blad_nie_wczytano_konfiguracji' => '<h3>Nie udało się poprawnie zaimportować konfiguracji kategorii.<h3>',
		'wczytajKonfiguracje.etykieta_potwierdz_wczytanie_konfiguracji' => 'Czy napewno zaimportować konfigurację kategorii z pliku?',
		'wczytajKonfiguracje.niepoprawny_plik' => 'Plik do importu konfiguracji kategorii jest nieprawidłowy',
		'wczytajKonfiguracje.plik.etykieta' => 'Wyślij plik konfiguracji',
		'wczytajKonfiguracje.plik.opis' => '',
		'wczytajKonfiguracje.tytul_strony' => 'Wczytanie konfiguracji',
		'wczytajKonfiguracje.wczytano_konfiguracje' => '<h3>Udało się poprawnie zaimportować konfigurację widoków.<h3>',
		'wczytajKonfiguracje.wstecz.wartosc' => 'Wstecz',
		'wczytajKonfiguracje.zapisz.wartosc' => 'Wczytaj',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie drzewa podstron',
			'wykonajDodaj' => 'Dodawanie podstrony',
			'wykonajEdytuj' => 'Edycja podstrony',
			'wykonajUsun' => 'Usuwanie podstrony',
			'wykonajSortowanie' => 'Sortowanie podstron',
			'wykonajCzysc' => 'Usunięcie wszystkich podstron',
			'wykonajPrzebudowa' => 'Naprawianie adresów url',
			'wykonajPoprawUrl' => 'Naprawianie pojedynczego adresu url',
			'wykonajCzyscStaryUrl' => 'Czyszczenie starego url-a',
			'wykonajPobierzKonfiguracje' => 'Pobranie konfiguracji kategorii',
			'wykonajWczytajKonfiguracje' => 'Zaimportowanie konfiguracji kategorii',
		),
		'formularz.cache_przedzialy_czasowe' => array(
			'0' => 'Brak limitu',
			'60' => '1 minuta',
			'300' => '5 minut',
			'900' => '15 minut',
			'1800' => '30 minut',
			'3600' => '1 godzina',
			'14400' => '4 godziny',
			'86400' => '24 godziny',
		),
	);
}

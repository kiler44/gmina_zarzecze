<?php
namespace Generic\Tlumaczenie\Pl\Modul\ZadaniaCykliczne;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_zadania']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.aktywne.etykieta']
 * @property string $t['formularz.aktywne.opis']
 * @property string $t['formularz.blad_nie_mozna_zapisac_zadania']
 * @property string $t['formularz.dataRozpoczecia.etykieta']
 * @property string $t['formularz.dataRozpoczecia.opis']
 * @property string $t['formularz.dataZakonczenia.etykieta']
 * @property string $t['formularz.dataZakonczenia.opis']
 * @property string $t['formularz.dodanoRazy']
 * @property string $t['formularz.dodawaneWielokrotnie.etykieta']
 * @property string $t['formularz.dodawaneWielokrotnie.opis']
 * @property string $t['formularz.etykieta_data_wybierz']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_zadanie_brak_zadan']
 * @property string $t['formularz.info_zapisano_dane_zadania']
 * @property string $t['formularz.konfiguracja.etykieta']
 * @property string $t['formularz.konfiguracja.wartosc']
 * @property string $t['formularz.opisZadania.etykieta']
 * @property string $t['formularz.opisZadania.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zadanie.etykieta']
 * @property string $t['formularz.zadanie.opis']
 * @property string $t['formularz.zapisCron.etykieta']
 * @property string $t['formularz.zapisCron.opis']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzUruchom.dataDanych.etykieta']
 * @property string $t['formularzUruchom.dataDanych.opis']
 * @property string $t['formularzUruchom.dataTresci.etykieta']
 * @property string $t['formularzUruchom.dataTresci.opis']
 * @property string $t['formularzUruchom.info_uruchomiono_zadanie']
 * @property string $t['formularzUruchom.wstecz.wartosc']
 * @property string $t['formularzUruchom.zapisz.confirm']
 * @property string $t['formularzUruchom.zapisz.wartosc']
 * @property string $t['index.etykieta_akcja']
 * @property string $t['index.etykieta_aktywne']
 * @property string $t['index.etykieta_button_uruchom']
 * @property string $t['index.etykieta_data_rozpoczecia']
 * @property string $t['index.etykieta_data_zakonczenia']
 * @property string $t['index.etykieta_dodawane_wielokrotnie']
 * @property string $t['index.etykieta_id_kategorii']
 * @property string $t['index.etykieta_kod_modulu']
 * @property string $t['index.etykieta_link_doadaj']
 * @property string $t['index.etykieta_link_raport']
 * @property string $t['index.etykieta_link_sprawdz']
 * @property string $t['index.etykieta_schemat']
 * @property string $t['index.info_brak_modulow_cron']
 * @property string $t['index.tytul_strony']
 * @property string $t['raport.co']
 * @property string $t['raport.do']
 * @property string $t['raport.kazda_godz']
 * @property string $t['raport.kazda_min']
 * @property string $t['raport.kazdy_dzien']
 * @property string $t['raport.kazdy_miesiac']
 * @property string $t['raport.nazwa_raportu_xls']
 * @property string $t['raport.od']
 * @property string $t['sprawdz.szukaj.wartosc']
 * @property string $t['sprawdz.tytul_strony']
 * @property string $t['uruchom.tytul_strony']
 * @property string $t['usun.blad_brak_zadania']
 * @property string $t['usun.blad_nie_mozna_usunac_zadania']
 * @property string $t['usun.info_zadanie_usuniete']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajRaport']
 * @property string $t['_akcje_etykiety_']['wykonajSprawdz']
 * @property string $t['_akcje_etykiety_']['ustawWielokrotne']
 * @property string $t['_akcje_etykiety_']['wykonajUruchom']
 * @property array $t['raport.dni']
 * @property string $t['raport.dni']['0']
 * @property string $t['raport.dni']['1']
 * @property string $t['raport.dni']['2']
 * @property string $t['raport.dni']['3']
 * @property string $t['raport.dni']['4']
 * @property string $t['raport.dni']['5']
 * @property string $t['raport.dni']['6']
 * @property array $t['raport.miesiace']
 * @property string $t['raport.miesiace']['0']
 * @property string $t['raport.miesiace']['1']
 * @property string $t['raport.miesiace']['2']
 * @property string $t['raport.miesiace']['3']
 * @property string $t['raport.miesiace']['4']
 * @property string $t['raport.miesiace']['5']
 * @property string $t['raport.miesiace']['6']
 * @property string $t['raport.miesiace']['7']
 * @property string $t['raport.miesiace']['8']
 * @property string $t['raport.miesiace']['9']
 * @property string $t['raport.miesiace']['10']
 * @property string $t['raport.miesiace']['11']
 * @property string $t['raport.miesiace']['12']
 * @property array $t['raport.nazwy_wartosci_schematu']
 * @property string $t['raport.nazwy_wartosci_schematu']['0']
 * @property string $t['raport.nazwy_wartosci_schematu']['1']
 * @property string $t['raport.nazwy_wartosci_schematu']['2']
 * @property string $t['raport.nazwy_wartosci_schematu']['3']
 * @property string $t['raport.nazwy_wartosci_schematu']['4']
 * @property array $t['zadanie.aktywne']
 * @property string $t['zadanie.aktywne']['0']
 * @property string $t['zadanie.aktywne']['1']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.tytul_strony' => 'Dodaj zadanie',

		'edytuj.blad_brak_zadania' => 'Nie można pobrać zadania',
		'edytuj.tytul_strony' => 'Edycja zadania',

		'formularz.aktywne.etykieta' => 'Zadanie aktywne',
		'formularz.aktywne.opis' => '',
		'formularz.blad_nie_mozna_zapisac_zadania' => 'Nie można zapisać danych zadania!',
		'formularz.dataRozpoczecia.etykieta' => 'Data rozpoczęcia',
		'formularz.dataRozpoczecia.opis' => '',
		'formularz.dataZakonczenia.etykieta' => 'Data zakończenia',
		'formularz.dataZakonczenia.opis' => '',
		'formularz.dodanoRazy' => 'Dodano %s-krotnie',
		'formularz.dodawaneWielokrotnie.etykieta' => 'Pozwól dodać kolejny raz',
		'formularz.dodawaneWielokrotnie.opis' => '',
		'formularz.etykieta_data_wybierz' => ' - ',
		'formularz.etykieta_select_wybierz' => '- wybierz -',
		'formularz.etykieta_zadanie_brak_zadan' => 'Brak nowych zadań do wykonania',
		'formularz.info_zapisano_dane_zadania' => 'Zapisano dane zadania',
		'formularz.konfiguracja.etykieta' => '&nbsp;',
		'formularz.konfiguracja.wartosc' => 'Przejdź do edycji konfiruracji zadania',
		'formularz.opisZadania.etykieta' => 'Opis zadania',
		'formularz.opisZadania.opis' => '',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zadanie.etykieta' => 'Zadnie do wykonania',
		'formularz.zadanie.opis' => '',
		'formularz.zapisCron.etykieta' => 'Zapis czasu wykonania',
		'formularz.zapisCron.opis' => '',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'formularzUruchom.dataDanych.etykieta' => 'Data danych',
		'formularzUruchom.dataDanych.opis' => 'Symulowana data wywolania zadania. Na jej podstawie zostana pobrane dane.',
		'formularzUruchom.dataTresci.etykieta' => 'Data treśći',
		'formularzUruchom.dataTresci.opis' => 'Symulowana data, ktora zostanie wstawiona do treści maili (np przy obliczniu liczby dni do opłacenia faktury)',
		'formularzUruchom.info_uruchomiono_zadanie' => 'Zadanie zostało uruchomione. Sprawdź logi serwisu.',
		'formularzUruchom.wstecz.wartosc' => 'Wstecz',
		'formularzUruchom.zapisz.confirm' => 'Czy jesteś pewien, że chcesz uruchomić to zadanie?',
		'formularzUruchom.zapisz.wartosc' => 'Uruchom',

		'index.etykieta_akcja' => 'Akcja',
		'index.etykieta_aktywne' => 'Aktywne',
		'index.etykieta_button_uruchom' => 'Uruchom to zadanie',
		'index.etykieta_data_rozpoczecia' => 'Data rozpoczęcia',
		'index.etykieta_data_zakonczenia' => 'Data zakończenia',
		'index.etykieta_dodawane_wielokrotnie' => 'Pozwól dodać',
		'index.etykieta_id_kategorii' => 'Kategoria',
		'index.etykieta_kod_modulu' => 'Moduł',
		'index.etykieta_link_doadaj' => 'Dodaj zadanie',
		'index.etykieta_link_raport' => 'Pobierz raport zadań cyklicznych',
		'index.etykieta_link_sprawdz' => 'Lista najbliższych zadań',
		'index.etykieta_schemat' => 'Wykonywanie',
		'index.info_brak_modulow_cron' => 'Nie dodano żadnych modułów z obsługą zadań cyklicznych. Brak możliwości zarządzania zadaniami cyklicznymi.',
		'index.tytul_strony' => 'Zarządzanie zadaniami cyklicznymi',
		'index.tytul_modulu' => 'Zarządzanie zadaniami cyklicznymi',

		'raport.co' => 'co ',
		'raport.do' => ' do ',
		'raport.kazda_godz' => 'każda godzina, ',
		'raport.kazda_min' => 'każda minuta, ',
		'raport.kazdy_dzien' => 'każdy dzień, ',
		'raport.kazdy_miesiac' => 'każdy miesiąc, ',
		'raport.nazwa_raportu_xls' => 'Raport_zadan_cyklicznych',
		'raport.od' => ' od ',

		'sprawdz.szukaj.wartosc' => 'Sprawdź',
		'sprawdz.tytul_strony' => 'Sprawdź najbliższe zadania cykliczne',

		'uruchom.tytul_strony' => 'Uruchom zadanie cykliczne',

		'usun.blad_brak_zadania' => 'Nie można pobrać zadania',
		'usun.blad_nie_mozna_usunac_zadania' => 'Nie można usunąć zadania!',
		'usun.info_zadanie_usuniete' => 'Zadanie zostało usunięte',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista zadań cyklicznych',
			'wykonajDodaj' => 'Dodawanie zadań cyklicznych',
			'wykonajEdytuj' => 'Edycja zadań cyklicznych',
			'wykonajUsun' => 'Usuwanie zadań cyklicznych',
			'wykonajRaport' => 'Raport aktualnych zadań cyklicznych',
			'wykonajSprawdz' => 'Sprawdzenie najbliższych zadań cyklicznych',
			'ustawWielokrotne' => 'Oznaczenie zadania do dodania kolejny raz.',
			'wykonajUruchom' => 'Ręczne uruchamianie zadań Cron.',
		),
		'raport.dni' => array(
			'0' => 'w niedziele',
			'1' => 'w poniedziałek',
			'2' => 'we wtorek',
			'3' => 'we środę',
			'4' => 'we czwartek',
			'5' => 'w piątek',
			'6' => 'w sobotę',
		),
		'raport.miesiace' => array(
			'0' => '',
			'1' => 'styczeń,',
			'2' => 'luty,',
			'3' => 'marzec,',
			'4' => 'kwiecień,',
			'5' => 'maj,',
			'6' => 'czerwiec,',
			'7' => 'lipiec,',
			'8' => 'sierpień,',
			'9' => 'wrzesień,',
			'10' => 'październik,',
			'11' => 'listopad,',
			'12' => 'grudzień,',
		),
		'raport.nazwy_wartosci_schematu' => array(
			'0' => ' min.,',
			'1' => ' godz. ',
			'2' => ' dzień miesiąca,',
			'3' => '',
			'4' => '',
		),

		'zadanie.aktywne' => array(
			'0' => 'Nie',
			'1' => 'Tak',
		),
	);
}

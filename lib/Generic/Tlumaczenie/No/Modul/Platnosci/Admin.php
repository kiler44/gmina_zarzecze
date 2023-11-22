<?php
namespace Generic\Tlumaczenie\Pl\Modul\Platnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['anuluj.blad_nie_mozna_pobrac_platnosci']
 * @property string $t['anuluj.blad_nie_mozna_wyslac_zadania']
 * @property string $t['anuluj.blad_nie_mozna_zaktualizowac_platnosci']
 * @property string $t['anuluj.blad_status_nie_pozwala_wykonac']
 * @property string $t['anuluj.info_zaktualizowano_platnosci']
 * @property string $t['czysc.blad_nie_mozna_wyczyscic_cache']
 * @property string $t['czysc.info_wyczyszczono_cache']
 * @property string $t['index.brak_platnosci']
 * @property string $t['index.czysc.wartosc']
 * @property string $t['index.data_dodania_max.etykieta']
 * @property string $t['index.data_dodania_min.etykieta']
 * @property string $t['index.etykieta_czysc']
 * @property string $t['index.etykieta_czysc_pytanie']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_kwota']
 * @property string $t['index.etykieta_lp']
 * @property string $t['index.etykieta_nazwisko']
 * @property string $t['index.etykieta_opis']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_status']
 * @property string $t['index.fraza.etykieta']
 * @property string $t['index.kwota_max.etykieta']
 * @property string $t['index.kwota_min.etykieta']
 * @property string $t['index.status.etykieta']
 * @property string $t['index.szukaj.wartosc']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.blad_nie_mozna_pobrac_platnosci']
 * @property string $t['podglad.etykieta_anuluj']
 * @property string $t['podglad.etykieta_anuluj_pytanie']
 * @property string $t['podglad.etykieta_dane_odebrane']
 * @property string $t['podglad.etykieta_dane_wyslane']
 * @property string $t['podglad.etykieta_data_dodania']
 * @property string $t['podglad.etykieta_historia']
 * @property string $t['podglad.etykieta_kwota']
 * @property string $t['podglad.etykieta_obiekt']
 * @property string $t['podglad.etykieta_operacja']
 * @property string $t['podglad.etykieta_opis']
 * @property string $t['podglad.etykieta_potwierdz']
 * @property string $t['podglad.etykieta_potwierdz_pytanie']
 * @property string $t['podglad.etykieta_sprawdz_status']
 * @property string $t['podglad.etykieta_status']
 * @property string $t['podglad.etykieta_typ_platnosci']
 * @property string $t['podglad.etykieta_usun']
 * @property string $t['podglad.etykieta_usun_pytanie']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['potwierdz.blad_nie_mozna_pobrac_platnosci']
 * @property string $t['potwierdz.blad_nie_mozna_wyslac_zadania']
 * @property string $t['potwierdz.blad_nie_mozna_zaktualizowac_platnosci']
 * @property string $t['potwierdz.info_zaktualizowano_platnosci']
 * @property string $t['status.blad_nie_mozna_pobrac_platnosci']
 * @property string $t['status.blad_nie_mozna_wyslac_zadania']
 * @property string $t['status.blad_nie_mozna_zaktualizowac_platnosci']
 * @property string $t['status.info_zaktualizowano_platnosci']
 * @property string $t['usun.blad_nie_mozna_pobrac_platnosci']
 * @property string $t['usun.blad_nie_mozna_usunac_platnosci']
 * @property string $t['usun.blad_platnosc_w_realizacji']
 * @property string $t['usun.info_usunieto_platnosc']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajStatus']
 * @property string $t['_akcje_etykiety_']['wykonajPotwierdz']
 * @property string $t['_akcje_etykiety_']['wykonajAnuluj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajCzysc']
 * @property array $t['platnosc.operacje']
 * @property string $t['platnosc.operacje']['powiadomienie']
 * @property string $t['platnosc.operacje']['status']
 * @property string $t['platnosc.operacje']['potwierdzenie']
 * @property string $t['platnosc.operacje']['anulowanie']
 * @property array $t['platnosc.status']
 * @property string $t['platnosc.status']['nierozpoczeta']
 * @property string $t['platnosc.status']['nowa']
 * @property string $t['platnosc.status']['oczekujaca']
 * @property string $t['platnosc.status']['anulowana']
 * @property string $t['platnosc.status']['odrzucona']
 * @property string $t['platnosc.status']['zakonczona']
 * @property string $t['platnosc.status']['blad']
 * @property array $t['systemy_platnosci']
 * @property string $t['systemy_platnosci']['paypal']
 * @property string $t['systemy_platnosci']['platnosci']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'anuluj.blad_nie_mozna_pobrac_platnosci' => 'Nie można pobrać danych płatności',
		'anuluj.blad_nie_mozna_wyslac_zadania' => 'Nie można wysłać żądania do zewnętrznego systemu płatności',
		'anuluj.blad_nie_mozna_zaktualizowac_platnosci' => 'Nie można zapisać danych płatności',
		'anuluj.blad_status_nie_pozwala_wykonac' => 'Status płatności nie pozwala wykonać akcji',
		'anuluj.info_zaktualizowano_platnosci' => 'Wysłano żądanie i zapisano dane płatności',

		'czysc.blad_nie_mozna_wyczyscic_cache' => 'Nie można listy płatności',
		'czysc.info_wyczyszczono_cache' => 'Wyczyszczono cache listy płatności',

		'index.brak_platnosci' => 'Moduł nie ma żadnych zgłoszonych płatności',
		'index.czysc.wartosc' => 'Czyść',
		'index.data_dodania_max.etykieta' => '-',
		'index.data_dodania_min.etykieta' => 'Dodany',
		'index.etykieta_czysc' => 'Czyść listę',
		'index.etykieta_czysc_pytanie' => 'Czy na pewno usunąć cały cache listy płatności?',
		'index.etykieta_data_dodania' => 'Data',
		'index.etykieta_kwota' => 'Kwota',
		'index.etykieta_lp' => 'Lp.',
		'index.etykieta_nazwisko' => 'Wpłacający',
		'index.etykieta_opis' => 'Opis płatności',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_status' => 'Status',
		'index.fraza.etykieta' => 'Fraza',
		'index.kwota_max.etykieta' => '-',
		'index.kwota_min.etykieta' => 'Kwota ',
		'index.status.etykieta' => 'Status',
		'index.szukaj.wartosc' => 'Szukaj',
		'index.tytul_strony' => 'Lista płatności',

		'podglad.blad_nie_mozna_pobrac_platnosci' => 'Nie można pobrać danych płatności',
		'podglad.etykieta_anuluj' => 'Anuluj',
		'podglad.etykieta_anuluj_pytanie' => 'Czy na pewno chcesz anulować tą płatność?',
		'podglad.etykieta_dane_odebrane' => 'Data odebrane',
		'podglad.etykieta_dane_wyslane' => 'Dane wysłane',
		'podglad.etykieta_data_dodania' => 'Data',
		'podglad.etykieta_historia' => 'Historia płatności',
		'podglad.etykieta_kwota' => 'Kwota',
		'podglad.etykieta_obiekt' => 'Typ obiektu',
		'podglad.etykieta_operacja' => 'Typ operacji',
		'podglad.etykieta_opis' => 'Opis płatności',
		'podglad.etykieta_potwierdz' => 'Potwierdź',
		'podglad.etykieta_potwierdz_pytanie' => 'Czy na pewno chcesz zatwierdzić tą płatność?',
		'podglad.etykieta_sprawdz_status' => 'Sprawdź status',
		'podglad.etykieta_status' => 'Status',
		'podglad.etykieta_typ_platnosci' => 'Mechanizm płatności',
		'podglad.etykieta_usun' => 'Usuń',
		'podglad.etykieta_usun_pytanie' => 'Czy na pewno chcesz anulować tą płatność?',
		'podglad.tytul_strony' => 'Dane płatności',

		'potwierdz.blad_nie_mozna_pobrac_platnosci' => 'Nie można pobrać danych płatności',
		'potwierdz.blad_nie_mozna_wyslac_zadania' => 'Nie można wysłać żądania do zewnętrznego systemu płatności',
		'potwierdz.blad_nie_mozna_zaktualizowac_platnosci' => 'Nie można zapisać danych płatności',
		'potwierdz.info_zaktualizowano_platnosci' => 'Wysłano żądanie i zapisano dane płatności',

		'status.blad_nie_mozna_pobrac_platnosci' => 'Nie można pobrać danych płatności',
		'status.blad_nie_mozna_wyslac_zadania' => 'Nie można wysłać żądania do zewnętrznego systemu płatności',
		'status.blad_nie_mozna_zaktualizowac_platnosci' => 'Nie można zapisać danych płatności',
		'status.info_zaktualizowano_platnosci' => 'Pobrano i zapisano status płatności',

		'usun.blad_nie_mozna_pobrac_platnosci' => 'Nie można pobrać płatności',
		'usun.blad_nie_mozna_usunac_platnosci' => 'Nie można usunąć płatności',
		'usun.blad_platnosc_w_realizacji' => 'Płatność istnieje po stronie operatora',
		'usun.info_usunieto_platnosc' => 'Usunięto płatność',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień modułu',
			'wykonajPodglad' => 'Podgląd płatności',
			'wykonajStatus' => 'Status płatności',
			'wykonajPotwierdz' => 'Potwierdzanie płatności',
			'wykonajAnuluj' => 'Anulowanie płatności',
			'wykonajUsun' => 'Usuwanie płatności',
			'wykonajCzysc' => 'Czyszczenie cache listy płatności',
		),

		'platnosc.operacje' => array(
			'powiadomienie' => 'Powiadomienie',
			'status' => 'Odczyt statusu',
			'potwierdzenie' => 'Potwierdzenie',
			'anulowanie' => 'Anulowanie',
		),
		'platnosc.status' => array(
			'nierozpoczeta' => 'Brak po stronie operatora',
			'nowa' => 'Nowa',
			'oczekujaca' => 'W realizacji',
			'anulowana' => 'Anulowana',
			'odrzucona' => 'Odrzucona',
			'zakonczona' => 'Zakończona',
			'blad' => 'Błąd',
		),

		'systemy_platnosci' => array(
			'paypal' => 'PayPal',
			'platnosci' => 'Platnosci.pl',
		),
	);
}

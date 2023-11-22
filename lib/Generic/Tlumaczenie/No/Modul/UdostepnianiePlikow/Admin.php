<?php
namespace Generic\Tlumaczenie\Pl\Modul\UdostepnianiePlikow;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_nie_mozna_zapisac_pliku']
 * @property string $t['dodaj.info_plik_zapisany']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_pliku']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_pliku']
 * @property string $t['edytuj.info_plik_zapisany']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.blad_katalog_niedostepny']
 * @property string $t['formularz.etykieta_data_wybierz']
 * @property string $t['formularz.etykieta_input_autor']
 * @property string $t['formularz.etykieta_input_data_dodania']
 * @property string $t['formularz.etykieta_input_data_waznosci']
 * @property string $t['formularz.etykieta_input_plik']
 * @property string $t['formularz.etykieta_input_tresc']
 * @property string $t['formularz.etykieta_input_tytul']
 * @property string $t['formularz.etykieta_input_uprawnienia']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_wstecz']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['formularz.opis_input_data_dodania']
 * @property string $t['formularz.opis_input_data_waznosci']
 * @property string $t['formularz.opis_input_plik']
 * @property string $t['formularz.opis_input_tresc']
 * @property string $t['formularz.opis_input_tytul']
 * @property string $t['index.blad_nie_mozna_zapisac_strony']
 * @property string $t['index.etykieta_autor']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_dodaj']
 * @property string $t['index.etykieta_dodal']
 * @property string $t['index.etykieta_input_data_dodania']
 * @property string $t['index.etykieta_input_fraza']
 * @property string $t['index.etykieta_input_szukaj']
 * @property string $t['index.etykieta_plik']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_tytul']
 * @property string $t['index.tytul_strony']
 * @property string $t['usun.blad_nie_mozna_pobrac_pliku']
 * @property string $t['usun.blad_nie_mozna_usunac_pliku']
 * @property string $t['usun.info_usunieto_plik']
 * @property string $t['usunPlik.blad_nie_mozna_pobrac_pliku']
 * @property string $t['usunPlik.blad_nie_mozna_usunac_pliku']
 * @property string $t['usunPlik.info_usunieto_plik']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajUsunPlik']
 * @property array $t['data_dodania_opcje']
 * @property string $t['data_dodania_opcje']['7']
 * @property string $t['data_dodania_opcje']['14']
 * @property string $t['data_dodania_opcje']['31']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.blad_nie_mozna_zapisac_pliku' => 'Błąd przy zapisie pliku',
		'dodaj.info_plik_zapisany' => 'Dodano nowy plik',
		'dodaj.tytul_strony' => 'Dodawanie plików',

		'edytuj.blad_nie_mozna_pobrac_pliku' => 'Nie można pobrać danych pliku',
		'edytuj.blad_nie_mozna_zapisac_pliku' => 'Błąd przy zapisie pliku',
		'edytuj.info_plik_zapisany' => 'Dane pliku zostały zapisane',
		'edytuj.tytul_strony' => 'Edycja danych pliku',

		'formularz.blad_katalog_niedostepny' => 'Katalog plików jest niedostępny! Nie można tworzyć plików',
		'formularz.etykieta_data_wybierz' => ' - ',
		'formularz.etykieta_input_autor' => 'Autor',
		'formularz.etykieta_input_data_dodania' => 'Data dodania',
		'formularz.etykieta_input_data_waznosci' => 'Data ważności',
		'formularz.etykieta_input_plik' => 'Plik główny',
		'formularz.etykieta_input_tresc' => 'Opis pliku',
		'formularz.etykieta_input_tytul' => 'Tytuł',
		'formularz.etykieta_input_uprawnienia' => 'Uprawnienia',
		'formularz.etykieta_select_wybierz' => '- wybierz -',
		'formularz.etykieta_wstecz' => 'Wstecz',
		'formularz.etykieta_zapisz' => 'Zapisz',
		'formularz.opis_input_data_dodania' => '',
		'formularz.opis_input_data_waznosci' => '',
		'formularz.opis_input_plik' => 'Plik główny jest wyświetlany na liście aktualności.',
		'formularz.opis_input_tresc' => '',
		'formularz.opis_input_tytul' => '',

		'index.blad_nie_mozna_zapisac_strony' => 'Nie można zapisać danych strony!',
		'index.etykieta_autor' => 'Autor',
		'index.etykieta_data_dodania' => 'Data dodania',
		'index.etykieta_dodaj' => 'Dodaj plik',
		'index.etykieta_dodal' => 'Dodał',
		'index.etykieta_input_data_dodania' => 'Data dodania',
		'index.etykieta_input_fraza' => 'Szukana fraza',
		'index.etykieta_input_szukaj' => 'Szukaj',
		'index.etykieta_plik' => 'Nazwa pliku',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_tytul' => 'Tytuł',
		'index.tytul_strony' => 'Lista udostępnianych plików',

		'usun.blad_nie_mozna_pobrac_pliku' => 'Nie można pobrać danych pliku',
		'usun.blad_nie_mozna_usunac_pliku' => 'Nie można usunąć pliku',
		'usun.info_usunieto_plik' => 'Plik został usunięty',

		'usunPlik.blad_nie_mozna_pobrac_pliku' => 'Nie można pobrać danych pliku',
		'usunPlik.blad_nie_mozna_usunac_pliku' => 'Nie można usunąć pliku',
		'usunPlik.info_usunieto_plik' => 'Plik został usunięty',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie listy plików',
			'wykonajDodaj' => 'Dodawanie plików',
			'wykonajEdytuj' => 'Edycja plików',
			'wykonajUsun' => 'Usuwanie plików',
			'wykonajUsunPlik' => 'Usuwanie plików',
		),

		'data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
		),
	);
}

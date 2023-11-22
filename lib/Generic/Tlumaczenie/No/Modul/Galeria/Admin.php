<?php
namespace Generic\Tlumaczenie\No\Modul\Galeria;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_galerii']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.autor.etykieta']
 * @property string $t['formularz.blad_nie_mozna_zapisac_galerii']
 * @property string $t['formularz.dane_opisowe.zakladka']
 * @property string $t['formularz.dodaj_zdjecia.etykieta']
 * @property string $t['formularz.etykieta_data_dodania']
 * @property string $t['formularz.etykieta_dodaj_zdjecia_przycisk']
 * @property string $t['formularz.etykieta_katalog']
 * @property string $t['formularz.info_dodano_galerie']
 * @property string $t['formularz.info_zapisano_galerie']
 * @property string $t['formularz.miniaturki.etykieta']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.opis_katalog']
 * @property string $t['formularz.publikuj.etykieta']
 * @property string $t['formularz.region_dane_podstawowe']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zakladka_zdjęcia']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularz.zdjecia.zakladka']
 * @property string $t['index.data_dodania.etykieta']
 * @property string $t['index.etykieta_autor']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_dodaj']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_publikuj']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.fraza.etykieta']
 * @property string $t['index.przeszukaj_zdjecia.etykieta']
 * @property string $t['index.publikuj.etykieta']
 * @property string $t['index.szukaj.wartosc']
 * @property string $t['index.tytul_strony']
 * @property string $t['usun.blad_brak_galerii']
 * @property string $t['usun.blad_brak_zdjecia']
 * @property string $t['usun.blad_nie_mozna_usunac_galerii']
 * @property string $t['usun.blad_nie_mozna_usunac_plikow_zdjecia']
 * @property string $t['usun.blad_nie_mozna_usunac_zdjecia']
 * @property string $t['usun.blad_nie_mozna_usunac_zdjecia_z_dysku']
 * @property string $t['usun.info_galeria_usunieta']
 * @property string $t['usun.info_galeria_zaznaczone_usuniete']
 * @property string $t['usun.info_usunieto_zdjecie']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajUsunZdjecie']
 * @property string $t['_akcje_etykiety_']['wykonajUpload']
 * @property array $t['index.data_dodania_opcje']
 * @property string $t['index.data_dodania_opcje']['7']
 * @property string $t['index.data_dodania_opcje']['14']
 * @property string $t['index.data_dodania_opcje']['31']
 * @property array $t['galeria.publikacja']
 * @property string $t['galeria.publikacja']['0']
 * @property string $t['galeria.publikacja']['1']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'dodaj.tytul_strony' => 'Utwórz galrię',

		'edytuj.blad_brak_galerii' => 'Błąd! Nie mogę pobrać danych galerii.',
		'edytuj.tytul_strony' => 'Edycja galerii: ',

		'formularz.autor.etykieta' => 'Autor',
		'formularz.blad_nie_mozna_zapisac_galerii' => 'Nie można zapisać danych galerii!',
		'formularz.dane_opisowe.zakladka' => 'Dane opisowe',
		'formularz.dodaj_zdjecia.etykieta' => 'Wybierz zdjęcia, które zostaną dodane do galerii',
		'formularz.etykieta_data_dodania' => 'Data dodania',
		'formularz.etykieta_dodaj_zdjecia_przycisk' => 'Wybierz pliki',
		'formularz.etykieta_katalog' => 'Katalog galerii',
		'formularz.info_dodano_galerie' => 'Galeria została utworzona - teraz możesz dodawać zdjęcia.</a>',
		'formularz.info_zapisano_galerie' => 'Dane galerii zostały zapisane.',
		'formularz.miniaturki.etykieta' => 'Lista zdjęć tej galerii',
		'formularz.nazwa.etykieta' => 'Nazwa galerii',
		'formularz.opis.etykieta' => 'Opis galerii',
		'formularz.opis_katalog' => 'Podaj katalog w którym będą przechowywane zdjęcia galerii.',
		'formularz.publikuj.etykieta' => 'Publikować',
		'formularz.region_dane_podstawowe' => 'Dane podstawowe',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zakladka_zdjęcia' => 'Zdjęcia',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularz.zdjecia.zakladka' => 'Zdjęcia',

		'index.data_dodania.etykieta' => 'Data dodania',
		'index.etykieta_autor' => 'Autor',
		'index.etykieta_data_dodania' => 'Data dodania',
		'index.etykieta_dodaj' => 'Dodaj galerię',
		'index.etykieta_link_dodaj' => 'Utwórz galerię',
		'index.etykieta_nazwa' => 'Nazwa galerii',
		'index.etykieta_publikuj' => 'Widoczna',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.fraza.etykieta' => 'Szukana fraza',
		'index.przeszukaj_zdjecia.etykieta' => 'Szukaj w zdjęciach',
		'index.publikuj.etykieta' => 'Tylko opublikowane',
		'index.szukaj.wartosc' => 'Szukaj',
		'index.tytul_strony' => 'Zarzadzanie galeriami',

		'usun.blad_brak_galerii' => 'Błąd! Nie można usunąć galerii.',
		'usun.blad_brak_zdjecia' => 'Błąd! Podane zdjęcie nie istnieje.',
		'usun.blad_nie_mozna_usunac_galerii' => 'Błąd! Nie można usunąć galerii.',
		'usun.blad_nie_mozna_usunac_plikow_zdjecia' => 'Błąd! Nie udało się usunąć plików zdjęcia.',
		'usun.blad_nie_mozna_usunac_zdjecia' => 'Błąd! Nie udało się usunąć zdjęcia z bazy danych.',
		'usun.blad_nie_mozna_usunac_zdjecia_z_dysku' => 'Błąd! Nie udało się usunąć zdjęcia z dysku.',
		'usun.info_galeria_usunieta' => 'Galeria została usunięta',
		'usun.info_galeria_zaznaczone_usuniete' => 'Zaznaczone galerie zostały usunięte',
		'usun.info_usunieto_zdjecie' => 'Zdjęcie zostało usunięte.',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie listy galerii',
			'wykonajDodaj' => 'Dodawanie nowej galerii',
			'wykonajEdytuj' => 'Edycja galerii',
			'wykonajUsun' => 'Usuwanie galerii',
			'wykonajUsunZdjecie' => 'Usuwanie zdjęć z galerii',
			'wykonajUpload' => 'Dodawanie zdjęć do galerii',
		),

		'index.data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
		),

		'galeria.publikacja' => array(
			'0' => 'Nie',
			'1' => 'Tak',
		),
	);
}

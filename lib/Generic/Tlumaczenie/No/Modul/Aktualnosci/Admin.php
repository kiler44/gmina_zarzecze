<?php
namespace Generic\Tlumaczenie\No\Modul\Aktualnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_nie_mozna_zapisac_aktualnosci']
 * @property string $t['dodaj.info_aktualnosc_zapisana']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_aktualnosci']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_aktualnosci']
 * @property string $t['edytuj.info_aktualnosc_zapisana']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.autor.etykieta']
 * @property string $t['formularz.autor.opis']
 * @property string $t['formularz.blad_katalog_niedostepny']
 * @property string $t['formularz.dataDodania.etykieta']
 * @property string $t['formularz.dataDodania.opis']
 * @property string $t['formularz.dataWaznosci.etykieta']
 * @property string $t['formularz.dataWaznosci.opis']
 * @property string $t['formularz.etykieta_data_wybierz']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.idGalerii.etykieta']
 * @property string $t['formularz.idGalerii.opis']
 * @property string $t['formularz.priorytetowa.etykieta']
 * @property string $t['formularz.priorytetowa.opis']
 * @property string $t['formularz.publikuj.etykieta']
 * @property string $t['formularz.publikuj.opis']
 * @property string $t['formularz.tresc.etykieta']
 * @property string $t['formularz.tresc.opis']
 * @property string $t['formularz.tytul.etykieta']
 * @property string $t['formularz.tytul.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zajawka.etykieta']
 * @property string $t['formularz.zajawka.opis']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularz.zdjecieGlowne.etykieta']
 * @property string $t['formularz.zdjecieGlowne.opis']
 * @property string $t['index.blad_nie_mozna_zapisac_strony']
 * @property string $t['index.data_dodania.etykieta']
 * @property string $t['index.etykieta_autor']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_dodaj']
 * @property string $t['index.etykieta_publikuj']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_tytul']
 * @property string $t['index.fraza.etykieta']
 * @property string $t['index.priorytetowa.etykieta']
 * @property string $t['index.publikuj.etykieta']
 * @property string $t['index.szukaj.wartosc']
 * @property string $t['index.tytul_strony']
 * @property string $t['poprawMiniaturke.blad_nie_mozna_pobrac_aktualnosci']
 * @property string $t['poprawMiniaturke.blad_nie_mozna_poprawic_miniaturki']
 * @property string $t['poprawMiniaturke.blad_nieprawidlowy_kod_miniaturki']
 * @property string $t['poprawMiniaturke.info_poprawiono_miniaturke']
 * @property string $t['usun.blad_nie_mozna_pobrac_aktualnosci']
 * @property string $t['usun.blad_nie_mozna_usunac_aktualnosci']
 * @property string $t['usun.info_usunieto_aktualnosc']
 * @property string $t['usunZdjecie.blad_nie_mozna_pobrac_aktualnosci']
 * @property string $t['usunZdjecie.blad_nie_mozna_usunac_zdjecia']
 * @property string $t['usunZdjecie.info_usunieto_zdjecie']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajUsunZdjecie']
 * @property string $t['_akcje_etykiety_']['wykonajPoprawMiniaturke']
 * @property array $t['index.data_dodania_opcje']
 * @property string $t['index.data_dodania_opcje']['7']
 * @property string $t['index.data_dodania_opcje']['14']
 * @property string $t['index.data_dodania_opcje']['31']
 * @property array $t['publikuj_statusy']
 * @property string $t['publikuj_statusy']['0']
 * @property string $t['publikuj_statusy']['1']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'dodaj.blad_nie_mozna_zapisac_aktualnosci' => 'Błąd przy zapisie aktualności',
		'dodaj.info_aktualnosc_zapisana' => 'Dodano nową aktualność',
		'dodaj.tytul_strony' => 'Dodawanie aktualności',

		'edytuj.blad_nie_mozna_pobrac_aktualnosci' => 'Nie można pobrać danych aktualności',
		'edytuj.blad_nie_mozna_zapisac_aktualnosci' => 'Błąd przy zapisie aktualności',
		'edytuj.info_aktualnosc_zapisana' => 'Dane aktualności zostały zapisane',
		'edytuj.tytul_strony' => 'Edycja aktualności',

		'formularz.autor.etykieta' => 'Autor',
		'formularz.autor.opis' => 'Jeśli nie wypełnisz, pole zostanie wypełnione<br/> Twoim Imieniem i Nazwiskiem',
		'formularz.blad_katalog_niedostepny' => 'Katalog zdjęć jest niedostępny! Nie można tworzyć plików',
		'formularz.dataDodania.etykieta' => 'Data dodania',
		'formularz.dataDodania.opis' => '',
		'formularz.dataWaznosci.etykieta' => 'Data ważności',
		'formularz.dataWaznosci.opis' => '',
		'formularz.etykieta_data_wybierz' => ' - ',
		'formularz.etykieta_select_wybierz' => '- wybierz -',
		'formularz.idGalerii.etykieta' => 'Dołączona galeria',
		'formularz.idGalerii.opis' => '',
		'formularz.priorytetowa.etykieta' => 'Aktualność priorytetowa',
		'formularz.priorytetowa.opis' => '',
		'formularz.publikuj.etykieta' => 'Publikuj',
		'formularz.publikuj.opis' => '',
		'formularz.tresc.etykieta' => 'Pełna treść',
		'formularz.tresc.opis' => '',
		'formularz.tytul.etykieta' => 'Tytuł',
		'formularz.tytul.opis' => '',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zajawka.etykieta' => 'Wstęp',
		'formularz.zajawka.opis' => '',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularz.zdjecieGlowne.etykieta' => 'Zdjęcie główne',
		'formularz.zdjecieGlowne.opis' => 'Zdjęcie główne jest wyświetlane na liście aktualności.<br/>Więcej zdjęć dodasz poprzez edytor',

		'index.blad_nie_mozna_zapisac_strony' => 'Nie można zapisać danych strony!',
		'index.data_dodania.etykieta' => 'Data dodania',
		'index.etykieta_autor' => 'Autor',
		'index.etykieta_data_dodania' => 'Data dodania',
		'index.etykieta_dodaj' => 'Dodaj aktualność',
		'index.etykieta_publikuj' => 'Opublikowana',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_tytul' => 'Tytuł',
		'index.fraza.etykieta' => 'Szukana fraza',
		'index.priorytetowa.etykieta' => 'Tylko priorytetowe',
		'index.publikuj.etykieta' => 'Tylko opublikowane',
		'index.szukaj.wartosc' => 'Szukaj',
		'index.tytul_strony' => 'Lista aktualności',

		'poprawMiniaturke.blad_nie_mozna_pobrac_aktualnosci' => 'Nie można pobrać danych aktualności',
		'poprawMiniaturke.blad_nie_mozna_poprawic_miniaturki' => 'Nie można poprawić miniaturki',
		'poprawMiniaturke.blad_nieprawidlowy_kod_miniaturki' => 'Nieprawidłowy kod miniaturki',
		'poprawMiniaturke.info_poprawiono_miniaturke' => 'Poprawiono miniaturkę',

		'usun.blad_nie_mozna_pobrac_aktualnosci' => 'Nie można pobrać danych aktualności',
		'usun.blad_nie_mozna_usunac_aktualnosci' => 'Nie można usunąć aktualności',
		'usun.info_usunieto_aktualnosc' => 'Aktualność została usunięta',

		'usunZdjecie.blad_nie_mozna_pobrac_aktualnosci' => 'Nie można pobrać danych aktualności',
		'usunZdjecie.blad_nie_mozna_usunac_zdjecia' => 'Nie można usunąć zdjęcia',
		'usunZdjecie.info_usunieto_zdjecie' => 'Zdjęcie zostało usunięte',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie listy aktualności',
			'wykonajDodaj' => 'Dodawanie aktualności',
			'wykonajEdytuj' => 'Edycja aktualności',
			'wykonajUsun' => 'Usuwanie aktualności',
			'wykonajUsunZdjecie' => 'Usuwanie zdjęć w aktualności',
			'wykonajPoprawMiniaturke' => 'Poprawianie zdjęć w aktualności',
		),

		'index.data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
		),

		'publikuj_statusy' => array(
			'0' => 'Nie',
			'1' => 'Tak',
		),
	);
}

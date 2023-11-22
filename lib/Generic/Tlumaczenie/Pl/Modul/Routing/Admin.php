<?php
namespace Generic\Tlumaczenie\Pl\Modul\Routing;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['blokady.blad_nie_mozna_zapisac']
 * @property string $t['blokady.info_zapisano']
 * @property string $t['blokady.tytul_strony']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.blad_nie_mozna_zapisac']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.info_zapisano_dane']
 * @property string $t['formularz.routing_kategoria.etykieta']
 * @property string $t['formularz.routing_nazwa.etykieta']
 * @property string $t['formularz.routing_nazwaAkcji.etykieta']
 * @property string $t['formularz.routing_szablonUrl.etykieta']
 * @property string $t['formularz.routing_typReguly.etykieta']
 * @property string $t['formularz.routing_wartosc.etykieta']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzBlokady.regexp.etykieta']
 * @property string $t['formularzBlokady.regexp.opis']
 * @property string $t['formularzBlokady.stale.etykieta']
 * @property string $t['formularzBlokady.stale.opis']
 * @property string $t['formularzBlokady.wstecz.wartosc']
 * @property string $t['formularzBlokady.zapisz.wartosc']
 * @property string $t['formularzPrzekierowania.regexp.etykieta']
 * @property string $t['formularzPrzekierowania.regexp.opis']
 * @property string $t['formularzPrzekierowania.stale.etykieta']
 * @property string $t['formularzPrzekierowania.stale.opis']
 * @property string $t['formularzPrzekierowania.wstecz.wartosc']
 * @property string $t['formularzPrzekierowania.zapisz.wartosc']
 * @property string $t['index.etykieta_kodModulu']
 * @property string $t['index.etykieta_link_blokady']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_link_przekierowania']
 * @property string $t['index.etykieta_link_sortuj']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_nazwaAkcji']
 * @property string $t['index.etykieta_szablonUrl']
 * @property string $t['index.etykieta_typReguly']
 * @property string $t['index.etykieta_wartosc']
 * @property string $t['index.tytul_strony']
 * @property string $t['przekierowania.blad_nie_mozna_zapisac']
 * @property string $t['przekierowania.info_zapisano']
 * @property string $t['przekierowania.tytul_strony']
 * @property string $t['sortuj.error_nie_mozna_zapisac']
 * @property string $t['sortuj.etykieta_link_dodaj']
 * @property string $t['sortuj.etykieta_link_wstecz']
 * @property string $t['sortuj.info_zapisano']
 * @property string $t['sortuj.tytul_strony']
 * @property string $t['usun.error_nie_mozna_usunac']
 * @property string $t['usun.info_usunieto']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajSortuj']
 * @property string $t['_akcje_etykiety_']['wykonajZapiszSortowanie']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzAkcjeDlaKategorii']
 * @property string $t['_akcje_etykiety_']['wykonajPrzekierowania']
 * @property string $t['_akcje_etykiety_']['wykonajBlokady']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['dodano_regule']
 * @property string $t['_zdarzenia_etykiety_']['edytowano_regule']
 * @property string $t['_zdarzenia_etykiety_']['usunieto_regule']
 * @property string $t['_zdarzenia_etykiety_']['posortowano_reguly']
 * @property array $t['formularz.typyRegul']
 * @property string $t['formularz.typyRegul']['porownanie']
 * @property string $t['formularz.typyRegul']['wyrazenie']
 * @property string $t['formularz.typyRegul']['kategoria']
 * @property string $t['formularz.typyRegul']['branza']
 * @property string $t['formularz.typyRegul']['lista']
 * @property string $t['formularz.typyRegul']['oferta']
 * @property string $t['formularz.typyRegul']['strona']
 * @property string $t['formularz.typyRegul']['wizytowka_porownanie']
 * @property string $t['formularz.typyRegul']['wizytowka_wyrazenie']
 * @property string $t['formularz.typyRegul']['wizytowka_kategoria']
 * @property string $t['formularz.typyRegul']['wizytowka_lista']
 * @property string $t['formularz.typyRegul']['wizytowka_oferta']
 * @property string $t['formularz.typyRegul']['wizytowka_strona']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'blokady.blad_nie_mozna_zapisac' => 'Nie można zapisać pliku z blokadami.',
		'blokady.info_zapisano' => 'Zapisano blokady.',
		'blokady.tytul_strony' => 'Zarządzanie blokadami (404)',

		'dodaj.tytul_strony' => 'Dodaj regułę routingu',

		'edytuj.blad_nie_mozna_pobrac' => 'Wybrana reguła routingu nie istnieje.',
		'edytuj.tytul_strony' => 'Edytuj regułę routingu',

		'formularz.blad_nie_mozna_zapisac' => 'Nie udało się zapisać danych. Spróbuj ponownie.',
		'formularz.etykieta_select_wybierz' => '- Wybierz -',
		'formularz.info_zapisano_dane' => 'Zapisano dane reguły routingu',
		'formularz.routing_kategoria.etykieta' => 'Kategoria',
		'formularz.routing_nazwa.etykieta' => 'Nazwa',
		'formularz.routing_nazwaAkcji.etykieta' => 'Nazwa akcji',
		'formularz.routing_szablonUrl.etykieta' => 'Szablon URL',
		'formularz.routing_typReguly.etykieta' => 'Typ reguły',
		'formularz.routing_wartosc.etykieta' => 'Wartość',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'formularzBlokady.regexp.etykieta' => 'Blokady przez wyrażenie regularne',
		'formularzBlokady.regexp.opis' => 'Wyrażenia można sprawdzać np. pod adresem http://www.solmetra.com/scripts/regex/<br>UWAGA!!! Należy zwracać uwagę na wpisywane wyrażenia ponieważ można nimi zablokować znaczną grupę stron.',
		'formularzBlokady.stale.etykieta' => 'Blokady zwykłe',
		'formularzBlokady.stale.opis' => 'Należy pamiętać o wpisywaniu pełnego adresu np. http://stary.adres.pl/adres/do_zablokowania.html',
		'formularzBlokady.wstecz.wartosc' => 'Wstecz',
		'formularzBlokady.zapisz.wartosc' => 'Zapisz',

		'formularzPrzekierowania.regexp.etykieta' => 'Przekierowanie przez wyrażenie regularne',
		'formularzPrzekierowania.regexp.opis' => '[wyrażenie regularne] -> [nowy URL]<br>Wyrażenia można sprawdzać np. pod adresem http://www.solmetra.com/scripts/regex/<br/>Do nowego adresu url można wstawiać bloki z wyrażenia regularnego przez dodanie numeru bloku poprzedzonego znakiem "$" (dolar), np.<br> "/www.stary.adres.pl\/(.*)/" -> "http://www.nowy.adres.pl/$1"<br/>UWAGA!!! Należy zwracać uwagę na wpisywane wyrażenia ponieważ można nimi przekierować znaczną grupę stron.',
		'formularzPrzekierowania.stale.etykieta' => 'Przekierowanie zwykłe',
		'formularzPrzekierowania.stale.opis' => '[stary URL] -> [nowy URL]<br>Należy pamiętać o wpisywaniu pełnego adresu np. http://stary.adres.pl/adres/do_przekierowania.html',
		'formularzPrzekierowania.wstecz.wartosc' => 'Wstecz',
		'formularzPrzekierowania.zapisz.wartosc' => 'Zapisz',

		'index.etykieta_kodModulu' => 'Kod modułu',
		'index.etykieta_link_blokady' => 'Blokady adresów url',
		'index.etykieta_link_dodaj' => 'Dodaj regułę',
		'index.etykieta_link_przekierowania' => 'Przekierowanie adresów url',
		'index.etykieta_link_sortuj' => 'Sortuj reguły',
		'index.etykieta_nazwa' => 'Nazwa',
		'index.etykieta_nazwaAkcji' => 'Nazwa akcji',
		'index.etykieta_szablonUrl' => 'Szablon URL',
		'index.etykieta_typReguly' => 'Typ reguły',
		'index.etykieta_wartosc' => 'Wartość',
		'index.tytul_strony' => 'Reguły routingu',

		'przekierowania.blad_nie_mozna_zapisac' => 'Nie można zapisać pliku przekierowań.',
		'przekierowania.info_zapisano' => 'Zapisano przekierowania.',
		'przekierowania.tytul_strony' => 'Zarządzanie przekierowaniami (301)',

		'sortuj.error_nie_mozna_zapisac' => 'Wystapił błąd. Nie można zapisać kolejności reguł.',
		'sortuj.etykieta_link_dodaj' => 'Dodaj regułę',
		'sortuj.etykieta_link_wstecz' => 'Lista reguł',
		'sortuj.info_zapisano' => 'Zapisano posortowane reguły.',
		'sortuj.tytul_strony' => 'Sortowanie kolejności reguł',

		'usun.error_nie_mozna_usunac' => 'Wystąpił błąd. Reguła nie została usunięta.',
		'usun.info_usunieto' => 'Usunięto wybraną regułę.',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista reguł routingu',
			'wykonajDodaj' => 'Dodawanie nowych reguł routingu',
			'wykonajEdytuj' => 'Edycja reguł routingu',
			'wykonajUsun' => 'Usuwanie reguł routingu',
			'wykonajSortuj' => 'Sortowanie listy reguł',
			'wykonajZapiszSortowanie' => 'Zapisanie sortowania listy reguł.',
			'wykonajPobierzAkcjeDlaKategorii' => 'Pobranie listy akcji dla kategorii.',
			'wykonajPrzekierowania' => 'Zarządzanie przekierowaniami url (301)',
			'wykonajBlokady' => 'Zarządzanie blokadami url (404)',
		),

		'_zdarzenia_etykiety_' => array(
			'dodano_regule' => 'Dodano regułę',
			'edytowano_regule' => 'Edytowano regułę',
			'usunieto_regule' => 'Usunięto regułę',
			'posortowano_reguly' => 'Posortowano reguły',
		),

		'formularz.typyRegul' => array(
			'porownanie' => 'Predefiniowany url',
			'wyrazenie' => 'Wyrażenie regularne',
			'kategoria' => 'Kategoria ogłoszeń',
			'branza' => 'Branża',
			'lista' => 'Lista ofert',
			'oferta' => 'Oferta',
			'strona' => 'Strona dodatkowa',
			'wizytowka_porownanie' => 'Predefiniowany url na wizytówce',
			'wizytowka_wyrazenie' => 'Wyrażenie regularne na wizytówce',
			'wizytowka_kategoria' => 'Kategoria ogłoszeń na wizytówce',
			'wizytowka_lista' => 'Lista ofert na wizytówce',
			'wizytowka_oferta' => 'Oferta na wizytówce',
			'wizytowka_strona' => 'Strona dodatkowa na wizytówce',
		),
	);
}

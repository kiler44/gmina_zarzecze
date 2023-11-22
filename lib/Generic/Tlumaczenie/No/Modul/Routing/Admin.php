<?php
namespace Generic\Tlumaczenie\No\Modul\Routing;

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

		'blokady.blad_nie_mozna_zapisac' => 'Cannot save file containing blocked urls',
		'blokady.info_zapisano' => 'Blocked urls list saved.',
		'blokady.tytul_strony' => 'Clocked urls management (404)',

		'dodaj.tytul_strony' => 'Create routing rule',

		'edytuj.blad_nie_mozna_pobrac' => 'Selected rule doesn\'t exist',
		'edytuj.tytul_strony' => 'Edit routing rule',

		'formularz.blad_nie_mozna_zapisac' => 'Cannot save rule',
		'formularz.etykieta_select_wybierz' => '- Select -',
		'formularz.info_zapisano_dane' => 'Routing rule saved',
		'formularz.routing_kategoria.etykieta' => 'Category',
		'formularz.routing_nazwa.etykieta' => 'Name',
		'formularz.routing_nazwaAkcji.etykieta' => 'Action name',
		'formularz.routing_szablonUrl.etykieta' => 'URL template',
		'formularz.routing_typReguly.etykieta' => 'Rule type',
		'formularz.routing_wartosc.etykieta' => 'Value',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.zapisz.wartosc' => 'Save',

		'formularzBlokady.regexp.etykieta' => 'Bloced urls via regular expressions',
		'formularzBlokady.regexp.opis' => 'You can chcek your expressions at http://www.solmetra.com/scripts/regex/<br>CAUTION! Use it carefully',
		'formularzBlokady.stale.etykieta' => 'Regular blocking',
		'formularzBlokady.stale.opis' => 'Enter full url ex. http://old.address.com/address/to_block.html',
		'formularzBlokady.wstecz.wartosc' => 'Back',
		'formularzBlokady.zapisz.wartosc' => 'Save',

		'formularzPrzekierowania.regexp.etykieta' => 'Redirect via regular expressions',
		'formularzPrzekierowania.regexp.opis' => '[regular_expression] -> [new URL]<br>Wyrażenia można sprawdzać np. pod adresem http://www.solmetra.com/scripts/regex/<br/>Do nowego adresu url można wstawiać bloki z wyrażenia regularnego przez dodanie numeru bloku poprzedzonego znakiem "$" (dolar), np.<br> "/www.stary.adres.pl\/(.*)/" -> "http://www.nowy.adres.pl/$1"<br/>UWAGA!!! Należy zwracać uwagę na wpisywane wyrażenia ponieważ można nimi przekierować znaczną grupę stron.',
		'formularzPrzekierowania.stale.etykieta' => 'Regular redirect',
		'formularzPrzekierowania.stale.opis' => '[stary URL] -> [nowy URL]<br>Należy pamiętać o wpisywaniu pełnego adresu np. http://stary.adres.pl/adres/do_przekierowania.html',
		'formularzPrzekierowania.wstecz.wartosc' => 'Back',
		'formularzPrzekierowania.zapisz.wartosc' => 'Save',

		'index.etykieta_kodModulu' => 'Module code',
		'index.etykieta_link_blokady' => 'URL blocks',
		'index.etykieta_link_dodaj' => 'Create rule',
		'index.etykieta_link_przekierowania' => 'URL redirects',
		'index.etykieta_link_sortuj' => 'Order rules',
		'index.etykieta_nazwa' => 'Name',
		'index.etykieta_nazwaAkcji' => 'Action name',
		'index.etykieta_szablonUrl' => 'URL template',
		'index.etykieta_typReguly' => 'Tule type',
		'index.etykieta_wartosc' => 'Value',
		'index.tytul_strony' => 'Routing rules',

		'przekierowania.blad_nie_mozna_zapisac' => 'Redirections rules file couldn\'t be save',
		'przekierowania.info_zapisano' => 'Redirections saved',
		'przekierowania.tytul_strony' => 'Redirections list (301)',

		'sortuj.error_nie_mozna_zapisac' => 'Error occured. Cannot save rule',
		'sortuj.etykieta_link_dodaj' => 'Create rule',
		'sortuj.etykieta_link_wstecz' => 'Rules list',
		'sortuj.info_zapisano' => 'Rules new order saved',
		'sortuj.tytul_strony' => 'Order of rules',

		'usun.error_nie_mozna_usunac' => 'Error occured. Rule couldn\'t be removed',
		'usun.info_usunieto' => 'Rule removed.',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of rules',
			'wykonajDodaj' => 'Create rule',
			'wykonajEdytuj' => 'Edit rule',
			'wykonajUsun' => 'Delete rule',
			'wykonajSortuj' => 'Change rules order',
			'wykonajZapiszSortowanie' => 'Save of changed order.',
			'wykonajPobierzAkcjeDlaKategorii' => 'Get action list for category',
			'wykonajPrzekierowania' => 'URLs Redirections management (301)',
			'wykonajBlokady' => 'URLs Blocks management (404)',
		),

		'_zdarzenia_etykiety_' => array(
			'dodano_regule' => 'Rule added',
			'edytowano_regule' => 'Rule edited',
			'usunieto_regule' => 'Rule deleted',
			'posortowano_reguly' => 'Rules sorted',
		),

		'formularz.typyRegul' => array(
			'porownanie' => 'Predefined url',
			'wyrazenie' => 'Regular expression',
		),
	);
}

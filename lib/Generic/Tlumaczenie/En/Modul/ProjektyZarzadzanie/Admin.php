<?php
namespace Generic\Tlumaczenie\En\Modul\ProjektyZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_kod_zajety']
 * @property string $t['dodaj.blad_nie_mozna_utworzyc_katalogu']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_projektu']
 * @property string $t['dodaj.info_zapisano_dane_projektu']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_projektu']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_projektu']
 * @property string $t['edytuj.info_zapisano_dane_projektu']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.dodatkowe_uslugi.zakladka']
 * @property string $t['formularz.domena.etykieta']
 * @property string $t['formularz.domyslnyJezyk.etykieta']
 * @property string $t['formularz.etykieta_odwroc_zaznaczenie']
 * @property string $t['formularz.etykieta_odznacz_wiele']
 * @property string $t['formularz.etykieta_zaznacz_wiele']
 * @property string $t['formularz.jezyki.etykieta']
 * @property string $t['formularz.kod.etykieta']
 * @property string $t['formularz.moduly_zakladka.zakladka']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.ogolne.zakladka']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.region_bloki']
 * @property string $t['formularz.region_moduly']
 * @property string $t['formularz.szablon.etykieta']
 * @property string $t['formularz.usluga_cron.region']
 * @property string $t['formularz.usluga_rss.region']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_button_vhost']
 * @property string $t['index.etykieta_dodaj']
 * @property string $t['index.etykieta_domena']
 * @property string $t['index.etykieta_kod']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.tytul_strony']
 * @property string $t['usun.blad_brak_projektu']
 * @property string $t['usun.blad_nie_mozna_usunac_projektu']
 * @property string $t['usun.info_projekt_usuniety']
 * @property string $t['vhost.blad_brak_projektu']
 * @property string $t['vhost.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajVhost']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.blad_kod_zajety' => 'Entered code already in use',
		'dodaj.blad_nie_mozna_utworzyc_katalogu' => 'Cannot create directory %s',
		'dodaj.blad_nie_mozna_zapisac_projektu' => 'Cannot save project data!',
		'dodaj.info_zapisano_dane_projektu' => 'New project successfully added',
		'dodaj.tytul_strony' => 'New project',

		'edytuj.blad_brak_projektu' => 'Cannot obtain project data',
		'edytuj.blad_nie_mozna_zapisac_projektu' => 'Cannot save project data!',
		'edytuj.info_zapisano_dane_projektu' => 'Save project data',
		'edytuj.tytul_strony' => 'Edit project: ',

		'formularz.dodatkowe_uslugi.zakladka' => 'Additional services',
		'formularz.domena.etykieta' => 'Domain',
		'formularz.domyslnyJezyk.etykieta' => 'Default language',
		'formularz.etykieta_odwroc_zaznaczenie' => 'Revert selected',
		'formularz.etykieta_odznacz_wiele' => 'Uncheck all',
		'formularz.etykieta_zaznacz_wiele' => 'check all',
		'formularz.jezyki.etykieta' => 'Languages',
		'formularz.kod.etykieta' => 'Code',
		'formularz.moduly_zakladka.zakladka' => 'Assigned modules',
		'formularz.nazwa.etykieta' => 'Name',
		'formularz.ogolne.zakladka' => 'Settings',
		'formularz.opis.etykieta' => 'Description',
		'formularz.region_bloki' => 'Available blocks',
		'formularz.region_moduly' => 'Available modules',
		'formularz.szablon.etykieta' => 'Template',
		'formularz.usluga_cron.region' => 'Cron available modules',
		'formularz.usluga_rss.region' => 'Rss available modules',
		'formularz.usluga_api.region' => 'Modules with available API',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.zapisz.wartosc' => 'Save',

		'index.etykieta_button_vhost' => 'Apache configuration preview',
		'index.etykieta_dodaj' => 'Add projct',
		'index.etykieta_domena' => 'Domain',
		'index.etykieta_kod' => 'Code',
		'index.etykieta_nazwa' => 'Project name',
		'index.tytul_strony' => 'Project management',

		'usun.blad_brak_projektu' => 'Cannot obtain project data',
		'usun.blad_nie_mozna_usunac_projektu' => 'Cannot delete project!',
		'usun.info_projekt_usuniety' => 'Project removed',

		'vhost.blad_brak_projektu' => 'Cannot obtain project data',
		'vhost.tytul_strony' => 'VirtualHost Apache configuration for project',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of projects',
			'wykonajDodaj' => 'Add project',
			'wykonajEdytuj' => 'Edit project',
			'wykonajUsun' => 'Delete project',
			'wykonajVhost' => 'generate VirtualHost configuration',
		),
	);
}

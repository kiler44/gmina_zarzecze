<?php
namespace Generic\Tlumaczenie\En\Modul\WidokiZarzadzanie;

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

		'blok.etykieta_link_edytuj' => 'Edit block',
		'blok.etykieta_link_tresc' => 'Edit content',
		'blok.etykieta_link_usun' => 'Delete block',
		'bloki.etykieta_edytuj' => 'Edit block',
		'bloki.etykieta_edytuj_tresc' => 'Edit block content',
		'bloki.etykieta_input_szablon' => 'Template',
		'bloki.etykieta_kod_modulu' => 'Module',
		'bloki.etykieta_kontener' => 'Container',
		'bloki.etykieta_link_dodaj' => 'Add block',
		'bloki.etykieta_nazwa' => 'Block name',
		'bloki.etykieta_potwierdz_usun' => 'Do you want to remove selected block?',
		'bloki.etykieta_usun' => 'Delete block',
		'bloki.tytul_strony' => 'Blocks management',

		'buduj.tytul_strony' => 'Build page layout',
		
		
		'dodaj.blad_nazwa_zajeta' => 'Selected name is already in use',
		'dodaj.blad_nie_mozna_zapisac_widoku' => 'Cannot save page layout!',
		'dodaj.info_zapisano_dane_widoku' => 'Layoyt saved',
		'dodaj.tytul_strony' => 'New page layout',

		'dodajBlok.blad_nazwa_zajeta' => 'Selected name is already in use',
		'dodajBlok.blad_nie_mozna_zapisac_bloku' => 'Cannot save block data!',
		'dodajBlok.info_zapisano_dane_bloku' => 'Block added',
		'dodajBlok.tytul_strony' => 'Add new block',

		'edytuj.blad_brak_widoku' => 'Cannot obtain page layout data',
		'edytuj.blad_nie_mozna_zapisac_widoku' => 'Cannot save page layout!',
		'edytuj.etykieta_link_dodaj' => 'Add block',
		'edytuj.info_widok_domyslny' => 'Default layout settings restored',
		'edytuj.info_widok_edytowany' => 'Page layout is being edited. Layout is different than this saved in DB',
		'edytuj.info_zapisano_dane_widoku' => 'page layout saved',
		'edytuj.tytul_strony' => 'Edit page layout',

		'edytujBlok.blad_brak_bloku' => 'Cannot obtain block data',
		'edytujBlok.blad_nie_mozna_zapisac_bloku' => 'Cannot save block data!',
		'edytujBlok.etykieta_link_konfiguracja' => 'Block configuration',
		'edytujBlok.etykieta_link_tlumaczenia' => 'Block translations',
		'edytujBlok.info_zapisano_dane_bloku' => 'Block saved',
		'edytujBlok.tytul_strony' => 'Edit block',

		'formularz.cache.etykieta' => 'Cache this block',
		'formularz.cache.opis' => '',
		'formularz.cacheCzas.etykieta' => 'Cache refresh time',
		'formularz.cacheCzas.opis' => 'Time interval when cach will be refreshed',
		'formularz.czysc.wartosc' => 'Cancel changes',
		'formularz.etykieta_kategoria' => 'Page main content',
		'formularz.etykieta_select_wybierz' => ' - select - ',
		'formularz.klasa.etykieta' => 'Class',
		'formularz.klasa.opis' => '',
		'formularz.kodModulu.etykieta' => 'Module',
		'formularz.kodModulu.opis' => '',
		'formularz.kontener.etykieta' => 'Container',
		'formularz.kontener.opis' => '',
		'formularz.kopiowanyWidok.etykieta' => 'Copy from existing layout',
		'formularz.kopiowanyWidok.opis' => 'If checked all layout data except name will be copied',
		'formularz.nazwa.etykieta' => 'Name',
		'formularz.nazwa.opis' => '',
		'formularz.podglad.etykieta' => 'Preview',
		'formularz.podglad.opis' => 'Preview of edited layout on selected category',
		'formularz.szablon.etykieta' => 'Template',
		'formularz.szablon.opis' => '',
		'formularz.ukladStrony.etykieta' => 'Template',
		'formularz.ukladStrony.opis' => '',
		'formularz.widoki.etykieta' => 'Related layouts',
		'formularz.widoki.opis' => '',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.zapisz.wartosc' => 'Save',

		'index.etykieta_bloki' => 'Used blocks',
		'index.etykieta_link_bloki' => 'Blocks management',
		'index.etykieta_link_dodaj' => 'Add page layout',
		'index.etykieta_link_edytuj' => 'Edit layout',
		'index.etykieta_link_pobierz_konfiguracje' => 'Export configuration',
		'index.etykieta_link_usun' => 'Delete layout',
		'index.etykieta_link_wczytaj_konfiguracje' => 'Load configuration from file',
		'index.etykieta_nazwa' => 'Page layout name',
		'index.etykieta_ukladStrony' => 'Template',
		'index.tytul_strony' => 'Page layouts management',
		'index.etykieta_budowanie_ukladu' => 'Build page layout',

		'trescBloku.blad_brak_bloku' => 'Cannot obtain block data',

		'usun.blad_brak_widoku' => 'Cannot obtain page layout data',
		'usun.blad_nie_mozna_usunac_widoku' => 'Cannot remove page layout!',
		'usun.blad_przypisane_kategorie' => 'Cannot remove because layout is used by those categories: %s',
		'usun.info_usunieto_widok' => 'Page layout removed',

		'usunBlok.blad_brak_bloku' => 'Cannot obtain block data',
		'usunBlok.blad_istnieja_widoki_zawierajace' => 'Layouts that use this block: %s',
		'usunBlok.blad_nie_mozna_usunac_bloku' => 'Cannot remove block!',
		'usunBlok.info_usunieto_blok' => 'Block removed',

		'wczytajKonfiguracje.blad_nie_wczytano_konfiguracji' => '<h3>Import of layout configuration failed<h3>',
		'wczytajKonfiguracje.etykieta_potwierdz_wczytanie_konfiguracji' => 'Do you want to import layout configuration from file?',
		'wczytajKonfiguracje.niepoprawny_plik' => 'Import file invalid',
		'wczytajKonfiguracje.plik.etykieta' => 'Send configuration file',
		'wczytajKonfiguracje.plik.opis' => '',
		'wczytajKonfiguracje.tytul_strony' => 'Load configuration',
		'wczytajKonfiguracje.wczytano_konfiguracje' => '<h3>Layout restored from configuration file<h3>',
		'wczytajKonfiguracje.wstecz.wartosc' => 'Back',
		'wczytajKonfiguracje.zapisz.wartosc' => 'Load',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of layouts',
			'wykonajDodaj' => 'Add page layout',
			'wykonajEdytuj' => 'Edit layout',
			'wykonajUsun' => 'Delete layout',
			'wykonajAktualizuj' => 'Update layout for preview',
			'wykonajBloki' => 'Additional blocks management',
			'wykonajDodajBlok' => 'Add block',
			'wykonajEdytujBlok' => 'Edit block',
			'wykonajUsunBlok' => 'Delete block',
			'wykonajPobierzKonfiguracje' => 'Export layout configuration',
			'wykonajWczytajKonfiguracje' => 'Impotr layout configuration',
		),

		'bloki.cache_przedzialy_czasowe' => array(
			'0' => 'Don\' refresh',
			'60' => '1 minute',
			'300' => '5 minutes',
			'900' => '15 minutes',
			'1800' => '30 minutes',
			'3600' => '1 hour',
			'86400' => '24 hours',
		),
		
		'gridster' => array(
			'zapisano_uklad' => 'Laout saved',
			'niezapisano_uklad' => 'Layout not saved',
			'blad' => 'Gridster error occured',
		),
	);
}

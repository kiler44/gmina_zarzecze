<?php
namespace Generic\Tlumaczenie\No\Modul\KonfiguracjaSystemu;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['administracyjne.tytul_strony']
 * @property string $t['czyscAdministracyjny.blad_modulu_nie_jest_administracyjny']
 * @property string $t['czyscAdministracyjny.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscAdministracyjny.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscAdministracyjny.info_usunieto_wiersze']
 * @property string $t['czyscBlok.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscBlok.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscBlok.blad_nieprawidlowy_blok']
 * @property string $t['czyscBlok.info_usunieto_wiersze']
 * @property string $t['czyscKategorie.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscKategorie.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscKategorie.blad_nieprawidlowa_kategoria']
 * @property string $t['czyscKategorie.info_usunieto_wiersze']
 * @property string $t['czyscSystem.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscSystem.info_usunieto_wiersze']
 * @property string $t['czyscZwykly.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['czyscZwykly.blad_modulu_nie_jest_zwykly']
 * @property string $t['czyscZwykly.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscZwykly.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscZwykly.info_usunieto_wiersze']
 * @property string $t['edytujAdministracyjny.blad_brak_uprawnien_do_modulu']
 * @property string $t['edytujAdministracyjny.blad_modulu_nie_jest_administracyjny']
 * @property string $t['edytujAdministracyjny.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujAdministracyjny.etykieta_link_czysc']
 * @property string $t['edytujAdministracyjny.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujAdministracyjny.tytul_strony']
 * @property string $t['edytujBlok.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujBlok.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujBlok.blad_nieprawidlowy_blok']
 * @property string $t['edytujBlok.etykieta_link_czysc']
 * @property string $t['edytujBlok.etykieta_pobierz_konfiguracje']
 * @property string $t['edytujBlok.etykieta_wczytaj_konfiguracje']
 * @property string $t['edytujBlok.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujBlok.tytul_strony']
 * @property string $t['edytujKategorie.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujKategorie.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujKategorie.blad_nieprawidlowa_kategoria']
 * @property string $t['edytujKategorie.etykieta_link_czysc']
 * @property string $t['edytujKategorie.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujKategorie.tytul_strony']
 * @property string $t['edytujZwykly.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujZwykly.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujZwykly.etykieta_link_czysc']
 * @property string $t['edytujZwykly.info_modul_nie_posiada_konfiguracji']
 * @property string $t['edytujZwykly.tytul_strony']
 * @property string $t['formularz.etykieta_link_czysc']
 * @property string $t['formularz.etykieta_wstecz']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['index.etykieta_fraza']
 * @property string $t['index.etykieta_globalne']
 * @property string $t['index.etykieta_link_globalne']
 * @property string $t['index.etykieta_link_konfiguracja']
 * @property string $t['index.etykieta_link_konfiguracja_systemu_czysc']
 * @property string $t['index.etykieta_link_konfiguracja_systemu_czysc_potwierdzenie']
 * @property string $t['index.etykieta_link_moduly_administracyjne']
 * @property string $t['index.etykieta_link_moduly_zwykle']
 * @property string $t['index.etykieta_link_system']
 * @property string $t['index.etykieta_moduly_administracyjne']
 * @property string $t['index.etykieta_moduly_zwykle']
 * @property string $t['index.etykieta_system']
 * @property string $t['index.etykieta_szukaj']
 * @property string $t['index.etykieta_wyszukiwarka']
 * @property string $t['index.opis_globalne']
 * @property string $t['index.opis_moduly_administracyjne']
 * @property string $t['index.opis_moduly_zwykle']
 * @property string $t['index.opis_system']
 * @property string $t['index.tytul_strony']
 * @property string $t['modul.tytul_strony']
 * @property string $t['system.blad_nie_mozna_zapisac_wiersza']
 * @property string $t['system.error_nie_mozna_zapisac_wierszy']
 * @property string $t['system.info_zapisano_wiersze']
 * @property string $t['system.tytul_strony']
 * @property string $t['szukajFrazy.blad.fraza_zbyt_krotka']
 * @property string $t['szukajFrazy.etykieta_button_edytuj']
 * @property string $t['szukajFrazy.etykieta_dotyczy']
 * @property string $t['szukajFrazy.etykieta_dotyczy_bloku']
 * @property string $t['szukajFrazy.etykieta_dotyczy_globalne']
 * @property string $t['szukajFrazy.etykieta_dotyczy_kategorii']
 * @property string $t['szukajFrazy.etykieta_nazwa']
 * @property string $t['szukajFrazy.etykieta_wartosc']
 * @property string $t['szukajFrazy.naglowek_modulu']
 * @property string $t['szukajFrazy.nie_znaleziono']
 * @property string $t['szukajFrazy.tytul_strony']
 * @property string $t['tabela.etykieta_edytuj']
 * @property string $t['tabela.etykieta_input_czysc']
 * @property string $t['tabela.etykieta_input_fraza']
 * @property string $t['tabela.etykieta_input_szukaj']
 * @property string $t['tabela.etykieta_input_typ']
 * @property string $t['tabela.etykieta_nazwa']
 * @property string $t['tabela.etykieta_select_wybierz']
 * @property string $t['tabela.etykieta_typ']
 * @property string $t['wczytajKonfiguracje.blad_nie_wczytano_konfiguracji']
 * @property string $t['wczytajKonfiguracje.plik.etykieta']
 * @property string $t['wczytajKonfiguracje.plik.opis']
 * @property string $t['wczytajKonfiguracje.tytul_strony']
 * @property string $t['wczytajKonfiguracje.wczytano_konfiguracje']
 * @property string $t['wczytajKonfiguracje.zapisz.wartosc']
 * @property string $t['zmienneGlobalne.blad_kluczy']
 * @property string $t['zmienneGlobalne.blad_systemowe']
 * @property string $t['zmienneGlobalne.nie_zapisano']
 * @property string $t['zmienneGlobalne.opis_globalnych']
 * @property string $t['zmienneGlobalne.opis_globalnych_systemowych']
 * @property string $t['zmienneGlobalne.opis_globalnych_zarezerwowanych']
 * @property string $t['zmienneGlobalne.tablica_globalnych']
 * @property string $t['zmienneGlobalne.tablica_globalnych_systemowych']
 * @property string $t['zmienneGlobalne.tablica_globalnych_zarezerwowanych']
 * @property string $t['zmienneGlobalne.zapisano']
 * @property string $t['zwykle.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajSystem']
 * @property string $t['_akcje_etykiety_']['wykonajAdministracyjne']
 * @property string $t['_akcje_etykiety_']['wykonajZwykle']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujAdministracyjny']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujZwykly']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujKategorie']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujBlok']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscSystem']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscAdministracyjny']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscZwykly']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscKategorie']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscBlok']
 * @property string $t['_akcje_etykiety_']['wykonajZmienneGlobalne']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajWczytajKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajSzukajFrazy']
 * @property string $t['_akcje_etykiety_']['opcjeSystemowe']
 * @property array $t['modul_typy']
 * @property string $t['modul_typy']['administracyjny']
 * @property string $t['modul_typy']['zwykly']
 * @property string $t['modul_typy']['jednorazowy']
 * @property string $t['modul_typy']['blok']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'administracyjne.tytul_strony' => 'Administrative modules',

		'czyscAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'This module is not administrative',
		'czyscAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscAdministracyjny.blad_nie_mozna_usunac_wierszy' => 'Cannot restore module default configuration',
		'czyscAdministracyjny.info_usunieto_wiersze' => 'Module default configuration restored',

		'czyscBlok.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscBlok.blad_nie_mozna_usunac_wierszy' => 'Cannot restore block default configuration',
		'czyscBlok.blad_nieprawidlowy_blok' => 'Cannot obtain block data',
		'czyscBlok.info_usunieto_wiersze' => 'Block default configuration restored',

		'czyscKategorie.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscKategorie.blad_nie_mozna_usunac_wierszy' => 'Cannot restore category default configuration.',
		'czyscKategorie.blad_nieprawidlowa_kategoria' => 'Cannot obtain category data',
		'czyscKategorie.info_usunieto_wiersze' => 'Module default configuration for the category restored',

		'czyscSystem.blad_nie_mozna_usunac_wierszy' => 'Cannot restore system default configuration',
		'czyscSystem.info_usunieto_wiersze' => 'System default configuration restored',

		'czyscZwykly.blad_modul_nie_przypisany_do_projektu' => 'This module is not attached to this project',
		'czyscZwykly.blad_modulu_nie_jest_zwykly' => 'Not allowed. This is not regular module',
		'czyscZwykly.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscZwykly.blad_nie_mozna_usunac_wierszy' => 'Cannot restore module default configuration',
		'czyscZwykly.info_usunieto_wiersze' => 'Module default configuration restored',

		'edytujAdministracyjny.blad_brak_uprawnien_do_modulu' => 'Dont have access to this module',
		'edytujAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'This is not administrative module',
		'edytujAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujAdministracyjny.etykieta_link_czysc' => 'Restore default',
		'edytujAdministracyjny.info_modul_nie_posiada_konfiguracji' => 'This module has no configuration',
		'edytujAdministracyjny.tytul_strony' => 'Configuration of module: "%s"',

		'edytujBlok.blad_modul_nie_przypisany_do_projektu' => 'This module is not attached to this project',
		'edytujBlok.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujBlok.blad_nieprawidlowy_blok' => 'Cannot obtain block data',
		'edytujBlok.etykieta_link_czysc' => 'Restore default',
		'edytujBlok.etykieta_pobierz_konfiguracje' => 'Export configuration',
		'edytujBlok.etykieta_wczytaj_konfiguracje' => 'Import configuration',
		'edytujBlok.info_modul_nie_posiada_konfiguracji' => 'This module has no configuration',
		'edytujBlok.tytul_strony' => 'Configuration of module for block:  "%s"',

		'edytujKategorie.blad_modul_nie_przypisany_do_projektu' => 'This module is not attached to this project',
		'edytujKategorie.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujKategorie.blad_nieprawidlowa_kategoria' => 'Cannot obtain category data',
		'edytujKategorie.etykieta_link_czysc' => 'Restore default',
		'edytujKategorie.info_modul_nie_posiada_konfiguracji' => 'This module has no configuration',
		'edytujKategorie.tytul_strony' => 'Configuration of module for category: "%s"',

		'edytujZwykly.blad_modul_nie_przypisany_do_projektu' => 'This module is not attached to this project',
		'edytujZwykly.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujZwykly.etykieta_link_czysc' => 'Restore default',
		'edytujZwykly.info_modul_nie_posiada_konfiguracji' => 'This module has no configuration',
		'edytujZwykly.tytul_strony' => 'Configuration of module: "%s"',

		'formularz.etykieta_link_czysc' => 'Restore default',
		'formularz.etykieta_wstecz' => 'Cancel',
		'formularz.etykieta_zapisz' => 'Save',

		'index.etykieta_fraza' => 'Search phrase',
		'index.etykieta_globalne' => 'Global variables configuration',
		'index.etykieta_link_globalne' => 'Global variables configuration',
		'index.etykieta_link_konfiguracja' => 'Export configuration',
		'index.etykieta_link_konfiguracja_systemu_czysc' => 'Restore default',
		'index.etykieta_link_konfiguracja_systemu_czysc_potwierdzenie' => 'Are you sure you want to restore default configuration? All changes will be lost',
		'index.etykieta_link_moduly_administracyjne' => 'Module list',
		'index.etykieta_link_moduly_zwykle' => 'Module list',
		'index.etykieta_link_system' => 'Edit configuration',
		'index.etykieta_moduly_administracyjne' => 'Administrative modules configuration',
		'index.etykieta_moduly_zwykle' => 'Regular modules configuration',
		'index.etykieta_system' => 'System configuration',
		'index.etykieta_szukaj' => 'Search',
		'index.etykieta_wyszukiwarka' => 'Search for configuration',
		'index.opis_globalne' => 'Setup the global variables so it can be used in pages content',
		'index.opis_moduly_administracyjne' => 'Administrative modules configuration (Application structure, users, access control,...).',
		'index.opis_moduly_zwykle' => 'Regular modules configuration. Low level setting will be replaced with configuration for blocks and for categories',
		'index.opis_system' => 'General system configuration. Has configuration features for: errors handling, sessions, access control, mailing, etc.',
		'index.tytul_strony' => 'Configuration',

		'modul.tytul_strony' => 'Module configuration %s',

		'system.blad_nie_mozna_zapisac_wiersza' => 'Cannot save row: "%s"',
		'system.error_nie_mozna_zapisac_wierszy' => 'Configuration cannot be saved',
		'system.info_zapisano_wiersze' => 'Rows modified: %d',
		'system.tytul_strony' => 'System configuration',

		'szukajFrazy.blad.fraza_zbyt_krotka' => 'Entered search phrase too short',
		'szukajFrazy.etykieta_button_edytuj' => 'Edit',
		'szukajFrazy.etykieta_dotyczy' => 'concerns',
		'szukajFrazy.etykieta_dotyczy_bloku' => 'Block ',
		'szukajFrazy.etykieta_dotyczy_globalne' => 'Global',
		'szukajFrazy.etykieta_dotyczy_kategorii' => 'Category ',
		'szukajFrazy.etykieta_nazwa' => 'Label name',
		'szukajFrazy.etykieta_wartosc' => 'Value',
		'szukajFrazy.naglowek_modulu' => '<span class="icon"><i class="icon-search"></i></span><h5>%s</h5>',
		'szukajFrazy.nie_znaleziono' => 'Search phrase not found',
		'szukajFrazy.tytul_strony' => 'Search results for search phrase: "%s"',

		'tabela.etykieta_edytuj' => 'Edit',
		'tabela.etykieta_input_czysc' => 'Clear',
		'tabela.etykieta_input_fraza' => 'Search phrase',
		'tabela.etykieta_input_szukaj' => 'Search',
		'tabela.etykieta_input_typ' => 'Module type',
		'tabela.etykieta_nazwa' => 'Module name',
		'tabela.etykieta_select_wybierz' => '- pick one -',
		'tabela.etykieta_typ' => 'Module type',

		'wczytajKonfiguracje.blad_nie_wczytano_konfiguracji' => 'Cannot read configuration',
		'wczytajKonfiguracje.plik.etykieta' => 'Import configuration',
		'wczytajKonfiguracje.plik.opis' => '',
		'wczytajKonfiguracje.tytul_strony' => 'Import configuration',
		'wczytajKonfiguracje.wczytano_konfiguracje' => 'Configuration loaded properly',
		'wczytajKonfiguracje.zapisz.wartosc' => 'Load',

		'zmienneGlobalne.blad_kluczy' => 'You cannot use restricted keys in user configuration',
		'zmienneGlobalne.blad_systemowe' => 'The table of global or system variables in not exact to the original one',
		'zmienneGlobalne.nie_zapisano' => 'Error while saving global variables',
		'zmienneGlobalne.opis_globalnych' => 'This table contains global variables in form of: $key => $value. Inserted {$key} on the page will be replaced with appropriate value.',
		'zmienneGlobalne.opis_globalnych_systemowych' => 'This table contains global system variables in form of: $key => $value. Inserted {$key} in derired place and it will be replaced with appropriate value.',
		'zmienneGlobalne.opis_globalnych_zarezerwowanych' => 'Restricted global varibles if form of: $key => $value. Insert {$key} in desired place an it will be replaced with appriopriate value.',
		'zmienneGlobalne.tablica_globalnych' => 'User global variables',
		'zmienneGlobalne.tablica_globalnych_systemowych' => 'System global variables',
		'zmienneGlobalne.tablica_globalnych_zarezerwowanych' => 'Restricted global variables',
		'zmienneGlobalne.zapisano' => 'The table of global variables was synchronised',

		'zwykle.tytul_strony' => 'Modules attached to the project',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Configuration main screen',
			'wykonajSystem' => 'System configuration',
			'wykonajAdministracyjne' => 'Administrative modules',
			'wykonajZwykle' => 'Regular modules',
			'wykonajEdytujAdministracyjny' => 'Edit administartive module',
			'wykonajEdytujZwykly' => 'Edit regular module',
			'wykonajEdytujKategorie' => 'Edit module for certain category',
			'wykonajEdytujBlok' => 'Edit regular module for block',
			'wykonajCzyscSystem' => 'Restore system configuration',
			'wykonajCzyscAdministracyjny' => 'Restore default configuration for administrative module',
			'wykonajCzyscZwykly' => 'Restore default configuration for regular module',
			'wykonajCzyscKategorie' => 'Restore default configuration for regular module attached with certain category',
			'wykonajCzyscBlok' => 'Restore default configuration for blocks',
			'wykonajZmienneGlobalne' => 'Global variables',
			'wykonajPobierzKonfiguracje' => 'Save configuration to file',
			'wykonajWczytajKonfiguracje' => 'Load configuration',
			'wykonajSzukajFrazy' => 'Search for configuration',
			'opcjeSystemowe' => 'Edit system configuration',
		),

		'modul_typy' => array(
			'administracyjny' => 'Administrative',
			'zwykly' => 'Regular',
			'jednorazowy' => 'Singular',
			'blok' => 'Block',
		),
	);
}

<?php
namespace Generic\Tlumaczenie\En\Modul\UstawieniaJezykowe;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['administracyjne.tytul_strony']
 * @property string $t['biblioteki.blad_nie_mozna_zapisac_wiersza']
 * @property string $t['biblioteki.info_zapisano_wiersze']
 * @property string $t['biblioteki.tytul_strony']
 * @property string $t['czyscAdministracyjny.blad_modulu_nie_jest_administracyjny']
 * @property string $t['czyscAdministracyjny.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscAdministracyjny.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscAdministracyjny.info_usunieto_wiersze']
 * @property string $t['czyscBiblioteki.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscBiblioteki.info_usunieto_wiersze']
 * @property string $t['czyscBlok.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscBlok.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscBlok.blad_nieprawidlowy_blok']
 * @property string $t['czyscBlok.info_usunieto_wiersze']
 * @property string $t['czyscKategorie.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscKategorie.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscKategorie.blad_nieprawidlowa_kategoria']
 * @property string $t['czyscKategorie.info_usunieto_wiersze']
 * @property string $t['czyscZwykly.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['czyscZwykly.blad_modulu_nie_jest_zwykly']
 * @property string $t['czyscZwykly.blad_nie_mozna_pobrac_modulu']
 * @property string $t['czyscZwykly.blad_nie_mozna_usunac_wierszy']
 * @property string $t['czyscZwykly.info_usunieto_wiersze']
 * @property string $t['edytujAdministracyjny.blad_brak_uprawnien_do_modulu']
 * @property string $t['edytujAdministracyjny.blad_modulu_nie_jest_administracyjny']
 * @property string $t['edytujAdministracyjny.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujAdministracyjny.etykieta_link_czysc']
 * @property string $t['edytujAdministracyjny.info_modul_nie_posiada_tlumaczen']
 * @property string $t['edytujAdministracyjny.tytul_strony']
 * @property string $t['edytujBlok.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujBlok.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujBlok.blad_nieprawidlowy_blok']
 * @property string $t['edytujBlok.etykieta_link_czysc']
 * @property string $t['edytujBlok.info_modul_nie_posiada_tlumaczen']
 * @property string $t['edytujBlok.tytul_strony']
 * @property string $t['edytujKategorie.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujKategorie.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujKategorie.blad_nieprawidlowa_kategoria']
 * @property string $t['edytujKategorie.etykieta_link_czysc']
 * @property string $t['edytujKategorie.info_modul_nie_posiada_tlumaczen']
 * @property string $t['edytujKategorie.tytul_strony']
 * @property string $t['edytujZwykly.blad_modul_nie_przypisany_do_projektu']
 * @property string $t['edytujZwykly.blad_nie_mozna_pobrac_modulu']
 * @property string $t['edytujZwykly.etykieta_link_czysc']
 * @property string $t['edytujZwykly.info_modul_nie_posiada_tlumaczen']
 * @property string $t['edytujZwykly.tytul_strony']
 * @property string $t['formularz.etykieta_link_czysc']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_biblioteki']
 * @property string $t['index.etykieta_fraza']
 * @property string $t['index.etykieta_link_biblioteki']
 * @property string $t['index.etykieta_link_czysc_biblioteki']
 * @property string $t['index.etykieta_link_czysc_biblioteki_potwierdzenie']
 * @property string $t['index.etykieta_link_moduly_administracyjne']
 * @property string $t['index.etykieta_link_moduly_zwykle']
 * @property string $t['index.etykieta_link_tlumaczenia']
 * @property string $t['index.etykieta_moduly_administracyjne']
 * @property string $t['index.etykieta_moduly_zwykle']
 * @property string $t['index.etykieta_szukaj']
 * @property string $t['index.etykieta_wyszukiwarka']
 * @property string $t['index.opis_biblioteki']
 * @property string $t['index.opis_moduly_administracyjne']
 * @property string $t['index.opis_moduly_zwykle']
 * @property string $t['index.tytul_strony']
 * @property string $t['modul.tytul_strony']
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
 * @property string $t['tabela.czysc.wartosc']
 * @property string $t['tabela.etykieta_edytuj']
 * @property string $t['tabela.etykieta_nazwa']
 * @property string $t['tabela.etykieta_select_wybierz']
 * @property string $t['tabela.etykieta_typ']
 * @property string $t['tabela.fraza.etykieta']
 * @property string $t['tabela.szukaj.wartosc']
 * @property string $t['tabela.typ.etykieta']
 * @property string $t['zwykle.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajSystem']
 * @property string $t['_akcje_etykiety_']['wykonajBiblioteki']
 * @property string $t['_akcje_etykiety_']['wykonajAdministracyjne']
 * @property string $t['_akcje_etykiety_']['wykonajZwykle']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujAdministracyjny']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujZwykly']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujKategorie']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujBlok']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscBiblioteki']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscSystem']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscAdministracyjny']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscZwykly']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscKategorie']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscBlok']
 * @property string $t['_akcje_etykiety_']['wykonajSzukajFrazy']
 * @property string $t['_akcje_etykiety_']['opcjeSystemowe']
 * @property array $t['tabela.modul_typy']
 * @property string $t['tabela.modul_typy']['administracyjny']
 * @property string $t['tabela.modul_typy']['zwykly']
 * @property string $t['tabela.modul_typy']['jednorazowy']
 * @property string $t['tabela.modul_typy']['blok']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'administracyjne.tytul_strony' => 'Administrative modules',

		'biblioteki.blad_nie_mozna_zapisac_wiersza' => 'Cannot save row "%s"',
		'biblioteki.info_zapisano_wiersze' => 'Modified %d of translations rows',
		'biblioteki.tytul_strony' => 'Library translations',

		'czyscAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'Module in not administrative',
		'czyscAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscAdministracyjny.blad_nie_mozna_usunac_wierszy' => 'Cannot restore default translations for module',
		'czyscAdministracyjny.info_usunieto_wiersze' => 'Default translations for module restored',

		'czyscBiblioteki.blad_nie_mozna_usunac_wierszy' => 'Cannot restore default library translations',
		'czyscBiblioteki.info_usunieto_wiersze' => 'Default library translations restored',

		'czyscBlok.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscBlok.blad_nie_mozna_usunac_wierszy' => 'Cannot restore block default translation',
		'czyscBlok.blad_nieprawidlowy_blok' => 'Cannot obtain block data',
		'czyscBlok.info_usunieto_wiersze' => 'Default block translation restored',

		'czyscKategorie.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscKategorie.blad_nie_mozna_usunac_wierszy' => 'Cannot restore category default translations',
		'czyscKategorie.blad_nieprawidlowa_kategoria' => 'Cannot obtain category data',
		'czyscKategorie.info_usunieto_wiersze' => 'Default category translations restored',

		'czyscZwykly.blad_modul_nie_przypisany_do_projektu' => 'Module is not related with this project',
		'czyscZwykly.blad_modulu_nie_jest_zwykly' => 'Not regular module',
		'czyscZwykly.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'czyscZwykly.blad_nie_mozna_usunac_wierszy' => 'Cannot restore module default translations',
		'czyscZwykly.info_usunieto_wiersze' => 'Default module translations restored',

		'edytujAdministracyjny.blad_brak_uprawnien_do_modulu' => 'You don\'t have access to this module',
		'edytujAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'Not administrative module',
		'edytujAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujAdministracyjny.etykieta_link_czysc' => 'Restore default',
		'edytujAdministracyjny.info_modul_nie_posiada_tlumaczen' => 'This module has no translations',
		'edytujAdministracyjny.tytul_strony' => 'Module translations "%s"',

		'edytujBlok.blad_modul_nie_przypisany_do_projektu' => 'Module is not related to this project',
		'edytujBlok.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujBlok.blad_nieprawidlowy_blok' => 'Cannot obtain block data',
		'edytujBlok.etykieta_link_czysc' => 'Restore default',
		'edytujBlok.info_modul_nie_posiada_tlumaczen' => 'This module has no translations',
		'edytujBlok.tytul_strony' => 'Module blocks translations "%s"',

		'edytujKategorie.blad_modul_nie_przypisany_do_projektu' => 'Module is not related to this project',
		'edytujKategorie.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujKategorie.blad_nieprawidlowa_kategoria' => 'Cannot obtain category data',
		'edytujKategorie.etykieta_link_czysc' => 'Restor default',
		'edytujKategorie.info_modul_nie_posiada_tlumaczen' => 'This module has no translations',
		'edytujKategorie.tytul_strony' => 'Module category translations "%s"',

		'edytujZwykly.blad_modul_nie_przypisany_do_projektu' => 'Module is not related to this project',
		'edytujZwykly.blad_nie_mozna_pobrac_modulu' => 'Cannot obtain module data',
		'edytujZwykly.etykieta_link_czysc' => 'Restore default',
		'edytujZwykly.info_modul_nie_posiada_tlumaczen' => 'This module has no translations',
		'edytujZwykly.tytul_strony' => 'Module translations "%s"',

		'formularz.etykieta_link_czysc' => 'Restore default',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.zapisz.wartosc' => 'Save',

		'index.etykieta_biblioteki' => 'Library translations',
		'index.etykieta_fraza' => 'Search phrase',
		'index.etykieta_link_biblioteki' => 'Edit translations',
		'index.etykieta_link_czysc_biblioteki' => 'Restore default',
		'index.etykieta_link_czysc_biblioteki_potwierdzenie' => 'Are sure you want to restore libraries default translations?',
		'index.etykieta_link_moduly_administracyjne' => 'Module list',
		'index.etykieta_link_moduly_zwykle' => 'Module list',
		'index.etykieta_link_tlumaczenia' => 'Export translations',
		'index.etykieta_moduly_administracyjne' => 'Administrative modules translations',
		'index.etykieta_moduly_zwykle' => 'Regular modules translations',
		'index.etykieta_szukaj' => 'Search',
		'index.etykieta_wyszukiwarka' => 'Translations search',
		'index.opis_biblioteki' => 'Library translations. It contains translations of forms, validators, pagers etc.',
		'index.opis_moduly_administracyjne' => 'Administrative modules translations. Translations for those modules available only here.',
		'index.opis_moduly_zwykle' => 'Regular modules translations. Can be overriden by category',
		'index.tytul_strony' => 'Translations',

		'modul.tytul_strony' => 'Module translation %s',

		'szukajFrazy.blad.fraza_zbyt_krotka' => 'Search phrase too short',
		'szukajFrazy.etykieta_button_edytuj' => 'Edit',
		'szukajFrazy.etykieta_dotyczy' => 'Concerns',
		'szukajFrazy.etykieta_dotyczy_bloku' => 'Block ',
		'szukajFrazy.etykieta_dotyczy_globalne' => 'Global',
		'szukajFrazy.etykieta_dotyczy_kategorii' => 'Category ',
		'szukajFrazy.etykieta_nazwa' => 'Label name',
		'szukajFrazy.etykieta_wartosc' => 'Value',
		'szukajFrazy.naglowek_modulu' => '<strong>%s</strong>',
		'szukajFrazy.nie_znaleziono' => 'Search phrase not found',
		'szukajFrazy.tytul_strony' => 'Search results "%s"',

		'tabela.czysc.wartosc' => 'Clear',
		'tabela.etykieta_edytuj' => 'Edit',
		'tabela.etykieta_nazwa' => 'Module name',
		'tabela.etykieta_select_wybierz' => '- select -',
		'tabela.etykieta_typ' => 'Module type',
		'tabela.fraza.etykieta' => 'Search phrase',
		'tabela.szukaj.wartosc' => 'Search',
		'tabela.typ.etykieta' => 'Module type',

		'zwykle.tytul_strony' => 'Modules related to this project',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Translations main screen',
			'wykonajSystem' => 'System\'s translations',
			'wykonajBiblioteki' => 'Libraries translations',
			'wykonajAdministracyjne' => 'Administrative modules translations',
			'wykonajZwykle' => 'Regular modules translations',
			'wykonajEdytujAdministracyjny' => 'Edit administrative modules translations',
			'wykonajEdytujZwykly' => 'Edit modules translations',
			'wykonajEdytujKategorie' => 'Edit category translations',
			'wykonajEdytujBlok' => 'Edit blocks translations',
			'wykonajCzyscBiblioteki' => 'Reset library translations',
			'wykonajCzyscSystem' => 'Reset system translations',
			'wykonajCzyscAdministracyjny' => 'Reset administrative modules translations',
			'wykonajCzyscZwykly' => 'Reset module translationsh',
			'wykonajCzyscKategorie' => 'Reset category translations',
			'wykonajCzyscBlok' => 'Reset block translations',
			'wykonajSzukajFrazy' => 'Search for translations',
			'opcjeSystemowe' => 'Edit restricted settings',
		),

		'tabela.modul_typy' => array(
			'administracyjny' => 'Administrative',
			'zwykly' => 'Regular',
			'jednorazowy' => 'Singular',
			'blok' => 'Block',
		),
	);
}

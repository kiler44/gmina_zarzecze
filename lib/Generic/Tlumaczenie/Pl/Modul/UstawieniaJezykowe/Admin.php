<?php
namespace Generic\Tlumaczenie\Pl\Modul\UstawieniaJezykowe;

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

		'administracyjne.tytul_strony' => 'Moduły administracyjne',

		'biblioteki.blad_nie_mozna_zapisac_wiersza' => 'Nie można zapisać wiersza "%s"',
		'biblioteki.info_zapisano_wiersze' => 'Zmodyfikowano %d wierszy tłumaczeń',
		'biblioteki.tytul_strony' => 'Tłumaczenia bibliotek',

		'czyscAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'Moduł nie jest administracyjny',
		'czyscAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscAdministracyjny.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić domyslnych tlumaczeń dla modułu',
		'czyscAdministracyjny.info_usunieto_wiersze' => 'Przywrócono domyślne tłumaczenia modułu.',

		'czyscBiblioteki.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić domyślnych tłumaczeń dla bibliotek.',
		'czyscBiblioteki.info_usunieto_wiersze' => 'Przywrócono domyślne tłumaczenia dla bibliotek.',

		'czyscBlok.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscBlok.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić domyslnych tlumaczeń dla bloku.',
		'czyscBlok.blad_nieprawidlowy_blok' => 'Nie można pobrać bloku',
		'czyscBlok.info_usunieto_wiersze' => 'Przywrócono domyślne tłumaczenia modułu dla bloku.',

		'czyscKategorie.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscKategorie.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić domyslnych tlumaczeń dla kategorii.',
		'czyscKategorie.blad_nieprawidlowa_kategoria' => 'Nie można pobrać kategorii',
		'czyscKategorie.info_usunieto_wiersze' => 'Przywrócono domyślne tłumaczenia modułu dla kategorii.',

		'czyscZwykly.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'czyscZwykly.blad_modulu_nie_jest_zwykly' => 'Moduł nie jest zwykły',
		'czyscZwykly.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'czyscZwykly.blad_nie_mozna_usunac_wierszy' => 'Nie można przywrócić domyslnych tlumaczeń dla modułu.',
		'czyscZwykly.info_usunieto_wiersze' => 'Przywrócono domyślne tłumaczenia modułu.',

		'edytujAdministracyjny.blad_brak_uprawnien_do_modulu' => 'Brak uprawnień do modułu',
		'edytujAdministracyjny.blad_modulu_nie_jest_administracyjny' => 'To nie jest moduł administracyjny',
		'edytujAdministracyjny.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujAdministracyjny.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujAdministracyjny.info_modul_nie_posiada_tlumaczen' => 'Moduł nie posiada tłumaczeń.',
		'edytujAdministracyjny.tytul_strony' => 'Tłumaczenia modulu "%s"',

		'edytujBlok.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'edytujBlok.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujBlok.blad_nieprawidlowy_blok' => 'Nie można pobrać danych bloku.',
		'edytujBlok.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujBlok.info_modul_nie_posiada_tlumaczen' => 'Moduł nie posiada tłumaczeń.',
		'edytujBlok.tytul_strony' => 'Tłumaczenia modulu dla bloku "%s"',

		'edytujKategorie.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'edytujKategorie.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujKategorie.blad_nieprawidlowa_kategoria' => 'Nie można pobrać kategorii.',
		'edytujKategorie.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujKategorie.info_modul_nie_posiada_tlumaczen' => 'Moduł nie posiada tłumaczeń.',
		'edytujKategorie.tytul_strony' => 'Tłumaczenia modulu dla kategorii "%s"',

		'edytujZwykly.blad_modul_nie_przypisany_do_projektu' => 'Moduł nie jest przypisany do projektu',
		'edytujZwykly.blad_nie_mozna_pobrac_modulu' => 'Nie można pobrać modułu',
		'edytujZwykly.etykieta_link_czysc' => 'Przywróć domyślną',
		'edytujZwykly.info_modul_nie_posiada_tlumaczen' => 'Moduł nie posiada tłumaczeń.',
		'edytujZwykly.tytul_strony' => 'Tłumaczenia modulu "%s"',

		'formularz.etykieta_link_czysc' => 'Przywróć domyślną',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'index.etykieta_biblioteki' => 'Tłumaczenia bibliotek',
		'index.etykieta_fraza' => 'Szukana fraza',
		'index.etykieta_link_biblioteki' => 'Edycja tłumaczeń',
		'index.etykieta_link_czysc_biblioteki' => 'Przywróć domyślne',
		'index.etykieta_link_czysc_biblioteki_potwierdzenie' => 'Czy jesteś pewien, że chcesz przywrócić domyślne tłumaczenia bibliotek?',
		'index.etykieta_link_moduly_administracyjne' => 'Lista modułów',
		'index.etykieta_link_moduly_zwykle' => 'Lista modułów',
		'index.etykieta_link_tlumaczenia' => 'Pobierz tłumaczenia',
		'index.etykieta_moduly_administracyjne' => 'Tłumaczenia modułów administracyjnych',
		'index.etykieta_moduly_zwykle' => 'Tłumaczenia modułów zwykłych',
		'index.etykieta_szukaj' => 'Szukaj',
		'index.etykieta_wyszukiwarka' => 'Wyszukiwarka tłumaczeń',
		'index.opis_biblioteki' => 'Tłumaczenia bibliotek systemu. Zawiera tłumaczenia dla błędów, formularzy, walidatorów, itd.',
		'index.opis_moduly_administracyjne' => 'Tłumaczenia modułów administracyjnych(Stuktura serwisu, użytkownicy, uprawnienia,...). Mogą one być ustawiane tylko tutaj.',
		'index.opis_moduly_zwykle' => 'Tłumaczenia modułów zwykłych. Opcje ustawiane tutaj mogą być nadpisane w ustawieniach kategorii i bloków.',
		'index.tytul_strony' => 'Tłumaczenia CMS-a',

		'modul.tytul_strony' => 'Tłumaczenia modułu %s',

		'szukajFrazy.blad.fraza_zbyt_krotka' => 'Wpisana fraza jest zbyt krótka',
		'szukajFrazy.etykieta_button_edytuj' => 'Edytuj',
		'szukajFrazy.etykieta_dotyczy' => 'Dotyczy',
		'szukajFrazy.etykieta_dotyczy_bloku' => 'Bloku ',
		'szukajFrazy.etykieta_dotyczy_globalne' => 'Globalne',
		'szukajFrazy.etykieta_dotyczy_kategorii' => 'Kategorii ',
		'szukajFrazy.etykieta_nazwa' => 'Nazwa etykiety',
		'szukajFrazy.etykieta_wartosc' => 'Wartość',
		'szukajFrazy.naglowek_modulu' => '<strong>%s</strong>',
		'szukajFrazy.nie_znaleziono' => 'Nie znaleziono poszukiwanej frazy',
		'szukajFrazy.tytul_strony' => 'Wyniki wyszukiwania frazy "%s"',

		'tabela.czysc.wartosc' => 'Czyść',
		'tabela.etykieta_edytuj' => 'Edytuj',
		'tabela.etykieta_nazwa' => 'Nazwa modułu',
		'tabela.etykieta_select_wybierz' => '- wybierz -',
		'tabela.etykieta_typ' => 'Typ modułu',
		'tabela.fraza.etykieta' => 'Szukana fraza',
		'tabela.szukaj.wartosc' => 'Szukaj',
		'tabela.typ.etykieta' => 'Typ modułu',

		'zwykle.tytul_strony' => 'Moduły przypisane do projektu',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Ekran startowy edycji tłumaczeń',
			'wykonajSystem' => 'Tłumaczenia systemowe',
			'wykonajBiblioteki' => 'Tłumaczenia bibliotek',
			'wykonajAdministracyjne' => 'Tłumaczenia modułów admnistracyjnych',
			'wykonajZwykle' => 'Tłumaczenia modułów zwykłych',
			'wykonajEdytujAdministracyjny' => 'Edycja tłumaczeń modułów administracyjnych',
			'wykonajEdytujZwykly' => 'Edycja tłumaczeń modułów zwykłych',
			'wykonajEdytujKategorie' => 'Edycja tłumaczeń dla kategorii',
			'wykonajEdytujBlok' => 'Edycja tłumaczeń dla bloków',
			'wykonajCzyscBiblioteki' => 'Reset tłumaczeń bibliotek',
			'wykonajCzyscSystem' => 'Reset tłumaczeń systemowych',
			'wykonajCzyscAdministracyjny' => 'Reset tłumaczeń modułów administracyjnych',
			'wykonajCzyscZwykly' => 'Reset tłumaczeń modułów zwykłych',
			'wykonajCzyscKategorie' => 'Reset tłumaczeń dla kategorii',
			'wykonajCzyscBlok' => 'Reset tłumaczeń dla bloków',
			'wykonajSzukajFrazy' => 'Wyszukiwanie tłumaczeń w systemie',
			'opcjeSystemowe' => 'Edycja opcji zastrzeżonych',
		),

		'tabela.modul_typy' => array(
			'administracyjny' => 'Administracyjny',
			'zwykly' => 'Zwykły',
			'jednorazowy' => 'Zwykły Jednorazowy',
			'blok' => 'Blok',
		),
	);
}

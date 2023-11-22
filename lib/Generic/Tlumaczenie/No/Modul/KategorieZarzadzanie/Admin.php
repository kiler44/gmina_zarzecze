<?php
namespace Generic\Tlumaczenie\No\Modul\KategorieZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['czysc.blad_nie mozna_usunac_drzewa_kategorii']
 * @property string $t['czysc.info_usunieto_drzewo_kategorii']
 * @property string $t['czyscStaryUrl.blad_nie_wyczyszczono_url']
 * @property string $t['czyscStaryUrl.info_wyczyszczono_url']
 * @property string $t['dodaj.blad_brak_kategorii_nadrzednej']
 * @property string $t['dodaj.blad_kod_zajety']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_kategorii']
 * @property string $t['dodaj.info_zapisano_dane_kategorii']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_kategorii']
 * @property string $t['edytuj.blad_kod_kategorii_zajety']
 * @property string $t['edytuj.blad_nie_mozna_edytowac_kategorii']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_kategorii']
 * @property string $t['edytuj.info_zapisano_dane_kategorii']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.adresZewnetrzny.etykieta']
 * @property string $t['formularz.adresZewnetrzny.opis']
 * @property string $t['formularz.akcjaKlasa.etykieta']
 * @property string $t['formularz.akcjaKlasa.opis']
 * @property string $t['formularz.akcjaKontener.etykieta']
 * @property string $t['formularz.akcjaKontener.opis']
 * @property string $t['formularz.akcjaSzablon.etykieta']
 * @property string $t['formularz.akcjaSzablon.opis']
 * @property string $t['formularz.akcjaUkladStrony.etykieta']
 * @property string $t['formularz.akcjaUkladStrony.opis']
 * @property string $t['formularz.blad_nie_przypisano_modulow_do_projektu']
 * @property string $t['formularz.blad_nie_utworzono_widokow']
 * @property string $t['formularz.blokada.etykieta']
 * @property string $t['formularz.blokada.opis']
 * @property string $t['formularz.cache.etykieta']
 * @property string $t['formularz.cache.opis']
 * @property string $t['formularz.czasCache.etykieta']
 * @property string $t['formularz.czasCache.opis']
 * @property string $t['formularz.czyWidoczna.etykieta']
 * @property string $t['formularz.czyWidoczna.opis']
 * @property string $t['formularz.czyscStaryUrl.wartosc']
 * @property string $t['formularz.dlaZalogowanych.etykieta']
 * @property string $t['formularz.dlaZalogowanych.opis']
 * @property string $t['formularz.etykietaCzysc.etykieta']
 * @property string $t['formularz.etykieta_powrot']
 * @property string $t['formularz.etykieta_region_widok_kategoria']
 * @property string $t['formularz.etykieta_region_widoki_akcje']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_zakladka_kategoria']
 * @property string $t['formularz.etykieta_zakladka_seo']
 * @property string $t['formularz.etykieta_zakladka_wyglad']
 * @property string $t['formularz.idKategorii.etykieta']
 * @property string $t['formularz.idKategorii.opis']
 * @property string $t['formularz.idWidokuZbiorowy.etykieta']
 * @property string $t['formularz.idWidokuZbiorowy.opis']
 * @property string $t['formularz.klasa.etykieta']
 * @property string $t['formularz.klasa.opis']
 * @property string $t['formularz.kodGeneruj.wartosc']
 * @property string $t['formularz.kodKontener.etykieta']
 * @property string $t['formularz.kodKontener.opis']
 * @property string $t['formularz.kodModulu.etykieta']
 * @property string $t['formularz.kodModulu.opis']
 * @property string $t['formularz.kontener.etykieta']
 * @property string $t['formularz.kontener.opis']
 * @property string $t['formularz.link.etykieta']
 * @property string $t['formularz.link.opis']
 * @property string $t['formularz.naglowekHtml.etykieta']
 * @property string $t['formularz.naglowekHtml.opis']
 * @property string $t['formularz.naglowekHttp.etykieta']
 * @property string $t['formularz.naglowekHttp.opis']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.nazwaPrzyjaznaKontener.etykieta']
 * @property string $t['formularz.nazwaPrzyjaznaKontener.opis']
 * @property string $t['formularz.nazwaPrzyjaznaPobierz.wartosc']
 * @property string $t['formularz.nazwa_przyjazna.etykieta']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.opis.opis']
 * @property string $t['formularz.pelnyLink.etykieta']
 * @property string $t['formularz.pelnyLink.opis']
 * @property string $t['formularz.poprawLink.wartosc']
 * @property string $t['formularz.przekieruj.wartosc']
 * @property string $t['formularz.rssWlaczony.etykieta']
 * @property string $t['formularz.rssWlaczony.opis']
 * @property string $t['formularz.skrypt.etykieta']
 * @property string $t['formularz.skrypt.opis']
 * @property string $t['formularz.slowaKluczowe.etykieta']
 * @property string $t['formularz.slowaKluczowe.opis']
 * @property string $t['formularz.staryUrlZbiorowy.etykieta']
 * @property string $t['formularz.staryUrlZbiorowy.opis']
 * @property string $t['formularz.szablon.etykieta']
 * @property string $t['formularz.szablon.opis']
 * @property string $t['formularz.typ.etykieta']
 * @property string $t['formularz.typ.opis']
 * @property string $t['formularz.tytulStrony.etykieta']
 * @property string $t['formularz.tytulStrony.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wymagaHttps.etykieta']
 * @property string $t['formularz.wymagaHttps.opis']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_link_edytuj']
 * @property string $t['index.etykieta_link_pobierz_konfiguracje']
 * @property string $t['index.etykieta_link_przebudowa']
 * @property string $t['index.etykieta_link_przekierowania']
 * @property string $t['index.etykieta_link_sortowanie']
 * @property string $t['index.etykieta_link_tresc']
 * @property string $t['index.etykieta_link_usun']
 * @property string $t['index.etykieta_link_usun_pytanie']
 * @property string $t['index.etykieta_link_usun_wszystkie']
 * @property string $t['index.etykieta_link_usun_wszystkie_pytanie']
 * @property string $t['index.etykieta_link_wczytaj_konfiguracje']
 * @property string $t['index.etykieta_nazwa_kategorii']
 * @property string $t['index.info_nie_dodano_kategorii']
 * @property string $t['index.tytul_strony']
 * @property string $t['kategoria.etykieta_typ_glowna']
 * @property string $t['kategoria.etykieta_typ_kategoria']
 * @property string $t['kategoria.etykieta_typ_link_wewnetrzny']
 * @property string $t['kategoria.etykieta_typ_link_zewnetrzny']
 * @property string $t['kategoria.etykieta_typ_menu']
 * @property string $t['przebudowa.info_nie_mozna_przebudowac_adresow_url']
 * @property string $t['przebudowa.info_nie_mozna_przebudowac_adresu_url']
 * @property string $t['przebudowa.info_nie_utworzono_jeszcze_kategorii']
 * @property string $t['przebudowa.info_przebudowano_adres_url']
 * @property string $t['przebudowa.info_przebudowano_adresy_url']
 * @property string $t['sortowanie.blad_nie_mozna_pobrac_kategorii']
 * @property string $t['sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii']
 * @property string $t['sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii']
 * @property string $t['sortowanie.blad_niepelne_dane_kategorii']
 * @property string $t['sortowanie.blad_nieprawidlowe_dane_kategorii']
 * @property string $t['sortowanie.blad_nieprawidlowe_dane_sasiada']
 * @property string $t['sortowanie.blad_nieprawidlowe_oznaczenie_polozenia']
 * @property string $t['sortowanie.info_zmieniono_rodzica_kategorii']
 * @property string $t['sortowanie.info_zmieniono_ustawienie_kategorii']
 * @property string $t['sortowanie.tytul_strony']
 * @property string $t['usun.blad_brak_kategorii']
 * @property string $t['usun.blad_nie_mozna_usunac_kategorii']
 * @property string $t['usun.info_usunieto_kategorie']
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
 * @property string $t['_akcje_etykiety_']['wykonajSortowanie']
 * @property string $t['_akcje_etykiety_']['wykonajCzysc']
 * @property string $t['_akcje_etykiety_']['wykonajPrzebudowa']
 * @property string $t['_akcje_etykiety_']['wykonajPoprawUrl']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscStaryUrl']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzKonfiguracje']
 * @property string $t['_akcje_etykiety_']['wykonajWczytajKonfiguracje']
 * @property array $t['formularz.cache_przedzialy_czasowe']
 * @property string $t['formularz.cache_przedzialy_czasowe']['0']
 * @property string $t['formularz.cache_przedzialy_czasowe']['60']
 * @property string $t['formularz.cache_przedzialy_czasowe']['300']
 * @property string $t['formularz.cache_przedzialy_czasowe']['900']
 * @property string $t['formularz.cache_przedzialy_czasowe']['1800']
 * @property string $t['formularz.cache_przedzialy_czasowe']['3600']
 * @property string $t['formularz.cache_przedzialy_czasowe']['14400']
 * @property string $t['formularz.cache_przedzialy_czasowe']['86400']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'czysc.blad_nie mozna_usunac_drzewa_kategorii' => 'You canntot clear application structure',
		'czysc.info_usunieto_drzewo_kategorii' => 'Application structure has been cleared!',

		'czyscStaryUrl.blad_nie_wyczyszczono_url' => 'Previous url couldn\'t be deleted',
		'czyscStaryUrl.info_wyczyszczono_url' => 'Previous url has been cleared',

		'dodaj.blad_brak_kategorii_nadrzednej' => 'Pick a patent item first' ,
		'dodaj.blad_kod_zajety' => 'Chosen code is already in use',
		'dodaj.blad_nie_mozna_zapisac_kategorii' => 'Page data cannot be saved',
		'dodaj.info_zapisano_dane_kategorii' => 'New page has been added',
		'dodaj.tytul_strony' => 'New page',

		'edytuj.blad_brak_kategorii' => 'The page data cannot be obtained',
		'edytuj.blad_kod_kategorii_zajety' => 'The chosen code is already in use',
		'edytuj.blad_nie_mozna_edytowac_kategorii' => 'This page cannot be edited',
		'edytuj.blad_nie_mozna_zapisac_kategorii' => 'page data cannot be saved',
		'edytuj.info_zapisano_dane_kategorii' => 'Page data is now up to date',
		'edytuj.tytul_strony' => 'Page edition',

		'formularz.adresZewnetrzny.etykieta' => 'External address',
		'formularz.adresZewnetrzny.opis' => '',
		'formularz.akcjaKlasa.etykieta' => 'Assign CSS classes to actions',
		'formularz.akcjaKlasa.opis' => '',
		'formularz.akcjaKontener.etykieta' => 'Assign containers to actions',
		'formularz.akcjaKontener.opis' => '',
		'formularz.akcjaSzablon.etykieta' => 'Assign templates to actions',
		'formularz.akcjaSzablon.opis' => '',
		'formularz.akcjaUkladStrony.etykieta' => 'Assign layouts to actions',
		'formularz.akcjaUkladStrony.opis' => '',
		'formularz.blad_nie_przypisano_modulow_do_projektu' => 'There are no modules available, check application settings',
		'formularz.blad_nie_utworzono_widokow' => 'There are no page layouts yet. You need to create one first',
		'formularz.blokada.etykieta' => 'Don\'t show this category',
		'formularz.blokada.opis' => '',
		'formularz.cache.etykieta' => 'Cache for this category',
		'formularz.cache.opis' => 'Do you want this category to be cached',
		'formularz.czasCache.etykieta' => 'Cache refresh interval',
		'formularz.czasCache.opis' => 'After what time cache will be renewed',
		'formularz.czyWidoczna.etykieta' => 'Visible in menu',
		'formularz.czyWidoczna.opis' => '',
		'formularz.czyscStaryUrl.wartosc' => 'Clear',
		'formularz.dlaZalogowanych.etykieta' => 'Acces for Logged in users only',
		'formularz.dlaZalogowanych.opis' => '',
		'formularz.etykietaCzysc.etykieta' => '',
		'formularz.etykieta_powrot' => 'back to the category list',
		'formularz.etykieta_region_widok_kategoria' => 'Layout for this category',
		'formularz.etykieta_region_widoki_akcje' => 'Layouts for actions',
		'formularz.etykieta_select_wybierz' => ' - pick one - ',
		'formularz.etykieta_zakladka_kategoria' => 'Category',
		'formularz.etykieta_zakladka_seo' => 'SEO',
		'formularz.etykieta_zakladka_wyglad' => 'Appearance',
		'formularz.idKategorii.etykieta' => 'Target page',
		'formularz.idKategorii.opis' => '',
		'formularz.idWidokuZbiorowy.etykieta' => 'Page layout',
		'formularz.idWidokuZbiorowy.opis' => '',
		'formularz.klasa.etykieta' => 'Class',
		'formularz.klasa.opis' => '',
		'formularz.kodGeneruj.wartosc' => 'Generate',
		'formularz.kodKontener.etykieta' => 'Url code',
		'formularz.kodKontener.opis' => '',
		'formularz.kodModulu.etykieta' => 'Module',
		'formularz.kodModulu.opis' => '',
		'formularz.kontener.etykieta' => 'Contents container',
		'formularz.kontener.opis' => '',
		'formularz.link.etykieta' => 'Full Url',
		'formularz.link.opis' => '',
		'formularz.naglowekHtml.etykieta' => 'Page header',
		'formularz.naglowekHtml.opis' => 'Additional content to page headers (meta head)',
		'formularz.naglowekHttp.etykieta' => 'HTTP Headers',
		'formularz.naglowekHttp.opis' => '<strong>Caution!!! Be very carefull.</strong> Enter header, each per line.',
		'formularz.nazwa.etykieta' => 'Category name',
		'formularz.nazwaPrzyjaznaKontener.etykieta' => 'Label visible in left menu',
		'formularz.nazwaPrzyjaznaKontener.opis' => 'This label is only seen in control panel',
		'formularz.nazwaPrzyjaznaPobierz.wartosc' => 'Copy from Category name',
		'formularz.nazwa_przyjazna.etykieta' => '',
		'formularz.ikona.etykieta' => 'Icon',
		'formularz.ikona.opis' => '',
		'formularz.opis.etykieta' => 'Description',
		'formularz.opis.opis' => '',
		'formularz.pelnyLink.etykieta' => '',
		'formularz.pelnyLink.opis' => '',
		'formularz.poprawLink.wartosc' => 'Correct this Url',
		'formularz.przekieruj.wartosc' => 'Edit',
		'formularz.rssWlaczony.etykieta' => 'Publish RSS feed for this page',
		'formularz.rssWlaczony.opis' => '',
		'formularz.skrypt.etykieta' => 'Additional JS script',
		'formularz.skrypt.opis' => 'Script will be added to page footer',
		'formularz.slowaKluczowe.etykieta' => 'Keywords',
		'formularz.slowaKluczowe.opis' => '',
		'formularz.staryUrlZbiorowy.etykieta' => 'Previous Url (preview)',
		'formularz.staryUrlZbiorowy.opis' => 'This feature is in the experimental phase - don\'t use.',
		'formularz.szablon.etykieta' => 'Template',
		'formularz.szablon.opis' => '',
		'formularz.typ.etykieta' => 'Type',
		'formularz.typ.opis' => '',
		'formularz.tytulStrony.etykieta' => 'page title',
		'formularz.tytulStrony.opis' => '',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.wymagaHttps.etykieta' => 'This page will be accesible only via HTTPS',
		'formularz.wymagaHttps.opis' => '',
		'formularz.zapisz.wartosc' => 'Save changes',

		'index.etykieta_link_dodaj' => 'Add new page to this category',
		'index.etykieta_link_edytuj' => 'Edit this page',
		'index.etykieta_link_pobierz_konfiguracje' => 'Obtain actual configuration',
		'index.etykieta_link_przebudowa' => 'All url\'s correction - warning!',
		'index.etykieta_link_przekierowania' => 'Url redirections',
		'index.etykieta_link_sortowanie' => 'Page order',
		'index.etykieta_link_tresc' => 'Edit contents of this page',
		'index.etykieta_link_usun' => 'Remove this page',
		'index.etykieta_link_usun_pytanie' => 'Are you sure you want to remove selected category and all its children - nannot be undone?',
		'index.etykieta_link_usun_wszystkie' => 'Remove all pages - caution!',
		'index.etykieta_link_usun_wszystkie_pytanie' => 'Are you really, really sure you want to remove all the pages?',
		'index.etykieta_link_wczytaj_konfiguracje' => 'Import configuration from file',
		'index.etykieta_nazwa_kategorii' => 'Page name',
		'index.info_nie_dodano_kategorii' => 'There is no correct tree structure. To initialize new tree push "Remove all pages" button',
		'index.tytul_strony' => 'Pages',

		'kategoria.etykieta_typ_glowna' => 'Main page',
		'kategoria.etykieta_typ_kategoria' => 'Subpage',
		'kategoria.etykieta_typ_link_wewnetrzny' => 'Link to subpage',
		'kategoria.etykieta_typ_link_zewnetrzny' => 'Link external page',
		'kategoria.etykieta_typ_menu' => 'Additional menu',

		'przebudowa.info_nie_mozna_przebudowac_adresow_url' => 'All url\' couldn\'t be properly rebuild',
		'przebudowa.info_nie_mozna_przebudowac_adresu_url' => 'Url coudn\'t be fixed',
		'przebudowa.info_nie_utworzono_jeszcze_kategorii' => 'There are no pages yet',
		'przebudowa.info_przebudowano_adres_url' => 'This url has been fixed',
		'przebudowa.info_przebudowano_adresy_url' => 'All the url\'s has been rebuild',

		'sortowanie.blad_nie_mozna_pobrac_kategorii' => 'You passed wrong page data',
		'sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii' => 'You cannot change parent page to this which order is being change',
		'sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii' => 'You cannot edit this page',
		'sortowanie.blad_niepelne_dane_kategorii' => 'Sortable data was somehow wrong ',
		'sortowanie.blad_nieprawidlowe_dane_kategorii' => 'Those pages are not sortable',
		'sortowanie.blad_nieprawidlowe_dane_sasiada' => 'Error. Wrong sibbling data',
		'sortowanie.blad_nieprawidlowe_oznaczenie_polozenia' => 'Wrong posioion of element',
		'sortowanie.info_zmieniono_rodzica_kategorii' => 'You changed parent for this page',
		'sortowanie.info_zmieniono_ustawienie_kategorii' => 'Page changes saved',
		'sortowanie.tytul_strony' => 'Pages sorting',

		'usun.blad_brak_kategorii' => 'Page data cannot be obtained',
		'usun.blad_nie_mozna_usunac_kategorii' => 'You cannot remove this page!',
		'usun.info_usunieto_kategorie' => 'Page has been removed',

		'wczytajKonfiguracje.blad_nie_wczytano_konfiguracji' => '<h3>Export of page configuration was not completed properly.<h3>',
		'wczytajKonfiguracje.etykieta_potwierdz_wczytanie_konfiguracji' => 'Are you sure you want to import this page configuration from file?',
		'wczytajKonfiguracje.niepoprawny_plik' => 'Selected page configuration file is incorrect of corrupted somehow.',
		'wczytajKonfiguracje.plik.etykieta' => 'Send configuration file',
		'wczytajKonfiguracje.plik.opis' => '',
		'wczytajKonfiguracje.tytul_strony' => 'Loadin of configuration file',
		'wczytajKonfiguracje.wczytano_konfiguracje' => '<h3>Layout configuration has been imported succesfully.<h3>',
		'wczytajKonfiguracje.wstecz.wartosc' => 'Back',
		'wczytajKonfiguracje.zapisz.wartosc' => 'Load',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Show pages tree',
			'wykonajDodaj' => 'Add page',
			'wykonajEdytuj' => 'Edit page',
			'wykonajUsun' => 'Remove page',
			'wykonajSortowanie' => 'Page sorting',
			'wykonajCzysc' => 'Remove of all pages',
			'wykonajPrzebudowa' => 'Rapair of all url\'s',
			'wykonajPoprawUrl' => 'Repair of single url',
			'wykonajCzyscStaryUrl' => 'Remove of previous url',
			'wykonajPobierzKonfiguracje' => 'Save of category config file to hard drive',
			'wykonajWczytajKonfiguracje' => 'Configuration import',
		),
		'formularz.cache_przedzialy_czasowe' => array(
			'0' => 'No limit',
			'60' => '1 minute',
			'300' => '5 minutes',
			'900' => '15 minutes',
			'1800' => '30 minutes',
			'3600' => '1 hour',
			'14400' => '4 hours',
			'86400' => '24 hours',
		),
	);
}

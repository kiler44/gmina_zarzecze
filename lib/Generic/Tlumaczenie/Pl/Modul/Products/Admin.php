<?php
namespace Generic\Tlumaczenie\Pl\Modul\Products;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['addBuyedProducts.blad_formularza']
 * @property string $t['addBuyedProducts.blad_zapisu_produktu']
 * @property string $t['addBuyedProducts.brak_parametru_id']
 * @property string $t['addBuyedProducts.produkt_zostal_zapisany']
 * @property string $t['addBuyedProducts.tytul_modulu']
 * @property string $t['addBuyedProducts.tytul_strony']
 * @property string $t['addBuyedProducts.zamowienie_nie_istnieje']
 * @property string $t['addProducts.tytul_modulu']
 * @property string $t['addProducts.tytul_strony']
 * @property string $t['delete.blad_nie_mozna_pobrac_produktu']
 * @property string $t['delete.produkt_usuniety']
 * @property string $t['editBuyedProducts.brak_parametru_id_produktu']
 * @property string $t['editBuyedProducts.produkt_nie_istnieje']
 * @property string $t['editBuyedProducts.tytul_modulu']
 * @property string $t['editBuyedProducts.tytul_strony']
 * @property string $t['editproducts.blad_nie_mozna_pobrac_produktu']
 * @property string $t['editproducts.tytul_modulu']
 * @property string $t['editproducts.tytul_strony']
 * @property string $t['formularz.blad_zapisu_formularz']
 * @property string $t['formularz.blad_zapisu_produktu']
 * @property string $t['formularz.kombinacje.etykieta']
 * @property string $t['formularz.kombinacje.opis']
 * @property string $t['formularz.measureUnit.etykieta']
 * @property string $t['formularz.measureUnit.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisano_produkt']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.fraza.opis']
 * @property string $t['formularzSzukaj.import.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzSzukaj.visible_in_order.etykieta']
 * @property string $t['formularzSzukaj.visible_in_order.opis']
 * @property string $t['formularzSzukaj.visible_in_order_wybierz']
 * @property string $t['gridWyszukaj.etykieta_sortuj_produkty']
 * @property string $t['index.etykieta_brutto_price']
 * @property string $t['index.etykieta_kolejnosc']
 * @property string $t['index.etykieta_measure_unit']
 * @property string $t['index.etykieta_name']
 * @property string $t['index.etykieta_netto_price']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.etykieta_vat']
 * @property string $t['index.okno_dodaj_produkt_naglowek']
 * @property string $t['index.tabela_etykieta_edytuj']
 * @property string $t['index.tabela_etykieta_usun']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['products_addProducts.etykietaMenu']
 * @property string $t['products_index.etykietaMenu']
 * @property string $t['products_trash.etykietaMenu']
 * @property string $t['revert.blad_nie_mozna_pobrac_produktu']
 * @property string $t['revert.etykieta_potwierdz_przywroc']
 * @property string $t['revert.produkt_etykieta_przywroc']
 * @property string $t['revert.produkt_przywrocony_z_kosza']
 * @property string $t['sortujProdukty.error_nie_zmieniono_kolejnosci']
 * @property string $t['sortujProdukty.etykieta_produkt_glowny']
 * @property string $t['sortujProdukty.etykieta_produkt_podrzedny']
 * @property string $t['sortujProdukty.etykieta_sortowane_produkty']
 * @property string $t['sortujProdukty.etykieta_wstecz']
 * @property string $t['sortujProdukty.etykieta_zapisz_kolejnosc']
 * @property string $t['sortujProdukty.komunikat_brak_produktow']
 * @property string $t['sortujProdukty.komunikat_zmieniono_kolejnosc']
 * @property string $t['sortujProdukty.tytul_modulu']
 * @property string $t['sortujProdukty.tytul_strony']
 * @property string $t['sortujProdukty.visible_in_puste']
 * @property string $t['trash.tytul_modulu']
 * @property string $t['trash.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajAddProducts']
 * @property string $t['_akcje_etykiety_']['wykonajDelete']
 * @property string $t['_akcje_etykiety_']['wykonajEditProducts']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
 * @property string $t['_akcje_etykiety_']['wykonajSortujProdukty']
 * @property array $t['formularz.measureUnit_wartosci']
 * @property string $t['formularz.measureUnit_wartosci']['m']
 * @property string $t['formularz.measureUnit_wartosci']['mb']
 * @property string $t['formularz.measureUnit_wartosci']['szt']
 * @property string $t['formularz.measureUnit_wartosci']['h']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'addBuyedProducts.blad_formularza' => 'Nie wszystkie wymagane pola formularz zostały wypełnione poprawnie',
		'addBuyedProducts.blad_zapisu_produktu' => 'Nie udał się zapisać produktu',
		'addBuyedProducts.brak_parametru_id' => 'Nie podano id zamówienia',
		'addBuyedProducts.produkt_zostal_zapisany' => 'Produkt został zapisany',
		'addBuyedProducts.tytul_modulu' => 'Dodaj produkt',
		'addBuyedProducts.tytul_strony' => 'Dodaj produkt',
		'addBuyedProducts.zamowienie_nie_istnieje' => 'Zamówienie do którego próbujesz dodać produkt nie istnieje',
		'addProducts.tytul_modulu' => 'Dodaj produkt',
		'addProducts.tytul_strony' => 'Dodaj produkt',
		'delete.blad_nie_mozna_pobrac_produktu' => 'Nie można pobrać produktu',
		'delete.produkt_usuniety' => 'Produkt został usuniętu',
		'editBuyedProducts.brak_parametru_id_produktu' => 'Brak parametru id produktu',
		'editBuyedProducts.produkt_nie_istnieje' => 'Edytowany produkt nie istnieje',
		'editBuyedProducts.tytul_modulu' => 'Edytuj produkt',
		'editBuyedProducts.tytul_strony' => 'Edytuj produkt',
		'editproducts.blad_nie_mozna_pobrac_produktu' => 'Nie można pobrać produktu',
		'editproducts.tytul_modulu' => 'Edycja produktu',
		'editproducts.tytul_strony' => 'Edycja produktu',
		'formularz.blad_zapisu_formularz' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione',
		'formularz.blad_zapisu_produktu' => 'Nie udało się zapisać produktu',
		'formularz.kombinacje.etykieta' => 'Kombinacje',
		'formularz.kombinacje.opis' => '',
		'formularz.measureUnit.etykieta' => 'Jednostka miary',
		'formularz.measureUnit.opis' => '',
		'formularz.wstecz.wartosc' => 'Anuluj',
		'formularz.zapisano_produkt' => 'Produkt został zapisany',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.fraza.etykieta' => 'Fraza',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.import.etykieta' => 'Pokaż zaimportowane',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'formularzSzukaj.visible_in_order.etykieta' => 'Typ zamówienia',
		'formularzSzukaj.visible_in_order.opis' => '',
		'formularzSzukaj.visible_in_order_wybierz' => '- wybierz -',
		'gridWyszukaj.etykieta_sortuj_produkty' => 'Sortuj produkty',
		'index.etykieta_brutto_price' => 'Cena brutto',
		'index.etykieta_kolejnosc' => 'Kolejność',
		'index.etykieta_measure_unit' => 'Jednostka miary',
		'index.etykieta_name' => 'Nazwa',
		'index.etykieta_netto_price' => 'Cena netto',
		'index.etykieta_potwierdz_usun' => 'Czy napewno chcesz usunąć wybrany produkt ?',
		'index.etykieta_vat' => 'Vat',
		'index.okno_dodaj_produkt_naglowek' => 'Formularz produktu',
		'index.tabela_etykieta_edytuj' => 'Edytuj',
		'index.tabela_etykieta_usun' => 'Usuń',
		'index.tytul_modulu' => 'Lista produktów',
		'index.tytul_strony' => 'Produkty',
		'products_addProducts.etykietaMenu' => 'Dodaj produkt',
		'products_index.etykietaMenu' => 'Produkty',
		'products_trash.etykietaMenu' => 'Kosz',
		'revert.blad_nie_mozna_pobrac_produktu' => 'Nie można pobrać produktu',
		'revert.etykieta_potwierdz_przywroc' => 'Czy na pewno chcesz przywrócić element z kosza',
		'revert.produkt_etykieta_przywroc' => 'Przywróć',
		'revert.produkt_przywrocony_z_kosza' => 'Prdukt został przywrócony z kosza',
		'sortujProdukty.error_nie_zmieniono_kolejnosci' => 'Wystąpił błąd przy zapisie nowej kolejności produktów',
		'sortujProdukty.etykieta_produkt_glowny' => 'Główny',
		'sortujProdukty.etykieta_produkt_podrzedny' => 'Drugorzędny',
		'sortujProdukty.etykieta_sortowane_produkty' => 'Lista produktów do posortowanie',
		'sortujProdukty.etykieta_wstecz' => 'Anuluj',
		'sortujProdukty.etykieta_zapisz_kolejnosc' => 'Zapisz nową kolejność',
		'sortujProdukty.komunikat_brak_produktow' => 'Lista produktów jest aktualnie pusta.',
		'sortujProdukty.komunikat_zmieniono_kolejnosc' => 'Nowa kolejność produktów została poprawnie zapisana',
		'sortujProdukty.tytul_modulu' => 'Sortowanie produktów',
		'sortujProdukty.tytul_strony' => 'Sortowanie produktów',
		'sortujProdukty.visible_in_puste' => 'Nie widoczny',
		'trash.tytul_modulu' => 'Kosz',
		'trash.tytul_strony' => 'Kosz',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista produktów',
			'wykonajAddProducts' => 'Dodawanie produktów',
			'wykonajDelete' => 'Usówanie produktów',
			'wykonajEditProducts' => 'Edycja produktów',
			'wykonajTrash' => 'Kosz',
			'wykonajRevert' => 'Przywróć z kosza',
			'wykonajSortujProdukty' => 'Sortowanie produktów',
		),
		'formularz.measureUnit_wartosci' => array(
			'm' => 'metr',
			'mb' => 'metr bieżący',
			'szt' => 'sztuka',
			'h' => 'godzina',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}
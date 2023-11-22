<?php
namespace Generic\Tlumaczenie\En\Modul\Products;

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
		'addBuyedProducts.blad_formularza' => 'Not all required form fields have been filled correctly',
		'addBuyedProducts.blad_zapisu_produktu' => 'Product was not saved',
		'addBuyedProducts.brak_parametru_id' => 'Order id is incorrect',
		'addBuyedProducts.produkt_zostal_zapisany' => 'The product has been saved',
		'addBuyedProducts.tytul_modulu' => 'Add product',
		'addBuyedProducts.tytul_strony' => 'Add product',
		'addBuyedProducts.zamowienie_nie_istnieje' => 'You are trying add product to not existing order',
		'addProducts.tytul_modulu' => 'Add product',
		'addProducts.tytul_strony' => 'Add product',
		'delete.blad_nie_mozna_pobrac_produktu' => 'Product does not exist',
		'delete.produkt_usuniety' => 'Product was deleted',
		'editBuyedProducts.brak_parametru_id_produktu' => 'No id products',
		'editBuyedProducts.produkt_nie_istnieje' => 'Edited product does not exist',
		'editBuyedProducts.tytul_modulu' => 'Edit product',
		'editBuyedProducts.tytul_strony' => 'Edit product',
		'editproducts.blad_nie_mozna_pobrac_produktu' => 'Product does not exist',
		'editproducts.tytul_modulu' => 'Edit product',
		'editproducts.tytul_strony' => 'Edit product',
		'formularz.blad_zapisu_formularz' => 'Not all required fields have been correctly filled in',
		'formularz.blad_zapisu_produktu' => 'Failed to save the product',
		'formularz.kombinacje.etykieta' => 'Combinations',
		'formularz.kombinacje.opis' => '',
		'formularz.measureUnit.etykieta' => 'Measure Unit',
		'formularz.measureUnit.opis' => '',
		'formularz.wstecz.wartosc' => 'Cancel',
		'formularz.zapisano_produkt' => 'Product was saved',
		'formularz.zapisz.wartosc' => 'Save ',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.fraza.etykieta' => 'Phrase',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.import.etykieta' => 'Show imported',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'formularzSzukaj.visible_in_order.etykieta' => 'Order type',
		'formularzSzukaj.visible_in_order.opis' => '',
		'formularzSzukaj.visible_in_order_wybierz' => '- select -',
		'gridWyszukaj.etykieta_sortuj_produkty' => 'Reorder products',
		'index.etykieta_brutto_price' => 'Brutto price',
		'index.etykieta_kolejnosc' => 'Order',
		'index.etykieta_measure_unit' => 'Measure unit',
		'index.etykieta_name' => 'Name',
		'index.etykieta_netto_price' => 'Netto price',
		'index.etykieta_potwierdz_usun' => 'Are you sure you want to delete this product?',
		'index.etykieta_vat' => 'Tax',
		'index.okno_dodaj_produkt_naglowek' => 'Add products',
		'index.tabela_etykieta_edytuj' => '',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.tytul_modulu' => 'List of products',
		'index.tytul_strony' => 'List of products',
		'products_addProducts.etykietaMenu' => 'Add products',
		'products_index.etykietaMenu' => 'Products',
		'products_trash.etykietaMenu' => 'Trash',
		'revert.blad_nie_mozna_pobrac_produktu' => 'Product does not exist',
		'revert.etykieta_potwierdz_przywroc' => 'Are you sure you want to restore an item from the trash',
		'revert.produkt_etykieta_przywroc' => 'Restore',
		'revert.produkt_przywrocony_z_kosza' => 'The product has been restored from the trash',
		'sortujProdukty.error_nie_zmieniono_kolejnosci' => 'New products order could not be saved.',
		'sortujProdukty.etykieta_produkt_glowny' => 'Main product',
		'sortujProdukty.etykieta_produkt_podrzedny' => 'Secondary',
		'sortujProdukty.etykieta_sortowane_produkty' => 'List of products',
		'sortujProdukty.etykieta_wstecz' => 'Cancel',
		'sortujProdukty.etykieta_zapisz_kolejnosc' => 'Save new order',
		'sortujProdukty.komunikat_brak_produktow' => 'The products list is empty at the moment.',
		'sortujProdukty.komunikat_zmieniono_kolejnosc' => 'The new products order has beed succesfully saved',
		'sortujProdukty.tytul_modulu' => 'Reorder products',
		'sortujProdukty.tytul_strony' => 'Products reordering',
		'sortujProdukty.visible_in_puste' => 'Not visible',
		'trash.tytul_modulu' => 'Trash',
		'trash.tytul_strony' => 'Trash',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of products',
			'wykonajAddProducts' => 'Add products',
			'wykonajDelete' => ' Delete products',
			'wykonajEditProducts' => 'Edit products',
			'wykonajTrash' => 'Trash',
			'wykonajRevert' => 'Revert products from trash',
			'wykonajSortujProdukty' => 'Reorder products',
		),
		'formularz.measureUnit_wartosci' => array(
			'm' => 'meters',
			'mb' => 'length-meters',
			'szt' => 'pice',
			'h' => 'hour',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}
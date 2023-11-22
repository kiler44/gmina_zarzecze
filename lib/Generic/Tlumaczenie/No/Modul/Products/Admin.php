<?php
namespace Generic\Tlumaczenie\No\Modul\Products;

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
		'addBuyedProducts.blad_formularza' => 'Ikke alle obligatoriske skjemafelt har blitt fylt på riktig måte',
		'addBuyedProducts.blad_zapisu_produktu' => 'Produktet ble ikke lagret',
		'addBuyedProducts.brak_parametru_id' => 'Bestill id er feil',
		'addBuyedProducts.produkt_zostal_zapisany' => 'Produktet har blitt lagret',
		'addBuyedProducts.tytul_modulu' => 'Legg produkt',
		'addBuyedProducts.tytul_strony' => 'Legg produkt',
		'addBuyedProducts.zamowienie_nie_istnieje' => 'Du prøver legge produktet til ikke eksisterende ordre',
		'addProducts.tytul_modulu' => 'Legg produkt',
		'addProducts.tytul_strony' => 'Legg produkt',
		'delete.blad_nie_mozna_pobrac_produktu' => 'Produktet finnes ikke',
		'delete.produkt_usuniety' => 'Produktet ble slettet',
		'editBuyedProducts.brak_parametru_id_produktu' => 'Ingen id produkter',
		'editBuyedProducts.produkt_nie_istnieje' => 'Redigert produktet finnes ikke',
		'editBuyedProducts.tytul_modulu' => 'Redigere produkt',
		'editBuyedProducts.tytul_strony' => 'Redigere produkt',
		'editproducts.blad_nie_mozna_pobrac_produktu' => 'Produktet finnes ikke',
		'editproducts.tytul_modulu' => 'Rediger produkt',
		'editproducts.tytul_strony' => 'Rediger produkt',
		'formularz.blad_zapisu_formularz' => 'Ikke alle obligatoriske felt er korrekt utfylt',
		'formularz.blad_zapisu_produktu' => 'Klarte ikke å redde produktet',
		'formularz.kombinacje.etykieta' => 'Kombinasjoner',
		'formularz.kombinacje.opis' => '',
		'formularz.measureUnit.etykieta' => 'Mål unit',
		'formularz.measureUnit.opis' => '',
		'formularz.wstecz.wartosc' => 'Avbryte',
		'formularz.zapisano_produkt' => 'Produktet ble lagret',
		'formularz.zapisz.wartosc' => 'Lagre',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.fraza.etykieta' => 'Phrase',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.import.etykieta' => 'Vis importert',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'formularzSzukaj.visible_in_order.etykieta' => 'Ordretype',
		'formularzSzukaj.visible_in_order.opis' => '',
		'formularzSzukaj.visible_in_order_wybierz' => '- velg -',
		'gridWyszukaj.etykieta_sortuj_produkty' => 'Endre rekkefølge produkter',
		'index.etykieta_brutto_price' => 'Brutto pris',
		'index.etykieta_kolejnosc' => 'Rekkefølge',
		'index.etykieta_measure_unit' => 'Mål unit',
		'index.etykieta_name' => 'Navn',
		'index.etykieta_netto_price' => 'Netto pris',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette dette produktet?',
		'index.etykieta_vat' => 'Tax',
		'index.okno_dodaj_produkt_naglowek' => 'Legg produkt',
		'index.tabela_etykieta_edytuj' => '',
		'index.tabela_etykieta_usun' => 'Slett',
		'index.tytul_modulu' => 'Liste over produkter',
		'index.tytul_strony' => 'Liste over produkter',
		'products_addProducts.etykietaMenu' => 'Leg produkt',
		'products_index.etykietaMenu' => 'Produkter',
		'products_trash.etykietaMenu' => 'Søppel',
		'revert.blad_nie_mozna_pobrac_produktu' => 'Produktet finnes ikke',
		'revert.etykieta_potwierdz_przywroc' => 'Er du sikker på at du vil gjenopprette et element fra papirkurven',
		'revert.produkt_etykieta_przywroc' => 'Gjenopprett',
		'revert.produkt_przywrocony_z_kosza' => 'Produktet har blitt restaurert fra søpla',
		'sortujProdukty.error_nie_zmieniono_kolejnosci' => 'Produkt ordre kunne ikke lagres.',
		'sortujProdukty.etykieta_produkt_glowny' => 'Hovedprodukt',
		'sortujProdukty.etykieta_produkt_podrzedny' => 'V/annentilk',
		'sortujProdukty.etykieta_sortowane_produkty' => 'Liste over produkter',
		'sortujProdukty.etykieta_wstecz' => 'Avbryt',
		'sortujProdukty.etykieta_zapisz_kolejnosc' => 'Lagre ny rekkefølge',
		'sortujProdukty.komunikat_brak_produktow' => 'Listen produkter er tom for øyeblikket.',
		'sortujProdukty.komunikat_zmieniono_kolejnosc' => 'Den nye produkter rekkefølge er lagret',
		'sortujProdukty.tytul_modulu' => 'Endre rekkefølge produkter',
		'sortujProdukty.tytul_strony' => 'Produkter Re Enderinge',
		'sortujProdukty.visible_in_puste' => 'Ikke synlig',
		'trash.tytul_modulu' => 'Søppel',
		'trash.tytul_strony' => 'Søppel',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Liste over produkter',
			'wykonajAddProducts' => 'Legge et produkt',
			'wykonajDelete' => 'Fjerne produktet',
			'wykonajEditProducts' => 'Rediger produkt',
			'wykonajTrash' => 'Søppel',
			'wykonajRevert' => 'Revert produkter fra søppel',
			'wykonajSortujProdukty' => 'Endre rekkefølge produkter',
		),
		'formularz.measureUnit_wartosci' => array(
			'm' => 'meter',
			'mb' => 'length-meters',
			'szt' => 'pice',
			'h' => 'time',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}
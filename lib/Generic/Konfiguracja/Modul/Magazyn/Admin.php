<?php

namespace Generic\Konfiguracja\Modul\Magazyn;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['formularz.lista_tak_nie']
 * @property string $k['formularz.wymagane_pola']
 */
class Admin extends Konfiguracja {

	protected $konfiguracjaDomyslna = array(
		'index.domyslne_sortowanie' => array(
			'opis' => '',
			'typ' => 'select',
			'wartosc' => 'id',
			'dozwolone' => array(
				0 => 'id',
				1 => 'data',
			),
		),
		'listaPrzyjec.domyslne_sortowanie' => array(
			'opis' => '',
			'typ' => 'select',
			'wartosc' => 'id',
			'dozwolone' => array(
				0 => 'id',
				1 => 'data_dodania',
			),
		),
		'szablon.formularz_wyszukiwarka' => array(
			'opis' => '',
			'typ' => 'varchar',
			'wartosc' => 'formularz_grid.tpl',
		),
		'index.pager_konfiguracja' => array(
			'opis' => 'Konfiguracja stronnicowania',
			'typ' => 'pager',
			'wartosc' => array(
				'zakres' => 5,
				'wyborStrony' => 'linki',
				'wyborZakresu' => 'select',
				'skoczDo' => 'form',
				'pierwszaOstatnia' => 1,
				'poprzedniaNastepna' => 1,
			),
		),
		'listaPrzyjec.pager_konfiguracja' => array(
			'opis' => 'Konfiguracja stronnicowania',
			'typ' => 'pager',
			'wartosc' => array(
				'zakres' => 5,
				'wyborStrony' => 'linki',
				'wyborZakresu' => 'select',
				'skoczDo' => 'form',
				'pierwszaOstatnia' => 1,
				'poprzedniaNastepna' => 1,
			),
		),
		'listaPrzyjec.wierszy_na_stronie' => array(
			'maks' => '100',
			'opis' => 'Ilość wierszy na stronie w liście użytkowników',
			'typ' => 'int',
			'wartosc' => 10,
		),
		'stworzPdf.sciezka_do_mPDF' => array(
			'opis' => 'Ścieżka do biblioteki zewnetrznej mPDF',
			'typ' => 'varchar',
			'wartosc' => '../lib/Mpdf/mpdf.php',
		),
		'index.wierszy_na_stronie' => array(
			'maks' => '100',
			'opis' => 'Ilość wierszy na stronie w liście użytkowników',
			'typ' => 'int',
			'wartosc' => 10,
		),
		'formularz.lista_tak_nie' => array(
			'opis' => 'Parametry dla formularza dodawanie/edytowania kategorii',
			'typ' => 'array',
			'wartosc' => array(
				0 => 'Nie',
				1 => 'Tak',
			),
		),
		'parsujPojedynczyWierszWyszukiwania.prefix_miniaturka' => array(
			'opis' => '',
			'typ' => 'varchar',
			'wartosc' => 'xs-',
		),
		'parsujPojedynczyWierszWyszukiwania.prefix_podglad' => array(
			'opis' => '',
			'typ' => 'varchar',
			'wartosc' => '',
		),
		'koszyk.prefix_miniaturka' => array(
			'opis' => '',
			'typ' => 'varchar',
			'wartosc' => 'min-',
		),
		'formularz.wymagane_pola' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				0 => 'nazwa',
				1 => 'kod',
				2 => 'blokujPrzypisywanie',
				3 => 'blokujWyswietlanie',
				4 => 'filtr18',
			),
		),
		'formularz.zalaczniki_dozwolone_pliki' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				'jpg',
				'gif',
				'png',
				'pdf',
				'xlsx',
				'xls',
				'doc',
				'docx',
			),
		),
		'formularz.rozmiary_miniaturek_zdjecia' => array(
			'opis' => 'Rozmiary tworzonych miniaturek.',
			'systemowy' => '1',
			'typ' => 'miniatury',
			'wartosc' => array(
				'' => '800.600.scale',
				'mid' => '420.320.crop',
				'min' => '60.60.crop',
				'xs' => '45.45.crop',
			),
		),
		'formularz.prefix_miniatury_podgladu' => array(
			'opis' => 'Rozmiar podglądu przy inpucie zdjęcia',
			'systemowy' => '1',
			'typ' => 'varchar',
			'wartosc' => 'mid',
		),
		'formularzProduktyDodaj.wymagane_pola' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				0 => 'nazwaProduktu',
				1 => 'kategoria',
				2 => 'status',
				3 => 'kod',
			),
		),
		'formularzProduktyDodaj.ukryj_pola' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
			),
		),
		'uprawnienia_atrybuty_produktu' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				'publiczne', 'uzytkownik', 'pracownik_biurowy', 'wlasciciel_grupy' , 'osoba_wydajaca', 'osoba_dodajaca_produkt'
			),
		),
		'hierarachia_uprawnien' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				'publiczne' => 'publiczne',
				'uzytkownik' => 'publiczne, uzytkownik',
				'pracownik_biurowy' => 'publiczne, uzytkownik, pracownik_biurowy',
				'osoba_wydajaca' => 'publiczne, uzytkownik, pracownik_biurowy, osoba_wydajaca',
				'wlasciciel_grupy' => 'publiczne, uzytkownik, pracownik_biurowy, osoba_wydajaca, wlasciciel_grupy',
				'osoba_dodajaca_produkt' => 'publiczne, uzytkownik, pracownik_biurowy, osoba_wydajaca, wlasciciel_grupy, osoba_dodajaca_produkt',
			)
		),
		'magazyn.wyszukiwarka_wierszy_na_stronie' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => '10',
		),
		'pobierzWynikiSzukaj.iloscZnakow' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 2,
		),
		'role_opiekunow_kategorii_prodoktow' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				'storekeeper',
			),
		),
		'pobierzWynikiSzukaj.pager_konfiguracja' => array(
			'opis' => 'Konfiguracja stronnicowania',
			'typ' => 'pager',
			'wartosc' => array(
				'zakres' => 5,
				'wyborStrony' => 'linki',
				'wyborZakresu' => 'select',
				'skoczDo' => 'form',
				'pierwszaOstatnia' => 1,
				'poprzedniaNastepna' => 1,
			),
		),
		'parsujPojedynczyWierszWyszukiwania.id_kategorii_nie_pokazuj_uzytkownikowi' => array(
			'opis' => 'Produkty z tych kategorii nie będą wyświetlane uzytkownikowi podczas zamawiania',
			'typ' => 'list',
			'wartosc' => array(
				
			),
		),
		'wyslijEmailZMojeZamowienie.id_email_do_akceptacji' => array(
			'opis' => 'Email wysyłany do opiekunów z zamówieniem złożonym przez pracownika',
			'typ' => 'mail',
			'wartosc' => '33',
		),
		'wyslijEmailZamowienieAnulowane.id_email_anulowane' => array(
			'opis' => 'Zamowienie anulowane przez opiekuna',
			'typ' => 'mail',
			'wartosc' => '33',
		),
		'wyslijEmailZamowienieZaakceptowane.id_email_zaakceptowane' => array(
			'opis' => 'Zamowienie anulowane przez opiekuna',
			'typ' => 'mail',
			'wartosc' => '33',
		),
		'wyslijEmailZamowienieDoOdbioru.id_email_zamowienie_do_odbioru' => array(
			'opis' => 'Zamowienie anulowane przez opiekuna',
			'typ' => 'mail',
			'wartosc' => '33',
		),
		'zwrocProdukty.stanProduktu' => array(
			'opis' => 'lista określająca stan zwracanych produktów',
			'typ' => 'list',
			'wartosc' => array(
				'nowy',
				'uzywany',
				'zniszczone_uzytkownik',
				'kosz',
				'zgubiony',
				'serwis',
			),
		),
		'zwrocProdukty.stanProduktuKosz' => array(
			'opis' => 'lista określająca który stan produktu nie nadaje sie do zwrotu',
			'typ' => 'list',
			'wartosc' => array(
				'zniszczone_uzytkownik',
				'kosz',
				'zgubiony'
			),
		),
		'zwrocProdukty.stanProduktuSerwis' => array(
			'opis' => 'lista określająca który stan produktu przenosi produkt do serwisu',
			'typ' => 'list',
			'wartosc' => array(
				'serwis',
			),
		),
		'zwrocProdukty.kategoria_produkty_niepelne' => array(
			'opis' => 'kategoria do której będą przypisywane wszystkie produkty niekompletne',
			'typ' => 'int',
			'wartosc' => '33',
		),
		'zwrocProdukty.kategoria_produkty_serwis' => array(
			'opis' => 'kategoria do której będą przypisywane wszystkie produkty do naprawy',
			'typ' => 'int',
			'wartosc' => '34',
		),
		'parsujPojedynczyWierszWyszukiwania.blokujSpinner' => array(
			'opis' => 'ustawia wartos readonly na true przy produktach spinner',
			'typ' => 'bool',
			'wartosc' => 'true',
		),
		'index.domyslny_status' => array(
			'opis' => 'Domyslny status wyswietlanych zamówień',
			'typ' => 'varchar',
			'wartosc' => 'oczekuje',
		),
		'ustawZakladki.nie_wyswietlaj_mobilnie' => array(
			'opis' => 'Lista zakładek które nie będą wyświetlane na urządzeniach mobilnych',
			'typ' => 'list',
			'wartosc' => array('produkty', 'listaPrzyjec', 'kategorie'),
		),
	);

}

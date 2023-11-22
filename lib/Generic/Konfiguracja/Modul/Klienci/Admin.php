<?php
namespace Generic\Konfiguracja\Modul\Klienci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property int $k['index.wyswietlaj_drzewo']
 * @property int $k['index.wyswietlaj_dzieci_nowy_widok']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'name',
		'dozwolone' => array(
			0 => 'name',
			1 => 'company_name',
			),
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

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'index.wyswietlaj_drzewo' => array(
		'opis' => 'wyświetla liste klientów jako drzewo',
		'typ' => 'bool',
		'wartosc' => true,
		),

	'index.wyswietlaj_dzieci_nowy_widok' => array(
		'opis' => 'wyświetla liste klientów głównych',
		'typ' => 'bool',
		'wartosc' => true,
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
		
	'formularz.company.usun_pola' => array(
		'opis' => 'Lista pól które nie będą wyświetlać się w formularzu typu company',
		'typ' => 'list',
		'wartosc' => array(
			'idCustomer'
		)
	),
	 
	'formularz.wymagane_pola_private' => array(
		'opis' => 'Możliwe typy dzieci dla rodzica typu private',
		'typ' => 'list',
		'wartosc' => array(
			 0 => '0'
		),
	),
	
	'formularz.private.typy_dzieci' => array(
		'opis' => 'Możliwe typy dzieci dla rodzica typu private',
		'typ' => 'array',
		'wartosc' => array(
			 0 => '0'
		),
	),
		
	'formularz.company.typy_dzieci' => array(
		'opis' => 'Możliwe typy dzieci dla rodzica typu company',
		'typ' => 'array',
		'wartosc' => array(
			'branch contact person' => 'branch contact person',
		),
	),
		
	'formularz.developer.typy_dzieci' => array(
		'opis' => 'Możliwe typy dzieci dla rodzica typu developer',
		'typ' => 'array',
		'wartosc' => array(
			'branch contact person' => 'branch contact person',
			'company' => 'company',
		),
	),
	
	'formularz.branch_contact_person.typy_dzieci' => array(
		'opis' => 'Możliwe typy dzieci dla rodzica typu branch contact person',
		'typ' => 'array',
		'wartosc' => array(
			 0 => '0'
		),
	),	
		
	'formularz.private.domyslny_typ' => array(
		'opis' => 'Domyślny typ klienta dla rodzica private',
		'typ' => 'select',
		'wartosc' => 'private',
		'dozwolone' => array(
			0 => 0,
			'company' => 'company',
			'developer' => 'developer',
			'private' => 'private',
			'branch contact person' => 'branch contact person',
		),
	),
	'formularz.company.domyslny_typ' => array(
		'opis' => 'Domyślny typ klienta dla rodzica company',
		'typ' => 'select',
		'wartosc' => 'branch contact person',
		'dozwolone' => array(
			0 => 0,
			'company' => 'company',
			'developer' => 'developer',
			'private' => 'private',
			'branch contact person' => 'branch contact person',
		),
	),
	'formularz.developer.domyslny_typ' => array(
		'opis' => 'Domyślny typ klienta dla rodzica developer',
		'typ' => 'select',
		'wartosc' => 'company',
		'dozwolone' => array(
			0 => 0,
			'company' => 'company',
			'developer' => 'developer',
			'private' => 'private',
			'branch contact person' => 'branch contact person',
		),
	),
	'formularz.branch_contact_person.domyslny_typ' => array(
		'opis' => 'Domyślny typ klienta dla rodzica branch contact person',
		'typ' => 'select',
		'wartosc' => 'branch contact person',
		'dozwolone' => array(
			0 => 0,
			'company' => 'company',
			'developer' => 'developer',
			'private' => 'private',
			'branch contact person' => 'branch contact person',
		)
	),
	'formularz.wymagane_wartosci_dla_private' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'name' => true, 
			'surname' => true , 
		)
	),
	'formularz.wymagane_wartosci_dla_company' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'companyName' => true,
		)
	),
	'formularz.wymagane_wartosci_dla_developer' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'companyName' => true,
		)
	),
	'formularz.wymagane_wartosci_dla_branch_contact_person' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'address' => false,
			'postcode' => false,
			'city' => false,
			'kostsenter' => true,
		),
		'opis' => '',
		'typ' => 'array',
	),
	'formularz.ajax' => array(
		'opis' => 'Wyświetla w formularzu dodakowe pole idParent',
		'typ' => 'bool',
		'wartosc' => false,
	),
	'formularz.ograniczenia_dla_idParent' => array(
		'opis' => 'typy klientów jacy mają wyświetlać się w polu idParent',
		'typ' => 'list',
		'wartosc' => array(
			'\'company\'', '\'developer\''
		)
	),
	'formularz.pokaz_ukryj_pola_dla_private' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'companyName' => 'hide',
			'orgNumber' => 'hide',
			'idCustomer' => 'show',
			'name' => 'show',
			'secondName' => 'show',
			'surname' => 'show',
		)
	),
	'formularz.zabron_edycji_zablokowani' => array(
		'opis' => '',
		'typ' => 'lista',
		'wartosc' => array(
			'type', 'idCustomer', 'companyName', 'orgNumber', 
		)
	),
	'editCustomer.id_typu_nie_zmieniaj_nazwy_zamowienia' => array(
		'opis' => 'Id typów zamówień dla których nie zmieniamy order_name jeśli klient jest edytowany',
		'typ' => 'list',
		'wartosc' => array(3, 4, 17, 23, 30, 31, 34),
	),
	'formularz.zabron_edycji_klienta' => array(
		'opis' => 'Id klientów zabroń edycji',
		'typ' => 'list',
		'wartosc' => array(1),
	),
	'formularz.kostsenter_opcje' => array(
			'typ' => 'array',
			'wartosc' => array(
				'' => '- || -',
				'420-Installasjon' => '420-Installasjon',
				),
		),
	);
}

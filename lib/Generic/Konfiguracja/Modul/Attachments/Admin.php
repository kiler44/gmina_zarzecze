<?php
namespace Generic\Konfiguracja\Modul\Attachments;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property string $k['index.pager_konfiguracja']
 * @property string $k['index.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'object',
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

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
	'previewobject.akcja_podgladu_objektu' => array(
		'opis' => 'Akcja podglądu dla obijektu',
		'typ' => 'array',
		'wartosc' => array(
            'ZamowieniaBm' => 'podglad'
		),
	),
	'obiekt_nazwa_mappera' => array(
		'opis' => 'Nazwa mappera dla danego obiektu',
		'typ' => 'array',
		'wartosc' => array(
			'orders' => 'Zamowienie',
			'klient' => 'Klient',
			'reports' => 'Reports',
			'faktura' => 'Faktura',
            'zamowieniabm' => 'ZamowieniaBm',
            'produktymagazyn' => 'ProduktyMagazyn'
		),
	),
	'obiekt_nazwa_metody_mappera' => array(
		'opis' => 'Nazwa metody mappera dla danego obiektu (do metody zostanie przekazany parametr tablica z wiele id obiektów)',
		'typ' => 'array',
		'wartosc' => array(
			'ZamowieniaBm' => 'pobierzPoWieleId',
			'ProduktyMagazyn' => 'pobierzPoWieleId',
			'Klient' => 'pobierzPoWieleId',
			'Reports' => 'pobierzPoWieleId',
			'Faktura' => 'pobierzPoWieleId',
		),
	),
	'obiekt_kolumna_nazwa' => array(
		'opis' => 'Kolumna zawierająca wyświetlaną nazwę',
		'typ' => 'array',
		'wartosc' => array(
			'ZamowieniaBm' => 'id',
			'ProduktyMagazyn' => 'id',
			'Klient' => 'name',
			'Reports' => 'kategoria',
			'Faktura' => 'nazwaFaktury',
		),
	),
	
	);
}

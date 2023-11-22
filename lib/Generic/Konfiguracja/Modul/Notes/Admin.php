<?php
namespace Generic\Konfiguracja\Modul\Notes;

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
		'wartosc' => 'data_added',
		'dozwolone' => array(
			0 => 'object',
			1 => 'id_object',
			2 => 'description',
			3 => 'data_added',
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
		'wartosc' => 5,
		),

	'formularz.wymagane_pola' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'description',
		)
	),
	'objekty_notatek'	 => array(
		'opis' => 'Lista objektów do których można przypisać notatki',
		'typ' => 'array',
		'wartosc' => array(
			'zamowienie', 'zalacznik', 'klient', 'zamowieniabm'
		),
	),
	'obiekt_nazwa_mappera' => array(
		'opis' => 'Nazwa mappera dla danego obiektu',
		'typ' => 'array',
		'wartosc' => array(
			'zamowienie' => 'Zamowienie',
			'klient' => 'Klient',
            'zamowieniabm' => 'ZamowieniaBm'
		),
	),
	'obiekt_nazwa_metody_mappera' => array(
		'opis' => 'Nazwa metody mappera dla danego obiektu (do metody zostanie przekazany parametr tablica z wiele id obiektów)',
		'typ' => 'array',
		'wartosc' => array(
			'Zamowienie' => 'pobierzPoWieleId',
			'Klient' => 'pobierzPoWieleId',
            'ZamowieniaBm' => 'pobierzPoWieleId'
		),
	),
	'obiekt_kolumna_nazwa' => array(
		'opis' => 'Kolumna zawierająca wyświetlaną nazwę',
		'typ' => 'array',
		'wartosc' => array(
			'Zamowienie' => 'orderName',
			'Klient' => 'name, surname',
            'ZamowieniaBm' => 'id',
		),
	),
	'previewobject.akcja_podgladu_objektu' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'zamowienie' => 'editOrder',
			'klient' => 'editCustomer',
            'zamowieniaBm' => 'podglad'
		),
	),
	'previewobject.modul_dla_modelu' => array(
		'opis' => 'Nazwa modułu w którym istnieje akcji dla podglądu dla modelu',
		'typ' => 'array',
		'wartosc' => array(
			'zamowienie' => 'Orders',
			'klient' => 'Klienci',
            'zamowieniaBm' => 'ZamowieniaBm'
		),
	),
	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
	'index.grid_format_daty_dodania' => array(
		'opis' => 'Format daty',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),
	);
}

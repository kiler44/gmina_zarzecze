<?php
namespace Generic\Konfiguracja\Modul\Kalendarz;

use Generic\Konfiguracja\Konfiguracja;

/**
 * Zawiera konfigurację dla Generic\Modul\Kalendarz\Admin
 *
 */
class Http extends Konfiguracja
{
	/**
	* Domyślna konfiguracja
	* @var array
	*/
	protected $konfiguracjaDomyslna = array(
		'szukajZamowienie.id_typu_zamowienia' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				4,
			),
		),
		'konfiguracja.zakresDatStart' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '-|7|day',
		),
		'konfiguracja.zakresDatStop' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '+|7|day',
		),
		'konfiguracja.zakresDatSuwakStart' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '-|7|day',
		),
		'konfiguracja.zakresDatSuwakStop' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '+|3|month',
		),
		'konfiguracja.ilosc_wyswietlanych_teamow' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'int',
			'wartosc' => 10,
		),
		'konfiguracja.grupy_teamow' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'array',
			'wartosc' => array(
				'all' => 'All team',
				'villa' => 'Villa group',
				'project' => 'Project group',
				'digging' => 'Digging group',
			),
		),
		'konfiguracja.domyslna_grupa' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => 'all',
		),
		'konfiguracja.kolejnosc_wyswietlania_teamow_grupa' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'array',
			'wartosc' => array(
				'all' => '|2|3|4|5|6|7|8|9|11|12|14|17|18|19|20|23|24|25|26|27|28|30|31|32|33|34|35|36|37|38|39|40|41|42|43|',
				'villa' => '|2|3|4|5|6|7|8|9|11|12|14|17|18|19|20|23|24|25|26|27|28|30|31|32|33|34|35|36|37|38|39|40|41|42|43|',
				'project' => '|2|3|4|5|6|7|8|9|11|12|14|17|18|19|20|23|24|25|26|27|28|30|31|32|33|34|35|36|37|38|39|40|41|42|43|',
				'digging' => '|2|3|4|5|6|7|8|9|11|12|14|17|18|19|20|23|24|25|26|27|28|30|31|32|33|34|35|36|37|38|39|40|41|42|43|',
			),
		),
		'index.dodajEvent_domyslny_typ_eventy' => array(
			'opis' => 'Domyślna zakładka przy dodawaniu eventu',
			'typ' => 'varchar',
			'wartosc' => 'Projekty',
		),
	);
}
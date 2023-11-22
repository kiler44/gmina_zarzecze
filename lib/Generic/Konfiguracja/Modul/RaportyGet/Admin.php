<?php
namespace Generic\Konfiguracja\Modul\RaportyGet;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['doCsvRaport.naglowek_kolor_czcionki']
 * @property string $k['doCsvRaport.naglowek_kolor_tla']
 * @property string $k['doCsvRaport.wiersz_nieparzysty_kolor_tla']
 * @property string $k['doCsvRaport.wiersz_parzysty_kolor_tla']
 * @property array $k['index.kryterium_status']
 * @property array $k['index.kryterium_status_zamowien']
 * @property string $k['listaApartamentow.kolor_done']
 * @property string $k['listaApartamentow.kolor_in_progress']
 * @property string $k['listaApartamentow.kolor_not_done']
 * @property string $k['projektyZapartamentami.date_added_od']
 * @property string $k['projektyZapartamentami.sorter_domyslny']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'doCsvRaport.naglowek_kolor_czcionki' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => 'white',
		),

	'doCsvRaport.naglowek_kolor_tla' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => '61',
		),

	'doCsvRaport.wiersz_nieparzysty_kolor_tla' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => 'white',
		),

	'doCsvRaport.wiersz_parzysty_kolor_tla' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => '60',
		),

	'index.kryterium_status' => array(
		'opis' => 'Statusy zadań które mają wyświetlać się na liście',
		'typ' => 'list',
		'wartosc' => array(
			'open',
			'active',
			),
		),

	'index.kryterium_status_zamowien' => array(
		'opis' => 'Statusy work_status zadań które mają wyświetlać się na liście',
		'typ' => 'list',
		'wartosc' => array(
			'new',
			'in progress',
			),
		),

	'listaApartamentow.kolor_done' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '#5bb75b',
		),

	'listaApartamentow.kolor_in_progress' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '#FFBC70',
		),

	'listaApartamentow.kolor_not_done' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '#CCCCCC',
		),

	'projektyZapartamentami.date_added_od' => array(
		'opis' => 'data od jakiej będą wyswietlane projekty',
		'typ' => 'varchar',
		'wartosc' => '2018-04-01',
		),

	'projektyZapartamentami.sorter_domyslny' => array(
		'opis' => 'sorter domyslny',
		'typ' => 'varchar',
		'wartosc' => 'date_start',
		),

	);
}

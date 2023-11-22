<?php
namespace Generic\Konfiguracja\Modul\UzytkownicyZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['emailAktywacyjny.id_formatki_email']
 * @property string $k['formularz.walidacja_loginu']
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property array $k['formularz.rozmiary_miniaturek_zdjecia']
 * @property string $k['formularz.prefix_miniatury_podgladu']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['usun.rola_przedstawiciel']
 * @property array $k['formularz.rozmiary_miniaturek_zdjecia']
 * @property array $k['formularz.available_skills']
 * @property array $k['emailAktywacyjny.link_do_ustawienia_hasla']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'emailAktywacyjny.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 34,
	),
		
	'emailAktywacyjny.link_do_ustawienia_hasla' => array(
		'opis' => 'Jeśli zaznaczone w emailu aktywacyjnym zostanie wysłany link do utworzenia hasła',
		'typ' => 'bool',
		'wartosc' => true,
	),
		
	'formularz.walidacja_loginu' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '/^[a-z][.-_a-z0-9]{2,32}$/',
	),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'login',
			'haslo',
			'hasloPowtorz',
			'jezyk',
			'imie',
			'nazwisko',
			'email',
		),
	),
		
	'formularz.available_skills' => array(
		'opis' => 'List of skills - Warning! dont mess the codes!!!',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Digging',
			1 => 'Villa installation',
			2 => 'B2B',
			3 => 'Fiber installation villa',
			4 => 'Fiber installation new building',
			5 => 'Fiber installation existing building',
			6 => 'Fiber network outside',
			7 => 'Coax new building',
			8 => 'Coax existing building',
			9 => 'Node',
			10 =>	'Speaks english/norwegian',
			11 => 'Speaks norwegian',
			12 => 'Speaks english',
			13 => 'High personal culture',
			14 => 'Trusted',
			15 => 'Can take reclamations',
		),
	),
	
	'formularz.rozmiary_miniaturek_zdjecia' => array(
		'opis' => 'Rozmiary tworzonych miniaturek.',
		'systemowy' => '1',
		'typ' => 'miniatury',
		'wartosc' => array(
			'' => '800.600.scale',
			'mid' => '200.200.crop',
			'min' => '120.120.crop',
			'xs' => '30.30.crop',
		),
	),
		
	'formularz.prefix_miniatury_podgladu' => array(
		'opis' => 'Rozmiar podglądu przy inpucie zdjęcia',
		'systemowy' => '1',
		'typ' => 'varchar',
		'wartosc' => 'min',
	),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'login',
		'dozwolone' => array(
			'0' => 'login',
			1 => 'email',
			2 => 'imie',
			3 => 'nazwisko',
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

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
	),
		
	'dodaj.domyslne_role' => array(
		'opis' => 'Role, które będą domyślnie zaznaczone przy tworzeniu nowego użytkownika',
		'typ' => 'list',
		'wartosc' => array(
			'user',
		),
	),
	'plikiUzytkownika.kod_roli' => array(
		'opis' => 'Role, które będą domyślnie zaznaczone przy dodawaniu pliku',
		'typ' => 'list',
		'wartosc' => array(
			'boss', 'user_files'
		),
	),
	);
}

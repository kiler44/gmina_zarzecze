<?php
namespace Generic\Konfiguracja\Modul\Reports;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		
	'googleDistanceMartix_API_key' => array(
		'opis' => 'Google maps API key',
		'typ' => 'varchar',
		'wartosc' => 'AIzaSyASnax5K6d7bcFAnYBCHvi604WskpZxbRE',
		),
	'googleDistanceMartix_API_keys' => array(
		'opis' => 'Google maps API key',
		'typ' => 'list',
		'wartosc' => array(
			'AIzaSyASnax5K6d7bcFAnYBCHvi604WskpZxbRE',
			),
		),
	'googleDistanceMartix_API__day_limit' => array(
		'opis' => 'limitation for each day retrieved distances',
		'typ' => 'int',
		'wartosc' => 250,
		),
	'zapiszDzien.idTypowZamowien' => array(
		'opis' => 'ID typów zamówień branych do raportu excel',
		'typ' => 'array',
		'wartosc' => array(
			0 => 1,
			),
		),
	'zapiszDzien.zamowieniaStatusy' => array(
		'opis' => 'Statusy zamówień branych do Raportu excel',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'closed',
			),
		),

	'zapiszDzien.zamowieniaWorkStatusy' => array(
		'opis' => 'Statusy pracy zamówień branych do Raportu excel',
		'typ' => 'list',
		'wartosc' => array(
			'done',
			'not done',
			),
		),
	
	'zapiszDzien.rodzaj_estymacji_trasy' => array(
		'opis' => 'Rodzaj estymacji trasy w Google Distance Matrix',
		'typ' => 'select',
		'wartosc' => 'pessimistic',
		'dozwolone' => array(
			0 => 'best_guess',
			1 => 'optimistic',
			2 => 'pessimistic',
			),
		),
	'zapiszDzien.godzina_startu_pracy' => array(
		'opis' => 'Godzina o której firma startuje pracę',
		'typ' => 'varchar',
		'wartosc' => '07:30:00',
		),
		
	'zapiszDzien.plik_ostatniej_pobieranej_daty' => array(
		'opis' => 'Plik, jeśli istnieje cron bedzie pobierał kolejne dni',
		'typ' => 'varchar',
		'wartosc' => 'last_fetched_date.txt',
		),
	
	);
	
}

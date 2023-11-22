<?php
namespace Generic\Konfiguracja\Modul\WidokPoczatkowy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.data_format']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'index.data_format' => array(
			'opis' => '',
			'typ' => 'varchar',
			'wartosc' => 'Y-m-d H:i',
		),
		'index.rola_procownika' => array(
			'opis' => 'Rola lidera - podstawowe menu',
			'typ' => 'varchar',
			'wartosc' => 'worker',
		),
		'index.rola_get' => array(
			'opis' => 'Rola GET',
			'typ' => 'varchar',
			'wartosc' => 'get',
		),
		'index.rola_lider_bkt_projekt' => array(
			'opis' => 'Rola lidera BKT projektów',
			'typ' => 'varchar',
			'wartosc' => 'ProjectLeaderBkt',
		),
		'index.prefix_zdjecia_pracownikow' => array(
			'opis' => 'Prefix dla zdjęć pracowników teamu',
			'typ' => 'varchar',
			'wartosc' => 'min',
		),
		'projektyZapartamentami.date_added_od' => array(
			'opis' => 'data od jakiej będą wyswietlane projekty',
			'typ' => 'varchar',
			'wartosc' => '2018-04-01',
		),
	);
}

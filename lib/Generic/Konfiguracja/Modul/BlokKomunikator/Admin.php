<?php
namespace Generic\Konfiguracja\Modul\BlokKomunikator;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.zdjecia_pracownikow_przedrostek']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.zdjecia_pracownikow_przedrostek' => array(
		'opis' => 'Prefix zdjęć pracowników',
		'typ' => 'varchar',
		'wartosc' => 'min',
		),

	);
}

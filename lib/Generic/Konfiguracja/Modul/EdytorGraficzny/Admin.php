<?php
namespace Generic\Konfiguracja\Modul\EdytorGraficzny;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['wielkosc_miniatury']
 * @property string $k['plikSzablonuEdytora']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'wielkosc_miniatury' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'szerokosc' => 90,
			'wysokosc' => 90,
			),
		),
	'plikSzablonuEdytora' => array(
		'typ' => 'varchar',
		'wartosc' => 'szablon_edytor_graficzny.tpl',
	),
	);
}

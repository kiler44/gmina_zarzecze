<?php
namespace Generic\Konfiguracja\Modul\Platnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property bool $k['nowa.wybor_typu_platnosci']
 * @property string $k['szablon.formularz']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'nowa.wybor_typu_platnosci' => array(
		'opis' => 'Czy wyświetlać listę dostępnych rodzajów płatności (banki/karty)',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'szablon.formularz' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_konto_uzytkownika_nowe_mini.tpl',
		),

	);
}
